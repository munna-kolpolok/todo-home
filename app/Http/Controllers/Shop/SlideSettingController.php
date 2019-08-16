<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\SlideRequest;
use App\Models\Slider;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class SlideSettingController extends Controller
{

    public function __construct()
    {
        $this->slider_public_path = public_path().'/'.'uploads/slider/';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('Sliders')) {
            $sliders = Slider::orderBy('id','desc')->get();
            return View('shop.slide_settings.index', compact('sliders'));
        } else {
            return View('error');
        }
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
    public function store(SlideRequest $request)
    {
        if (Menu::hasAccess('Sliders')) {
            $data = $request->except('image');
            $database_image_folder_path='/uploads/slider/';
            //upload image
            if ($request->hasFile('image')) {
                $image = $request->image;
                $image_name = uniqid().$image->getClientOriginalName();
                $image_full_path = $this->slider_public_path.$image_name;
                $image->move($this->slider_public_path, $image_name);
                $database_image_path=$database_image_folder_path.$image_name;
                $data['image'] = $database_image_path;
            }

            //store data into database
            Slider::create($data);
            Session::flash('seccess_msg',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');

        } else {
            return View('error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('Sliders')) {
            $slider = Slider::find($id);
            return View('shop.slide_settings.edit', compact('slider'));
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, $id)
    {
        if (Menu::hasAccess('Sliders')) {
            $slider = Slider::find($id);
            $data = $request->except('image');
            //About Image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $existing_path = public_path().'/'.$slider->image;
                $database_image_folder_path='/uploads/slider/';
                if (file_exists($existing_path)) {
                    @unlink($existing_path);
                }
                $image_name = uniqid().$image->getClientOriginalName();
                $image_full_path = $this->slider_public_path.$image_name;
                $image->move($this->slider_public_path, $image_name);
                $database_image_path=$database_image_folder_path.$image_name;

                $data['image'] = $database_image_path;
            }
            //update site settings
            $slider->update($data);
            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');
        } else {
            return View('error');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess("Sliders", "delete")) {
            $slider = Slider::find($id);

            //delete existing image folder
            $existing_image = public_path().'/'.$slider->image;
            if (file_exists($existing_image)){
                @unlink($existing_image);
            }

            $slider->delete();
            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');
        } else {
            return View('error');
        }
    }
}
