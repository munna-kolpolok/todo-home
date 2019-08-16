<?php

namespace App\Http\Controllers\Admin\Marriage_Management;

use App\Http\Requests\Marriage_Management\MarriageSettingRequest;
use App\Http\Requests\SiteSettingRequest;
use App\Models\Marriage_Setting;
use App\Models\Setting;
use App\Repositories\ImageUploadRepo;
use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class MarriageSettingController extends Controller
{
    function __construct()
    {
        $this->path = public_path() . '/' . '/uploads/mr_settings/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marriage_setting = Marriage_Setting::first();
        return view('admin.marriage_settings.index', compact('marriage_setting'));
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
    public function update(MarriageSettingRequest $request, Marriage_Setting $wedding_settings)
    {
        $data = $request->except(['logo', 'about_banner_image', 'contact_banner_image','faq_banner_image','payment_banner_image',
            'about_big_image','about_small_up_image','about_small_down_image','apply_form_bg_image','contact_email_image','contact_slider_image']);
        //Logo
        if ($request->hasFile('logo')) {
           $data['logo'] = ImageUploadRepo::uploadImage($this->path, $request->file('logo'),'283-65',$wedding_settings->logo);
        }

        //About Banner Image
        if ($request->hasFile('about_banner_image')) {
            $data['about_banner_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('about_banner_image'),'1920-500',$wedding_settings->about_banner_image);
        }

        //Contact Banner Image
        if ($request->hasFile('contact_banner_image')) {
            $data['contact_banner_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('contact_banner_image'),'1920-500',$wedding_settings->contact_banner_image);
        }

        //Faq Banner Image
        if ($request->hasFile('faq_banner_image')) {
            $data['faq_banner_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('faq_banner_image'),'1920-500',$wedding_settings->faq_banner_image);
        }

        //Payment Banner Image
        if ($request->hasFile('payment_banner_image')) {
            $data['payment_banner_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('payment_banner_image'),'1920-500', $wedding_settings->payment_banner_image);
        }

        //Wedding List Banner Image
        if ($request->hasFile('wedding_list_banner_image')) {
            $data['wedding_list_banner_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('wedding_list_banner_image'),'1920-500', $wedding_settings->wedding_list_banner_image);
        }

        //About Banner Image
        if ($request->hasFile('about_big_image')) {
            $data['about_big_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('about_big_image'),'275-335',$wedding_settings->about_big_image);
        }

        //About Up Image
        if ($request->hasFile('about_small_up_image')) {
            $data['about_small_up_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('about_small_up_image'),'280-156',$wedding_settings->about_small_up_image);
        }


        //About Down Image
        if ($request->hasFile('about_small_down_image')) {
            $data['about_small_down_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('about_small_down_image'),'280-156',$wedding_settings->about_small_down_image);
        }

        //Register Background Image
        if ($request->hasFile('apply_form_bg_image')) {
            $data['apply_form_bg_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('apply_form_bg_image'),'1920-850',$wedding_settings->apply_form_bg_image);
        }

        //Contact Email Image
        if ($request->hasFile('contact_email_image')) {
            $data['contact_email_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('contact_email_image'),'152-19',$wedding_settings->contact_email_image);
        }

        //Contact Slider Image
        if ($request->hasFile('contact_slider_image')) {
            $data['contact_slider_image'] = ImageUploadRepo::uploadImage($this->path, $request->file('contact_slider_image'),'1220-844',$wedding_settings->contact_slider_image);
        }

        //update site settings
        $wedding_settings->update($data);

        Session::flash('message', Lang::get('messages.Updated successfully'));
        return Redirect::to(config('laraadmin.adminRoute') . '/wedding_settings');


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
