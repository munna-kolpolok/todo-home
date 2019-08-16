<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use App\Models\Contact_message;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Mail;
use Lang;
use App\Models\Setting;

class ContactMessageController extends Controller
{
    public function index()
    {
        if (Menu::hasAccess('contact_messages')) {
            $contact_messages = Contact_message::orderBy('id', 'desc')->get();
            return view('admin.contact_message.index', compact('contact_messages'));
        } else {
            return View('error');
        }

    }

    public function store(Requests\ContactMessageRequest $request)
    {
        $contact = Contact_message::find($request->contact_id);
        $contact->reply_subject = $request->subject;
        $contact->reply_message = $request->message;
        $contact->save();

        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $data['name'] = $contact->name;
        Mail::send('emails.contact_message', ['data' => $data], function ($message) use ($data, $contact) {
            $setting = Setting::first();
            $message->to($contact->email)->from($setting->contact_email,$setting->organization_name)->subject($data['subject']);
        });
        Session::flash('message', Lang::get('messages.Your reply sent successfully'));
        return redirect()->back();

    }
}
