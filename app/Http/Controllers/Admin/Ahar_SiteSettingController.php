<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AharSiteSettingRequest;
use App\Models\Ahar_Setting;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class Ahar_SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Ahar_Settings")) {

            $site_setting = Ahar_Setting::first();
            return view('admin.ahar_settings.index', compact('site_setting'));
        } else {
            return View('error');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bn_ahar_settings()
    {
        $site_setting = Ahar_Setting::first();
        return view('admin.ahar_settings.index_bn', compact('site_setting'));
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
    public function update(Requests\AharSiteSettingRequest $request, $id)
    {
        if (Menu::hasAccess('Ahar_Settings', 'edit')) {
           /* if ($request->redirect != 1) {
                $rules = array(
                    'organization_name' => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }*/

            $data = $request->except(['logo', 'favicon', 'section_icon','home_highlighted_image','volunteers_bg_image', 'about_us_header', 'contact_us_header','donor_profile_header','donation_clarification_header','reset_password_header','branch_info_header','forgot_password_header','sign_in_header', 'sign_up_header','bank_info_header','sponsor_header','package_header', 'faq_header', 'gallery_header','press_header', 'video_album_header','video_list_header', 'redirect']);
            //$data = $_REQUEST;
            $site_setting = Ahar_Setting::find($id);
            //Logo
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $this->commonUploadImage($site_setting, 'logo', $image, '177', '38');
            }

            //Favicon
            if ($request->hasFile('favicon')) {
                $image = $request->file('favicon');
                $this->commonUploadImage($site_setting, 'favicon', $image, '32', '32');
            }

            //Favicon
            if ($request->hasFile('section_icon')) {
                $image = $request->file('section_icon');
                $this->commonUploadImage($site_setting, 'section_icon', $image, '32', '32');
            }

            //Home Highlighted Image
            if ($request->hasFile('home_highlighted_image')) {
                $image = $request->file('home_highlighted_image');
                $this->commonUploadImage($site_setting, 'home_highlighted_image', $image, '1920', '1080');
            }

            //Home Highlighted Image
            if ($request->hasFile('volunteers_bg_image')) {
                $image = $request->file('volunteers_bg_image');
                $this->commonUploadImage($site_setting, 'volunteers_bg_image', $image, '1920', '1000');
            }

            //About Header Image
            if ($request->hasFile('about_us_header')) {
                $image = $request->file('about_us_header');
                $this->commonUploadImage($site_setting, 'about_us_header', $image, '1920', '466');
            }

            //Contact Header Image
            if ($request->hasFile('contact_us_header')) {
                $image = $request->file('contact_us_header');
                $this->commonUploadImage($site_setting, 'contact_us_header', $image, '1920', '466');
            }

            //Donor Profile Header
            if ($request->hasFile('donor_profile_header')) {
                $image = $request->file('donor_profile_header');
                $this->commonUploadImage($site_setting, 'donor_profile_header', $image, '1920', '466');
            }

            //Donation Clarification Header
            if ($request->hasFile('donation_clarification_header')) {
                $image = $request->file('donation_clarification_header');
                $this->commonUploadImage($site_setting, 'donation_clarification_header', $image, '1920', '466');
            }

            //Reset password header
            if ($request->hasFile('reset_password_header')) {
                $image = $request->file('reset_password_header');
                $this->commonUploadImage($site_setting, 'reset_password_header', $image, '1920', '466');
            }

            //Branch Info header
            if ($request->hasFile('branch_info_header')) {
                $image = $request->file('branch_info_header');
                $this->commonUploadImage($site_setting, 'branch_info_header', $image, '1920', '466');
            }

            //Forgot Password Header
            if ($request->hasFile('forgot_password_header')) {
                $image = $request->file('forgot_password_header');
                $this->commonUploadImage($site_setting, 'forgot_password_header', $image, '1920', '466');
            }

            //Sign in Image
            if ($request->hasFile('sign_in_header')) {
                $image = $request->file('sign_in_header');
                $this->commonUploadImage($site_setting, 'sign_in_header', $image, '1920', '466');
            }

            //Sign Up Image
            if ($request->hasFile('sign_up_header')) {
                $image = $request->file('sign_up_header');
                $this->commonUploadImage($site_setting, 'sign_up_header', $image, '294', '466');
            }

            //Bank Info Header Image
            if ($request->hasFile('bank_info_header')) {
                $image = $request->file('bank_info_header');
                $this->commonUploadImage($site_setting, 'bank_info_header', $image, '1920', '466');
            }

            //Sponsor Header Image
            if ($request->hasFile('sponsor_header')) {
                $image = $request->file('sponsor_header');
                $this->commonUploadImage($site_setting, 'sponsor_header', $image, '1920', '466');
            }

            //Packages Header Image
            if ($request->hasFile('package_header')) {
                $image = $request->file('package_header');
                $this->commonUploadImage($site_setting, 'package_header', $image, '1920', '466');
            }

            //Faq Header Image
            if ($request->hasFile('faq_header')) {
                $image = $request->file('faq_header');
                $this->commonUploadImage($site_setting, 'faq_header', $image, '1920', '390');
            }

            //Gallery Header Image
            if ($request->hasFile('gallery_header')) {
                $image = $request->file('gallery_header');
                $this->commonUploadImage($site_setting, 'gallery_header', $image, '1920', '466');
            }

            //Press Header Image
            if ($request->hasFile('press_header')) {
                $image = $request->file('press_header');
                $this->commonUploadImage($site_setting, 'press_header', $image, '1920', '466');
            }

            //Video Album Header Image
            if ($request->hasFile('video_album_header')) {
                $image = $request->file('video_album_header');
                $this->commonUploadImage($site_setting, 'video_album_header', $image, '1920', '466');
            }

            //Video List Header Image
            if ($request->hasFile('video_list_header')) {
                $image = $request->file('video_list_header');
                $this->commonUploadImage($site_setting, 'video_list_header', $image, '1920', '466');
            }




            //update site settings
            $site_setting->update($data);

            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            if ($request->redirect == 2) {
                return Redirect::to(config('laraadmin.adminRoute') . '/bn_ahar_settings');
            } else {
                return redirect()->route(config('laraadmin.adminRoute') . '.ahar_settings.index');
            }
        } else {
            return View('error');
        }

    }

    public function commonUploadImage(Ahar_Setting $setting, $image_name, $image, $width, $height)
    {
        //site image path
        $path = public_path() . '/' . '/uploads/ahar_settings/';
        $database_image_folder_path = '/uploads/ahar_settings/';
        //upload image
        $existing_path = public_path() . '/' . $setting->{$image_name};
        if (file_exists($existing_path)) {
            @unlink($existing_path);
        }
        $new_image = $image_name . '.' . $image->getClientOriginalExtension();
        $image_path = $path . $new_image;
        Image::make($image->getRealPath())->resize($width, $height)->save($image_path);
        $database_image_path = $database_image_folder_path . $new_image;
        $setting->{$image_name} = $database_image_path;
        $setting->save();
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
