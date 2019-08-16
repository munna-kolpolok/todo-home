<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Http\Requests\SiteSettingRequest;
use App\Models\Setting;
use App\Models\Sr_Setting;
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
        $site_setting = Sr_Setting::first();
        //dd($site_setting);
        return view('admin.save_refugee.settings.index', compact('site_setting'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bn_bidya_settings_index()
    {
        $site_setting = Setting::first();
        die;
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
    public function update(Requests\SrSiteSettingRequest $request, $id)
    {
        //dd($request->all());
        /*if($request->redirect!=1) {
            $rules = array(
                'organization_name' => 'required',
                'about_background_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }*/

        $data = $request->except(['logo','email_image','about_banner_image','contact_banner_image','gallery_banner_image','video_banner_image','transaction_banner_image','faq_banner_image','donate_background_image','counter_background_image','video_background_image','about_slider_1','about_slider_2','about_slider_3','mission_image','mission_content_image_1','mission_content_image_2','mission_content_image_3','mission_content_image_4','vision_image']);
        $site_setting = Sr_Setting::find($id);


        //Logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $this->commonUploadImage($site_setting, 'logo', $image, '323', '80');
        }
        //Email Image
        if ($request->hasFile('email_image')) {
            $image = $request->file('email_image');
            $this->commonUploadImage($site_setting, 'email_image', $image, '152', '19');
        }

        //About Banner Image
        if ($request->hasFile('about_banner_image')) {
            $image = $request->file('about_banner_image');
            $this->commonUploadImage($site_setting, 'about_banner_image', $image, '1920', '500');
        }

        //Contact Banner Image
        if ($request->hasFile('contact_banner_image')) {
            $image = $request->file('contact_banner_image');
            $this->commonUploadImage($site_setting, 'contact_banner_image', $image, '1920', '500');
        }

        //Gallery Banner Image
        if ($request->hasFile('gallery_banner_image')) {
            $image = $request->file('gallery_banner_image');
            $this->commonUploadImage($site_setting, 'gallery_banner_image', $image, '1920', '500');
        }

        //Video Banner Image
        if ($request->hasFile('video_banner_image')) {
            $image = $request->file('video_banner_image');
            $this->commonUploadImage($site_setting, 'video_banner_image', $image, '1920', '500');
        }

        //Transaction Banner Image
        if ($request->hasFile('transaction_banner_image')) {
            $image = $request->file('transaction_banner_image');
            $this->commonUploadImage($site_setting, 'transaction_banner_image', $image, '1920', '500');
        }

        //Faqs Banner Image
        if ($request->hasFile('faq_banner_image')) {
            $image = $request->file('faq_banner_image');
            $this->commonUploadImage($site_setting, 'faq_banner_image', $image, '1920', '500');
        }

        //Donate Background Image
        if ($request->hasFile('donate_background_image')) {
            $image = $request->file('donate_background_image');
            $this->commonUploadImage($site_setting, 'donate_background_image', $image, '390', '450');
        }

        //Counter Background Image
        if ($request->hasFile('counter_background_image')) {
            $image = $request->file('counter_background_image');
            $this->commonUploadImage($site_setting, 'counter_background_image', $image, '1920', '500');
        }

        //Video Background Image
        if ($request->hasFile('video_background_image')) {
            $image = $request->file('video_background_image');
            $this->commonUploadImage($site_setting, 'video_background_image', $image, '1920', '600');
        }

        //About Slider Image 1
        if ($request->hasFile('about_slider_1')) {
            $image = $request->file('about_slider_1');
            $this->commonUploadImage($site_setting, 'about_slider_1', $image, '555', '330');
        }

        //About Slider Image 2
        if ($request->hasFile('about_slider_2')) {
            $image = $request->file('about_slider_2');
            $this->commonUploadImage($site_setting, 'about_slider_2', $image, '555', '330');
        }

        //About Slider Image 3
        if ($request->hasFile('about_slider_3')) {
            $image = $request->file('about_slider_3');
            $this->commonUploadImage($site_setting, 'about_slider_3', $image, '555', '330');
        }

        //Mission main Image
        if ($request->hasFile('mission_image')) {
            $image = $request->file('mission_image');
            $this->commonUploadImage($site_setting, 'mission_image', $image, '430', '240');
        }

        //Mission Content Image 1
        if ($request->hasFile('mission_content_image_1')) {
            $image = $request->file('mission_content_image_1');
            $this->commonUploadImage($site_setting, 'mission_content_image_1', $image, '250', '250');
        }

        //Mission Content Image 2
        if ($request->hasFile('mission_content_image_2')) {
            $image = $request->file('mission_content_image_2');
            $this->commonUploadImage($site_setting, 'mission_content_image_2', $image, '250', '250');
        }

        //Mission Content Image 3
        if ($request->hasFile('mission_content_image_3')) {
            $image = $request->file('mission_content_image_3');
            $this->commonUploadImage($site_setting, 'mission_content_image_3', $image, '250', '250');
        }

        //Mission Content Image 4
        if ($request->hasFile('mission_content_image_4')) {
            $image = $request->file('mission_content_image_4');
            $this->commonUploadImage($site_setting, 'mission_content_image_4', $image, '250', '250');
        }

        //Vision Image
        if ($request->hasFile('vision_image')) {
            $image = $request->file('vision_image');
            $this->commonUploadImage($site_setting, 'vision_image', $image, '350', '300');
        }


        //update site settings
        $site_setting->update($data);

        Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
        if($request->redirect==1){
            return Redirect::to(config('laraadmin.adminRoute') . '/bn_bidya_settings');
        }else{
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_settings.index');
        }

    }

    public function commonUploadImage(Sr_Setting $setting, $image_name, $image, $width, $height)
    {
        //site image path
        $path = public_path() . '/' . '/uploads/sr_settings/';
        $database_image_folder_path = '/uploads/sr_settings/';
        //upload image
        $existing_path = public_path() . '/' . $setting->{$image_name};
        if (file_exists($existing_path)) {
            @unlink($existing_path);
        }
        $new_image = $image_name . '.' . $image->getClientOriginalExtension();
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
