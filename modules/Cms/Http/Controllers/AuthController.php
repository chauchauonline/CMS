<?php
namespace Modules\Cms\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Modules\Cms\Http\Controllers\BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Mail;
use Reminder;
use Illuminate\Support\Facades\Config;

class AuthController extends BaseController {

    /**
    * Show the form for logging the user in.
    *
    * @return \Illuminate\View\View
    */
    public function login()
    {
        return View::make('cms::sentinel.login');
    }

    /**
    * Handle posting of the form for logging the user in.
    *
    * @return \Illuminate\Http\RedirectResponse
    */
    public function processLogin(Request $request)
    {
        try
        {
            $input = $request->all();

            $rules = [
                'login'    => 'required|min:3',
                'password' => 'required|min:6',
            ];

            $validator = Validator::make($input, $rules);

            if ($validator->fails())
            {
                return Redirect::back()
                        ->withInput()
                        ->withErrors($validator);
            }

            $remember = (bool) $request->get('remember', false);

            if (Sentinel::authenticate($input, $remember))
            {
                $user = Sentinel::getUser();
                if($user->inRole('admin')) {
                    return Redirect::to('account');
                } else {
                    return Redirect()->route('site.index');
                }
            }

            $errors = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }
        catch (NotActivatedException $e)
        {
            $errors = 'Tài khoản của bạn chưa được kích hoạt!';
        }
        catch (ThrottlingException $e)
        {
            $delay = $e->getDelay();
            $errors = "Tài khoản của bạn bị block trong vòng {$delay} giây.";
        }
        return Redirect::back()->withInput()->withErrors($errors);
    }

    /**
     * Show the form for the user registration.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return View::make('cms::sentinel.register');
    }

    /**
     * Handle posting of the form for the user registration.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRegistration(Request $request)
    {
        $input = $request->all();

        $rules = [
                'first_name'    => 'required|max:50',
                'last_name'     => 'required|max:100',
                'company_name'  => 'required|max:100',
                'mobile'    => 'required|regex: /^[0-9+]*$/|min:8|max:15|unique:users',
                'email'            => 'required|email|unique:users',
                'password'         => 'required|min:6',
                'password_confirm' => 'required|same:password',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if ($user = Sentinel::register($input))
        {
            return Redirect::to('login')->withSuccess('Tài khoản đã được tạo. Vui lòng đợi admin xác nhận.');
        }
        return Redirect::to('register')->withInput()->withErrors('Đăng ký không thành công.');
    }

    public function resetPassword()
    {
        return View::make('cms::sentinel.reset.sendEmail');
    }

    public function sendCodeResetPassword(Request $request)
    {
        $rules = [
                'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $email = $request->get('email');
        $user = Sentinel::findByCredentials(compact('email'));

        if ( ! $user)
        {
            return Redirect::back()->withInput()->withErrors(['email'=>'Không tìm thấy thành viên có email này.']);
        }

        $reminder = Reminder::exists($user) ?: Reminder::create($user);
        $code = $reminder->code;

        $sent = Mail::send('cms::sentinel.emails.reminder', compact('user', 'code'), function($m) use ($user)
        {
            $m->to($user->email)->subject('Lấy lại mật khẩu.');
        });

        if ($sent === 0)
        {
            return Redirect::to('register')->withErrors(['email'=>'Gửi email lấy lại mật khẩu không thành công.']);
        }
        return Redirect::to('login')->withSuccess("Vui lòng kiểm tra email để nhận hướng dẫn tiếp theo!");
    }

    public function processResetPassword($id, $code)
    {
        $user = Sentinel::findById($id);
        return View::make('cms::sentinel.reset.enterNewPassword');
    }

    public function confirmNewPassword(Request $request, $id, $code)
    {
        $rules = [
                'password' => 'required',
                'password_confirmation' => 'required|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $user = Sentinel::findById($id);
        if ( ! $user) {
            return Redirect::back()->withInput()->withErrors('Thành viên không tồn tại');
        }
        if ( ! Reminder::complete($user, $code, $request->get('password'))) {
            return Redirect::to('login')->withErrors('Mã reset password không hợp lệ');
        }

        return Redirect::to('login')->withSuccess("Đặt mật khẩu mới thành công.");
    }

    public function activate($id)
    {
        $login_url = Config::get('constants.LOGIN_URL');
        $user = Sentinel::findById($id);
        if ( ! $user) {
            return Redirect::back()->withErrors('Hội viên không tồn tại');
        }

        if(Activation::completed($user)) {
            return Redirect::back()->withErrors('Tài khoản của hội viên này đã được kích hoạt');
        } else {
            $activation = Activation::create($user);
            $active = Activation::complete($user, $activation->code);
            if($active){
                $login_url = Config::get('constants.LOGIN_URL');
                // Gửi email thông báo
                $sent = Mail::send('cms::sentinel.emails.activate', ['user' => $user, 'login_url' => $login_url], function($m) use ($user) {
                    $m->to($user->email)->subject('Kích hoạt tài khoản');
                });
                if ($sent === 0){
                    return Redirect::to('register')->withErrors('Đã kích hoạt tài khoản. Chưa gửi được email thông báo.');
                }
                return Redirect::back()->withSuccess('Kích hoạt tài khoản thành công.');
            } else {
                return Redirect::back()->withErrors('Kích hoạt tài khoản không thành công.');
            }
        }
    }

    public function lock($id)
    {
        $user = Sentinel::findById($id);
        if ( ! $user) {
            return Redirect::back()->withErrors('Hội viên không tồn tại');
        } else {
            if(!Activation::completed($user)) {
                return Redirect::back()->withErrors('Không thể thực hiện khóa vì tài khoản của hội viên này chưa được kích hoạt');
            } else {
                $lock = Activation::remove($user);
                return Redirect::back()->withSuccess('Đã khóa tài khoản!');
            }
        }
    }
}
