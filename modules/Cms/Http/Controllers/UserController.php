<?php
namespace Modules\Cms\Http\Controllers;

use Modules\Cms\Http\Controllers\AuthorizedController;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Kyslik\ColumnSortable\Sortable;
use Modules\Cms\Entities\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use DB;
use Validator;
use Redirect;
use Modules\Cms\Entities\Image;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Helpers;
use Mail;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends AuthorizedController
{
    /**
    * Holds the Sentinel Users repository.
    *
    * @var \Cartalyst\Sentinel\Users\EloquentUser
    */
    protected $users;

    /**
    * Constructor.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->users = Sentinel::getUserRepository();
    }

    /**
    * Display a listing of users.
    *
    * @return \Illuminate\View\View
    */
    public function index(Request $request)
    {
        $records_per_page = Config::get('constants.RECORD_PER_PAGE');
        $currentUser = Sentinel::getUser();
        $key = $request->get('keyword');
        if($key){
            $users = DB::table('users as u')->where('u.deleted_at', '=', NULL)
                                ->where(function($query) use($key){
                                $query->orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'like', "%".trim($key)."%")
                                    ->orWhere('email', 'LIKE', "%".trim($key)."%")
                                    ->orWhere('company_name', 'LIKE', "%".trim($key)."%")
                                    ->orWhere('mobile', 'LIKE', "%".trim($key)."%")
                                    ->orWhere('position', 'LIKE', "%".trim($key)."%")
                                    ->orWhere('career', 'LIKE', "%".trim($key)."%");
                            })->join('activations as a', 'u.id', '=', 'a.user_id')
                            ->select('u.*')
                            ->paginate($records_per_page);
        } else {
            $users = DB::table('users as u')
                        ->where('u.deleted_at', '=', NULL)
                        ->join('activations as a', 'u.id', '=', 'a.user_id')
                        ->select('u.*')
                        ->paginate($records_per_page);
        }

        $gender = Config::get('constants.GENDER');
        $permissions = Config::get('constants.PERMISSIONS');
        $roles = EloquentRole::lists('name', 'slug')->all();
        $role_default =  Config::get('constants.ROLE_DEFAULT');
        $permission_default =  Config::get('constants.PERMISSION_DEFAULT');
        $share_info = Config::get('constants.SHARE_INFO');
        return View::make('cms::users.index', compact('users', 'currentUser','gender', 'permissions', 'roles', 'role_default', 'permission_default', 'share_info'));
    }

    public function show($id){
        if( $user = User::find($id)) {
            $gender = Config::get('constants.GENDER');
            $share_info = Config::get('constants.SHARE_INFO');
            return View::make('cms::users.show', compact('user', 'gender', 'share_info'));
        }
        return Redirect::back()->withErrors(Lang::get('cms::message.member_not_found'));
    }

    public function edit($id) {
        if($user = User::find($id)) {
            // Kiểm tra quyền người dùng hiện tại
            $current_user = Sentinel::getUser();
            $current_user_id = $current_user->id;
            if($current_user->inRole('admin') || $current_user_id == $id) { // Admin cập nhật thông tin hội viên hoặc Hội viên tự cập nhật thông tin của mình
                $share_info = Config::get('constants.SHARE_INFO');
                return View::make('cms::users.edit', compact('user', 'share_info', 'current_user_id'));
            } else {
                return Redirect::back()->withErrors(Lang::get('cms::message.not_allowed_to_update_member_info'));
            }
        } else {
            return Redirect::back()->withErrors(Lang::get('cms::message.member_not_found'));
        }
    }
    public function update(Request $request, $id){
        $data = $request->all();
        $data['birthday'] =  Helpers::formatDateYmd($data['birthday']);
        $today = Carbon::today()->format('Y-m-d');
        // Admin đang đăng nhập không được đổi pass của admin khác
        $check = false;
        $current_user = Sentinel::getUser();
        $current_user_id = $current_user->id;
        $user = User::find($id);
        if($user->inRole('admin') && ($current_user_id != $id)) {
            $check = true;
        }
        $password = $data['password'];
        if($data['password'] == null || $check){
            $rules = [
                    'email'      => 'required|unique:users,email,'.$id,
                    'first_name' => 'required|max:50',
                    'last_name' => 'required|max:100',
                    'mobile'      => 'regex: /^[0-9+]*$/|min:8|max:15|unique:users,mobile,'.$id,
                    'birthday' => 'date|before: '.$today,
                    'repeat_password' => 'same:password',
                    'company_name' => 'max:100',
                    'position' => 'max:20',
                    'career' => 'max:100',
                    'country'   => 'max:100',
            ];
            unset($data['password']);
            if($data['repeat_password']) {
                unset($data['repeat_password']);
            }
        } else {
           $rules =  [
                'email'      => 'required|unique:users,email,'.$id,
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:100',
                'mobile'      => 'regex: /^[0-9+]*$/|min:8|max:15|unique:users,mobile,'.$id,
                'birthday' => 'date|before: '.$today,
                'password' => 'min:6',
                'repeat_password' => 'required|min:6|same:password',
                'company_name' => 'max:100',
                'position' => 'max:20',
                'career' => 'max:100',
                'country'   => 'max:100',
            ];
        }
        if($current_user_id == $id) {
            $rules['share'] = 'required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        if($this->users->update($user, $data)) {
            // Gửi mail thông báo cho hội viên nếu admin thay đổi pass của hội viên
            if($password || ($current_user_id != $id)){
                $sent = Mail::send('cms::sentinel.emails.noticeChangePassword', compact('current_user', 'user'), function($m) use ($user) {
                    $m->to($user->email)->subject(Lang::get('cms::message.notice_change_password'));
                });
                if ($sent === 0) {
                    return redirect("members/{$id}/show")->withSuccess(Lang::get('cms::message.change_pass_without_sending_email'));
                }
            }
            return redirect("members/{$id}/show")->withSuccess(Lang::get('cms::message.update_member_success'));
        }
        return Redirect::back()->withErrors(Lang::get('cms::message.update_member_fail'));
    }

    public function upload(Request $request){
        $user_id = $request->get('user_id');
        $photo = $request->file('photo');
        $rules = [
                'photo' => 'required|mimes:jpeg,bmp,png,tiff,gif|max:10000',
        ];

        if ($this->validate_photo($photo, $rules)) {
            // Xóa ảnh cũ trong db
            $user = User::find($user_id);
            $photo_id = $user->photo;
            $image = Image::find($photo_id);
            if($image){
                $image->delete();
            }

            // Cập nhật ảnh
            $image = $this->upload_file($photo);
            $user = User::find($user_id);
            $user->photo = $image->id;
            if($user->save()) {
                return Redirect::back()->withSuccess(Lang::get('cms::message.upload_photo_success'));
            }
            return Redirect::back()->withErrors(Lang::get('cms::message.upload_photo_invalid'));
        }
        return Redirect::back()->withErrors(Lang::get('cms::message.upload_photo_invalid'));
    }

    /**
     * Xóa hội viên
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($user = User::find($id))
        {
            $user->delete();
        }
        return redirect('members')->withSuccess(Lang::get('cms::message.delete_user_success'));
    }

    public function create() {
        $share_info = Config::get('constants.SHARE_INFO');
        return View::make('cms::users.create', compact('share_info'));
    }

    public function store(Request $request) {
        $today = Carbon::today()->format('Y-m-d');
        $data = $request->all();
        $data['birthday'] =  Helpers::formatDateYmd($data['birthday']);
        $rules = [
                'email'      => 'required|unique:users',
                'share'      => 'required',
                'first_name' => 'required|max:50',
                'last_name' => 'required|max:100',
                'password' => 'required|min:6',
                'repeat_password' => 'required|same:password',
                'mobile'      => 'regex: /^[0-9+]*$/|min:8|max:15|unique:users',
                'birthday' => 'date|before: '.$today,
                'company_name' => 'max:100',
                'position' => 'max:20',
                'career' => 'max:100',
                'country'   => 'max:100',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $save_user = false;
        // Xử lý file ảnh đại diện
        $photo = $request->file('image');
        $rules = [
                'photo' => 'mimes:jpeg,bmp,png,tiff,gif|max:10000',
        ];
        if($photo){
            if($this->validate_photo($photo, $rules)) {
                $image = $this->upload_file($photo);
                if($image) {
                    $user = Sentinel::registerAndActivate($data);
                    $user->photo = $image->id;
                    if($user->save()){
                        $save_user = true;
                    }
                }
            } else {
                return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.upload_photo_invalid'));
            }
        } else {
            $user = Sentinel::registerAndActivate($data);
            if($user) {
                $save_user = true;
            }
        }
        if($save_user){
            return redirect('members')->withSuccess(Lang::get('cms::message.create_user_success'));
        } else {
            return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.create_user_fail'));
        }
    }

    protected function validate_photo($photo, $rules)
    {
        $file = ['photo' => $photo];
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return false;
        } elseif ( $photo->isValid() ) {
            return true;
        } else {
            return false;
        }
    }

    protected function upload_file($photo)
    {
        $image = new Image();
        $image->file_type = $photo->getClientMimeType();
        $image->file_size = $photo->getClientSize();
        if( $image->save()){
            $image_id = $image->id;
            // Lưu ảnh vào upload_folder
            $destinationPath = 'uploads/users/';
            $name = $photo->getClientOriginalName(); // getting image name
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $extractFileName = explode('.'.$extension, $name)[0];
            $fileName = $extractFileName."-".$image_id;
            $newFileName = str_slug($fileName).".".$extension;
            $photo->move($destinationPath, $newFileName); // uploading file to given path

            $image->name = $newFileName;
            $image->thumbs = '/uploads/users/'.$newFileName ;
            if( $image->save() ) {
                return $image;
            }
        }
    }

    public function save_permission(Request $request)
    {
        $input = $request->all();
        $id = $input['member_id'];
        $member = User::find($id);
        // Nhóm người dùng
        $assgined_role = $member->roles;
        foreach ($assgined_role as $role) {
            $deRole = Sentinel::findRoleBySlug($role['slug']);
            $deRole->users()->detach($member);
        }
        $slug = $input['role'];
        $new_role = Sentinel::findRoleBySlug($slug);
        $new_role->users()->attach($member);

        // Quyền
        if(isset($input['permissions'])) {
            $input['permissions'] = $this->formatPermission($input['permissions']);
        } else {
            $input['permissions'] = [];
        }
        if($member->update($input)) {
            return redirect('members')->withSuccess(Lang::get('cms::message.change_permission_success'));
        }
        return redirect('members')->withErrors(Lang::get('cms::message.change_permission_fail'));
    }

    protected function formatPermission($inputs)
    {
        $permissions = [];
        foreach ($inputs as $input){
            $permissions[$input] = true;
        }

        return $permissions;
    }

    public function get_not_activated_members(Request $request)
    {
        $records_per_page = Config::get('constants.RECORD_PER_PAGE');
        $key = $request->get('keyword');
        if($key) {
            $members = User::orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'like', "%".trim($key)."%")
                            ->orWhere('email', 'LIKE', "%".trim($key)."%")
                            ->orWhere('company_name', 'LIKE', "%".trim($key)."%")
                            ->orWhere('mobile', 'LIKE', "%".trim($key)."%")
                            ->orderBy('updated_at', 'DESC')
                            ->get();
        } else {
            $members = User::orderBy('updated_at', 'DESC')->get();
        }
        foreach ($members as $key=>$member){
            if(Activation::completed($member)){ // Bỏ chọn tài khoản mà đã được kích hoạt
                unset($members[$key]);
            }
        }
        $members = $members->toArray();
        $page = $request->get('page');
        $members = new LengthAwarePaginator(
                                    array_slice($members, $records_per_page * ($page - 1), $records_per_page, TRUE),
                                    count($members),
                                    $records_per_page,
                                    $page,
                                    ['path' => $request->url()]);
        return View::make('cms::users.not_activated_members', compact('members'));
    }
}