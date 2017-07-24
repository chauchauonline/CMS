<?php
namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Modules\Cms\Entities\Message;
use Modules\Cms\Entities\User;
use DB;
use Mail;
use Illuminate\Support\Facades\Lang;
use Modules\Cms\Entities\ContactForm;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = Sentinel::getUser();
        $user_id = $user->id;
        $status = $request->get('status');
        $filter = $request->get('filter');
        $records = Config::get('constants.RECORD_PER_PAGE');
        // Lấy ra các message theo trạng thái
        if($status) {
            if($status == 'Sent') {
                $messages = Message::where('status', '=', 'Sent')
                                    ->where('from', '=', $user_id)
                                    ->paginate($records);
            } elseif($status=='Draft'){
                $messages = Message::where('status', '=', 'Draft')
                                    ->where('from', '=', $user_id)
                                    ->paginate($records);
            } elseif($status == 'Trash') {
                $messages = Message::where('status', '=', 'Trash')
                                    ->where(function($query) use ($user_id) {
                                    $query->orWhere('from', '=', $user_id)
                                        ->orwhere('to', '=', $user_id);
                                })->paginate($records);
            } elseif($status == 'Important') {
                $messages = Message::where('status', '=', 'Important')
                                    ->where(function($query) use ($user_id) {
                                        $query->orWhere('from', '=', $user_id)
                                            ->orwhere('to', '=', $user_id);
                                    })->paginate($records);
            }elseif($status == 'Social') {
                $messages = Message::where('status', '=', 'Social')
                                    ->where(function($query) use ($user_id) {
                                        $query->orWhere('from', '=', $user_id)
                                            ->orwhere('to', '=', $user_id);
                                    })->paginate($records);
            }elseif($status == 'Promosions') {
                $messages = Message::where('status', '=', 'Promosions')
                                    ->where(function($query) use ($user_id) {
                                        $query->orWhere('from', '=', $user_id)
                                            ->orwhere('to', '=', $user_id);
                                    })->paginate($records);
            }elseif($status == 'Junk') {
                $messages = Message::where('status', '=', 'Junk')
                                    ->where('to', '=', $user_id)
                                    ->paginate($records);
            }
            // Từ các messages trên lấy ra các message thỏa mãn điều kiện lọc
            if ($filter) {
                $result = array();
                if($filter == 'read') {
                    foreach ($messages as $key=>$mes){
                        if($mes->read != Config::get('constants.READ')){
                            unset($messages[$key]);
                        }
                    }
                } elseif($filter == 'unread') {
                    foreach ($messages as $key=>$mes){
                        if($mes->read != Config::get('constants.UNREAD')){
                            unset($messages[$key]);
                        }
                    }
                } elseif($filter == 'starred') {
                    foreach ($messages as$key=>$mes){
                        if($mes->star != Config::get('constants.STARRED')) {
                            unset($messages[$key]);
                        }
                    }
                } elseif($filter == 'not_starred') {
                    foreach ($messages as $key=>$mes){
                        if($mes->star != Config::get('constants.NOT_STARRED')) {
                            unset($messages[$key]);
                        }
                    }
                }
            }
            $title = Config::get('constants.MESSAGE_STATUS');
            return View::make('cms::messages.index',compact('messages', 'status', 'title'));
        }
        else {
            return redirect()->route('contacts.index');
        }

    }
    public function compose( Request $request) {
        $email = $request->get('email');
        $contact_id = $request->get('contact_id');
        $types = Config::get('constants.MESSAGE_TYPE');
        $user = Sentinel::getUser();
        return View::make('cms::messages.compose', compact('types', 'user', 'members', 'email', 'contact_id'));
    }

    public function send(Request $request) {
        $this->validate($request, [
               'email' => 'required',
        ]);
        // Gửi tin nhắn
        $email = $request->get('email');
        $subject = $request->get('subject');
        $content = $request->get('message');
        $sent = Mail::send('cms::sentinel.emails.normalEmail', compact('content') , function ($m) use ($email, $subject) {
            $m->to($email)->subject($subject);
        });
        if($sent === 0) {
            return redirect('messages')->withErrors(Lang::get('cms::message.send_email_fail'));
        }

        // Cập nhật tin nhắn nếu đây là tin được gửi từ bản nháp
        $draft_id  = $request->message_id;
        if($draft_id) {
            $draft  = Message::find($draft_id);
            $draft->status = "Sent";
            if( $draft->save() ) {
                return redirect('messages')->withSuccess(Lang::get('cms::message.send_email_success'));
            }
        } else {  // Lưu tin nhắn mới
            $mes = new Message();

            $star = $request->get('star');
            if($star) {
                $mes->star = $star;
            } else {
                $mes->star = Config::get('constants.NOT_STARRED');
            }
            $user = Sentinel::getUser();
            $mes->status  = "Sent";
            $mes->from  = $user->id;
            $mes->email  = $email;
            $receiver  = User::where('email', $email)->first();
            if($receiver)
            {
                $mes->to = $receiver->id;
            }
            $mes->subject = $subject;
            $mes->message = $content;
            $mes->type = $request->get('type');
            $mes->slug = rand(200,9999);
            $mes->user_id  = $user->id;
            $mes->read = Config::get('constants.UNREAD');
            if( $mes->save() ) {
                // Cập nhật trạng thái của tin nhắn liên hệ nếu đây là email trả lời liên hệ
                $contact_id = $request->get('contact_id');
                if($contact_id != '') {
                    $contact = ContactForm::find($contact_id);
                    $contact->status = Config::get('constants.REPLIED');
                    $contact->message_id = $mes->id;
                    $contact->save();
                }
                return redirect('messages')->withSuccess(Lang::get('cms::message.send_email_success'));
            }
        }
        return redirect('messages')->withErrors(Lang::get('cms::message.send_email_fail'));
    }

    public function read($id)
    {
        $message = Message::find($id);
        $message->read = Config::get('constants.READ');
        $message->save();
        $from_email = Config::get('constants.FROM_EMAIL');
        $from_username = Config::get('constants.FROM_USERNAME');
        $receiver = User::find($message->to);
        $to_email = $message->email;
        return view('cms::messages.read_email', compact('message', 'from_email', 'from_username', 'receiver', 'to_email'));
    }

    public function addStar(Request $request)
    {
        $id  = $request->get('message_id');
        $message  = Message::find($id);
        $message->star = Config::get('constants.STARRED');
        $message->save();
        return response()->json(['result' => 'ok']);
    }

    public function removeStar(Request $request)
    {
        $id  = $request->get('message_id');
        $message  = Message::find($id);
        $message->star = Config::get('constants.NOT_STARRED');
        $message->save();
        return response()->json(['result' => 'ok']);
    }

    /**
     * Delete the message
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $message_id = $request->get('message_id');
        $mess = Message::find($message_id);
        $mess->status = "Trash";
        if($mess->save()){
            return response()->json(['result' => 'ok']);
        } else {
            return response()->json(['result' => 'ng']);
        }
    }

    public function saveToDraft(Request $request)
    {
        $data = $request->all();
        if($message = Message::create($data)){
            $message->status = "Draft";
            $message->from = $data['user_id'];
            $message->read = Config::get('constants.UNREAD');
            $message->slug = rand(200,9999);
            $message->save();
            return response()->json(['result' => 'ok']);
        } else {
            return response()->json(['result' => 'ng']);
        }
    }

    public function edit($id) {
        $message = Message::find($id);
        $types = Config::get('constants.MESSAGE_TYPE');
        $user = Sentinel::getUser();
        $members = User::select(DB::raw('CONCAT(last_name, " ", first_name) AS full_name,id'))
                        ->orderBy('first_name')
                        ->lists('full_name','id')
                        ->all();
       return view::make('cms::messages.edit', compact('message', 'types' ,'user', 'members'));
    }

    public function updateDraft(Request $request){
        $id = $request->get('id');
        $message = Message::find($id);
        $data = $request->all();
        $message->update($data);
        return response()->json(['result' => 'ok']);
    }
}