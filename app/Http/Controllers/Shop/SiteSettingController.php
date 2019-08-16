<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\SiteSettingRequest;
use App\Models\Site_Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $site_setting = Site_Setting::first();
        return view('shop.site_settings.index', compact('site_setting'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteSettingRequest $request, $id)
    {
        $data = $request->except(['product_banner_image', 'logo_image', 'about_image']);

        $site_setting = Site_Setting::find($id);

        //site image path
        $site_image_path = public_path().'/'.'/uploads/site/';
        $database_image_folder_path='/uploads/site/';

        //About Image
        if ($request->hasFile('about_image')) {
            $about_image = $request->file('about_image');
            $existing_path = public_path().'/'.$site_setting->about_image;
            if (file_exists($existing_path)) {
                @unlink($existing_path);
            }
            $image_name = 'about_image.' .$about_image->getClientOriginalExtension();
            $product_path_image= $site_image_path.$image_name;
            $about_image->move($site_image_path, $image_name);
            $database_image_path=$database_image_folder_path.$image_name;
            $data['about_image'] =$database_image_path;
        }
        //Product banner image
        if ($request->hasFile('product_banner_image')) {
            $product_banner_image = $request->file('product_banner_image');
            $existing_path = public_path().'/'.$site_setting->product_banner_image;
            if (file_exists($existing_path)) {
                @unlink($existing_path);
            }
            $image_name = 'product_banner_image.' .$product_banner_image->getClientOriginalExtension();
            $product_path_image= $site_image_path.$image_name;
            $product_banner_image->move($site_image_path, $image_name);
            $database_image_path=$database_image_folder_path.$image_name;
            $data['product_banner_image'] = $database_image_path;
        }
        //Product banner image
        if ($request->hasFile('logo_image')) {
            $logo_image = $request->file('logo_image');
            $existing_path = public_path().'/'.$site_setting->logo_image;
            if (file_exists($existing_path)) {
                @unlink($existing_path);
            }
            $image_name = 'logo_image.' .$logo_image->getClientOriginalExtension();
            $product_path_image= $site_image_path.$image_name;
            $logo_image->move($site_image_path, $image_name);
            $database_image_path=$database_image_folder_path.$image_name;
            $data['logo_image'] = $database_image_path;
        }

        //update site settings
        $site_setting->update($data);

        Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.site_settings.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
