<?php
namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Modules\Cms\Entities\ContactForm;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $record = Config::get('constants.RECORD_PER_PAGE');
        $contact_status = Config::get('constants.CONTACT_STATUS');
        $status = $request->get('status');
        if($status != ''){
            $contacts = ContactForm::Where('status', '=', $status)->orderBy('updated_at', 'desc')->paginate($record);
        }else {
            $contacts = ContactForm::orderBy('updated_at', 'desc')->paginate($record);
        }
        return View::make('cms::contacts.index', compact('contacts', 'contact_status'));
    }
}