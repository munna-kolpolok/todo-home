<?php

namespace App\Http\Controllers\Admin;

use App\Models\Scholarship_Donor;
use App\Models\Setting;
use App\Models\User;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Session;

class SendEmailController extends Controller
{
    public function __construct()
    {
        $this->menu_id = Menu::get('Send Mail');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess($this->menu_id)) {
            $donors = User::where(['user_level' => 1])->get();
            return View('admin.send_email.index', compact('donors'));
        } else {
            return View('error');
        }

    }


    public function sendDonorMail(Requests\AdminSendDonorMailRequest $request)
    {
        die('Not send any email development environment.');
        if (Menu::hasAccess($this->menu_id)) {
            $users = null;
            $recipient_option = $request->recipient_option;
            $donors = $request->donors;
            $mail_option = $request->mail_option;
            $template_id = $request->template_id;
            $subject = $request->subject;
            $body = $request->body;
            $setting = Setting::first();

            //Retrieve all Donors
            if ($recipient_option == 1 && empty($donors)) {
                $users = User::where(['user_level' => 1])->orderBy('name', 'asc')->get();
            } elseif ($recipient_option == 1 && !empty($donors)) {
                $users = User::where(['user_level' => 1])->whereIn('id', $donors)->orderBy('name', 'asc')->get();
            }

            //Retrieve all active Donors
            if ($recipient_option == 2 && empty($donors)) {
                $users = User::where(['user_level' => 1, 'is_donor' => 1])->orderBy('name', 'asc')->get();
            } elseif ($recipient_option == 2 && !empty($donors)) {
                $users = User::where(['user_level' => 1, 'is_donor' => 1])->whereIn('id', $donors)->orderBy('name', 'asc')->get();
            }

            //Retrieve donor has at least one child scholarship
            if ($recipient_option == 3 && empty($donors)) {
                $users = User::has('scholarshipDonors')->orderBy('name', 'asc')->get();
            } elseif ($recipient_option == 3 && !empty($donors)) {
                $users = User::has('scholarshipDonors')->whereIn('id', $donors)->orderBy('name', 'asc')->get();
            }

            //Retrieve donor has doest not any student
            if ($recipient_option == 4 && empty($donors)) {
                $users = User::doesnthave('scholarshipDonors')->where('user_level', 1)->orderBy('name', 'asc')->get();
            } elseif ($recipient_option == 4 && !empty($donors)) {
                $users = User::doesnthave('scholarshipDonors')->where('user_level', 1)->whereIn('id', $donors)->orderBy('name', 'asc')->get();
            }

            if (count($users) > 0) {
                foreach ($users as $user) {
                    if ($mail_option == 1) {
                        if ($template_id == 1) {
                            Mail::send('emails.send_scholarship_donor_user_email_password', ['name' => $user->name, 'email' => $user->email, 'password' => '123456'], function ($m) use ($user, $setting) {
                                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Bidyanondo Notification: User Account to access student information.');
                            });
                        } elseif ($template_id == 2) {
                            Mail::send('emails.send_exclude_scholarship_donor_user_email_password', ['name' => $user->name, 'email' => $user->email, 'password' => '123456'], function ($m) use ($user, $setting) {
                                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Bidyanondo Notification: User Account To Access Bidyanondo Foundation.');
                            });
                        }
                    } else {
                        Mail::send('emails.admin_custom_email', ['name' => $user->name, 'body' => $body], function ($m) use ($user, $subject, $setting) {
                            $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject($subject);
                        });
                    }
                }
                Session::flash('seccess_msg', "Mail send successfully");
                return redirect()->back();
            } else {
                return Redirect::back()->withErrors('Users Not Found.');
            }
        } else {
            return View('error');
        }
    }

    public function recipientWiseDonorLoad(Request $request)
    {
        $donor_options = null;
        $recipient_id = $request->recipient_id;
        $donors = [];
        if ($recipient_id == 1) {
            //All donors
            $donors = User::where(['user_level' => 1])->orderBy('name', 'asc')->get();
        } elseif ($recipient_id == 2) {
            //Verified donors
            $donors = User::where(['user_level' => 1, 'is_donor' => 1])->orderBy('name', 'asc')->get();
        } elseif ($recipient_id == 3) {
            //scholarship donors
            $donors = User::has('scholarshipDonors')->orderBy('name', 'asc')->get();
        } elseif ($recipient_id == 4) {
            //exclude scholarship donors
            $donors = User::doesnthave('scholarshipDonors')->where('user_level',1)->orderBy('name', 'asc')->get();
        }
        if (count($donors) > 0) {
            foreach ($donors as $donor) {
                $donor_options .= '<option value="' . $donor->id . '">' . $donor->name . ' (' . $donor->email . ')</option>';
            }
        }
        return response()->json($donor_options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
