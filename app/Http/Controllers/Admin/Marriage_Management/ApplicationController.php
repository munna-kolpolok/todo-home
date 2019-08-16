<?php

namespace App\Http\Controllers\Admin\Marriage_Management;

use App\Helpers\CommonHelper;
use App\Http\Requests\Marriage_Management\GiftRequest;
use App\Http\Requests\Marriage_Management\WeddingUpdateRequest;
use App\Models\Gift;
use App\Models\Marriage_Profile;
use App\Models\Setting;
use App\Repositories\ImageUploadRepo;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;
use Mail;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("applications")) {
            $applications = Marriage_Profile::orderby('id', 'desc')->get();
            return View('admin.applications.index', [
                'applications' => $applications,
            ]);
        } else {
            return View('error');
        }
    }

    public function verify($id, $status)
    {
        $profile = Marriage_Profile::find($id);
        $profile->is_verified = $status;
        $profile->save();
        if ($profile->profile == 1) {
            $clientMail = $profile->groom_email;
            $clientName = $profile->groom_name;
        } else {
            $clientMail = $profile->bride_email;
            $clientName = $profile->bride_name;
        }
        /*Send mail to user*/
        Mail::send('emails.wedding_verify_email', ['id' => $profile->id, 'name' => $clientName], function ($m) use ($clientMail, $clientName) {
            $setting = Setting::first();
            $m->to($clientMail, $clientName)->from($setting->contact_email, $setting->organization_name)->subject(Lang::get('messages.Wedding verification from bidiyanondo!'));
        });

        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->back();
    }

    public function isShow($id, $status)
    {
        $profile = Marriage_Profile::find($id);
        $profile->is_show = $status;
        $profile->save();
        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Marriage_Profile $applications)
    {
        if (Menu::hasAccess("applications", "view")) {
            return View('admin.applications.show', compact('applications'));
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Marriage_Profile $applications)
    {
        if (Menu::hasAccess('applications', 'edit')) {
            $marriage_date =  str_replace('-', '/', date('d-m-Y', strtotime($applications->marriage_date)));
            list($start, $end) = explode('-', $applications->ceremony_period);
            return view('admin.applications.edit', compact('applications','marriage_date','start','end'));
        } else {
            return View('error');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(WeddingUpdateRequest $request, Marriage_Profile $applications)
    {
        if (Menu::hasAccess('applications', 'edit')) {
            $data = $request->except('marriage_date','from','to','groom_image','bride_image','card_image');
            $data['marriage_date'] = CommonHelper::databseDateFormat($request->marriage_date);
            $data['ceremony_period'] = $request->from.'-'.$request->to;
            $data['created_ip_address'] = CommonHelper::getRealIpAddr();
            /*Image upload or remove*/
            $path = public_path() . '/uploads/wedding/'.$applications->id.'/';
            if ($request->hasFile('groom_image')) {
                $data['groom_image'] = ImageUploadRepo::uploadImage($path, $request->file('groom_image'), '270-270',$applications->groom_image);
            }
            if ($request->hasFile('bride_image')) {
                $data['bride_image'] = ImageUploadRepo::uploadImage($path, $request->file('bride_image'), '270-270',$applications->bride_image);
            }
            if ($request->hasFile('card_image')) {
                $data['card_image'] = ImageUploadRepo::uploadImage($path, $request->file('card_image'), '440-643',$applications->card_image);
            }
            $applications->update($data);
            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.applications.index');
        } else {
            return View('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marriage_Profile $applications)
    {
        if (Menu::hasAccess("applications", "delete")) {
            //Unlink image
            $path = public_path() . '/uploads/wedding/'.$applications->id;
            ImageUploadRepo::deleteDirectory($path);
            $applications->delete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.applications.index');
        } else {
            return View('error');
        }

    }


}
