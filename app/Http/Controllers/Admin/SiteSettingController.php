<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SiteSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_setting = Setting::first();
        return view('admin.settings.index', compact('site_setting'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bn_bidya_settings_index()
    {
        $site_setting = Setting::first();
        return view('admin.settings.index_bn', compact('site_setting'));
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
    public function update(Requests\SiteSettingRequest $request, $id)
    {
       /* if($request->redirect!=1) {
            $rules = array(
                'organization_name' => 'required',
                'about_background_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }*/

        $data = $request->except(['logo', 'about_video_poster_image', 'about_background_image','sign_in_image'
        ,'sign_up_image','contact_background_image','faq_background_image','payment_background_image','press_banner_image','bank_info_banner_image'
        ,'gallery_background_image','video_banner_image','volunteer_banner_image','signup_donor_image','cover_project_image',
        'scholarship_thumbnail_image','favicon','donate_poster_image','donate_poster_image','about_work_image','about_story_image','redirect','branch_info_banner_image','donation_form_bg_image','volunteers_form_bg_image','help_us_image','home_volunteer_image','subscribe_image','campaign_banner_image','campaign_details_banner_image']);
        //$data = $_REQUEST;
        $site_setting = Setting::find($id);


        //Logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $this->commonUploadImage($site_setting, 'logo', $image, '283', '65');
        }

        //Logo
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $this->commonUploadImage($site_setting, 'favicon', $image, '32', '32');
        }

        //About Video Poster Image
        if ($request->hasFile('about_video_poster_image')) {
            $image = $request->file('about_video_poster_image');
            $this->commonUploadImage($site_setting, 'about_video_poster_image', $image, '550', '470');
        }

        //About Header Image
        if ($request->hasFile('about_background_image')) {
            $image = $request->file('about_background_image');
            $this->commonUploadImage($site_setting, 'about_background_image', $image, '1920', '390');
        }
        //About Vision Image
        if ($request->hasFile('about_vision_image')) {
            $image = $request->file('about_vision_image');
            $this->commonUploadImage($site_setting, 'about_vision_image', $image, '80', '70');
        }

        //About Vision Image
        if ($request->hasFile('about_work_image')) {
            $image = $request->file('about_work_image');
            $this->commonUploadImage($site_setting, 'about_work_image', $image, '80', '70');
        }

        //About Work Image
        if ($request->hasFile('about_story_image')) {
            $image = $request->file('about_story_image');
            $this->commonUploadImage($site_setting, 'about_story_image', $image, '80', '70');
        }

        //Sign in Image
        if ($request->hasFile('sign_in_image')) {
            $image = $request->file('sign_in_image');
            $this->commonUploadImage($site_setting, 'sign_in_image', $image, '292', '350');
        }

        //Sign Up Image
        if ($request->hasFile('sign_up_image')) {
            $image = $request->file('sign_up_image');
            $this->commonUploadImage($site_setting, 'sign_up_image', $image, '294', '314');
        }

        //Contact Header Image
        if ($request->hasFile('contact_background_image')) {
            $image = $request->file('contact_background_image');
            $this->commonUploadImage($site_setting, 'contact_background_image', $image, '1920', '390');
        }

        //Faq Header Image
        if ($request->hasFile('faq_background_image')) {
            $image = $request->file('faq_background_image');
            $this->commonUploadImage($site_setting, 'faq_background_image', $image, '1920', '390');
        }

        //Payment Header Image
        if ($request->hasFile('payment_background_image')) {
            $image = $request->file('payment_background_image');
            $this->commonUploadImage($site_setting, 'payment_background_image', $image, '1920', '390');
        }

        //Press Header Image
        if ($request->hasFile('press_banner_image')) {
            $image = $request->file('press_banner_image');
            $this->commonUploadImage($site_setting, 'press_banner_image', $image, '1920', '390');
        }

        //Gallery Header Image
        if ($request->hasFile('gallery_background_image')) {
            $image = $request->file('gallery_background_image');
            $this->commonUploadImage($site_setting, 'gallery_background_image', $image, '1920', '390');
        }

        //Video Header Image
        if ($request->hasFile('video_banner_image')) {
            $image = $request->file('video_banner_image');
            $this->commonUploadImage($site_setting, 'video_banner_image', $image, '1920', '390');
        }

        //Bank Info Header Image
        if ($request->hasFile('bank_info_banner_image')) {
            $image = $request->file('bank_info_banner_image');
            $this->commonUploadImage($site_setting, 'bank_info_banner_image', $image, '1920', '390');
        }

        //Bank Info Header Image
        if ($request->hasFile('branch_info_banner_image')) {
            $image = $request->file('branch_info_banner_image');
            $this->commonUploadImage($site_setting, 'branch_info_banner_image', $image, '1920', '390');
        }

        //Donation clarification page BG  Image
        if ($request->hasFile('donation_form_bg_image')) {
            $image = $request->file('donation_form_bg_image');
            $this->commonUploadImage($site_setting, 'donation_form_bg_image', $image, '1920', '850');
        }

        //Volunteers page BG  Image
        if ($request->hasFile('volunteers_form_bg_image')) {
            $image = $request->file('volunteers_form_bg_image');
            $this->commonUploadImage($site_setting, 'volunteers_form_bg_image', $image, '1920', '850');
        }
       // dd($request->all());

        //About Signup Image
        if ($request->hasFile('signup_donor_image')) {
            $image = $request->file('signup_donor_image');
            $this->commonUploadImage($site_setting, 'signup_donor_image', $image, '554', '426');
        }

        //Project Cover Image
        if ($request->hasFile('cover_project_image')) {
            $image = $request->file('cover_project_image');
            $this->commonUploadImage($site_setting, 'cover_project_image', $image, '554', '426');
        }

        //Scholarship Thumbnail Image
        if ($request->hasFile('scholarship_thumbnail_image')) {
            $image = $request->file('scholarship_thumbnail_image');
            $this->commonUploadImage($site_setting, 'scholarship_thumbnail_image', $image, '1045', '510');
        }

        //Donate Video poster Image
        if ($request->hasFile('donate_poster_image')) {
            $image = $request->file('donate_poster_image');
            $this->commonUploadImage($site_setting, 'donate_poster_image', $image, '550', '470');
        }

        //Help us Image
        if ($request->hasFile('help_us_image')) {
            $image = $request->file('help_us_image');
            $this->commonUploadImage($site_setting, 'help_us_image', $image, '461', '391');
        }

        //Volunteer home Image
        if ($request->hasFile('home_volunteer_image')) {
            $image = $request->file('home_volunteer_image');
            $this->commonUploadImage($site_setting, 'home_volunteer_image', $image, '828', '545');
        }

        //Subscribe Image
        if ($request->hasFile('subscribe_image')) {
            $image = $request->file('subscribe_image');
            $this->commonUploadImage($site_setting, 'subscribe_image', $image, '564', '275');
        }

        //Campaign Banner Image
        if ($request->hasFile('campaign_banner_image')) {
            $image = $request->file('campaign_banner_image');
            $this->commonUploadImage($site_setting, 'campaign_banner_image', $image, '1920', '390');
        }

        //Campaign Banner Image
        if ($request->hasFile('campaign_details_banner_image')) {
            $image = $request->file('campaign_details_banner_image');
            $this->commonUploadImage($site_setting, 'campaign_details_banner_image', $image, '1920', '390');
        }


        //update site settings
        $site_setting->update($data);

        Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
        if($request->redirect==1){
            return Redirect::to(config('laraadmin.adminRoute') . '/bn_bidya_settings');
        }else{
            return redirect()->route(config('laraadmin.adminRoute') . '.settings.index');
        }

    }

    public function commonUploadImage(Setting $setting, $image_name, $image, $width, $height)
    {
        //site image path
        $path = public_path() . '/' . '/uploads/settings/';
        $database_image_folder_path = '/uploads/settings/';
        //upload image
        $existing_path = public_path() . '/' . $setting->{$image_name};
        if (file_exists($existing_path)) {
            @unlink($existing_path);
        }
        $new_image = 'bidyanondo-'.$image_name.'-'.time(). '.' . $image->getClientOriginalExtension();
        $image_path = $path . $new_image;
        Image::make($image->getRealPath())->resize($width, $height)->save($image_path);
        $database_image_path = $database_image_folder_path . $new_image;
        /*dump($image_name);
        dd($setting->{$image_name});*/
        $setting->{$image_name} = $database_image_path;
       // dd($setting->{$image_name});
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
