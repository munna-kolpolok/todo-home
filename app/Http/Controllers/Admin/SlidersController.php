<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("sliders")) {
            $sliders = Slider::where('website_id', '1')->orderby('id', 'desc')->get();
            return View('admin.sliders.index', [
                'values' => $sliders,
            ]);
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
        if (Menu::hasAccess("sliders", "create")) {
            $slider_types_arr = array(1 => "Donate", 2 => "Scholarship", 3 => "Sign in", 4 => "Volunteer", 5 => "Rohinga camp");
            return View('admin.sliders.create', [
                'slider_types' => $slider_types_arr,
            ]);
        } else {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SliderRequest $request)
    {
        $sliders = Slider::where('website_id', '1')->orderBy('id', 'desc')->get();
        $serial_no = $sliders->max('serial_no') + 1;
        //dd($request->all()); die(); 
        $slider = new Slider();
        $slider->up_title = $request->up_title;
        $slider->bn_up_title = $request->bn_up_title;
        $slider->down_title = $request->down_title;
        $slider->bn_down_title = $request->bn_down_title;
        $slider->message = $request->message;
        $slider->bn_message = $request->bn_message;
        $slider->type = $request->type;
        $slider->serial_no = $serial_no;
        $slider->status = $request->status;
        $slider->save();

        /*Image upload*/
        $path = public_path() . '/uploads/sliders';
        $database_image_folder_path = '/uploads/sliders';

        if (!File::exists($path)) {
            $path = File::makeDirectory($path, 0777, true, true);
        }

        if ($path == true) {

            $image = $request->image;
            $image_name = '/'.'bidyanondo-'.$slider->id.'-'.time(). '.' . $image->getClientOriginalExtension();
            $image_path = $path . $image_name;

            Image::make($image->getRealPath())->resize(1920, 870)->save($image_path);

            $database_image_path = $database_image_folder_path . $image_name;
            $slider->image = $database_image_path;
            $slider->save();
        }


        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $sliders)
    {
        if (Menu::hasAccess("sliders", "view")) {
            $slider_types_arr = array(1 => "Donate", 2 => "Scholarship", 3 => "Sign in", 4 => "Volunteer", 5 => "Rohinga camp");
            return View('admin.sliders.show', compact('sliders', 'slider_types_arr'));
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
    public function edit(Slider $sliders)
    {
        if (Menu::hasAccess('sliders', 'edit')) {


            return view('admin.sliders.edit', compact('sliders'));
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
    public function update(Requests\SliderRequest $request, Slider $sliders)
    {
        if (Menu::hasAccess('sliders', 'edit')) {
            $data = $request->except('image');

            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/sliders';
                $database_image_folder_path = '/uploads/sliders';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path() . '/' . $sliders->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $image = $request->image;
                    $image_name = '/' . 'bidyanondo-'.$sliders->id.'-'.time() . '.' . $image->getClientOriginalExtension();
                    $image_path = $path . $image_name;

                    Image::make($image->getRealPath())->resize(1920, 870)->save($image_path);

                    $database_image_path = $database_image_folder_path . $image_name;
                    $sliders->image = $database_image_path;
                    $sliders->save();
                }

            }
            $sliders->update($data);
            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');

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
    public function destroy(Slider $sliders)
    {
        if (Menu::hasAccess("sliders", "delete")) {

            //delete existing image folder
            $image_path = public_path() . '/' . $sliders->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            $sliders->delete();

            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');
        } else {
            return View('error');
        }

    }

    public function slidersOrder()
    {
        if (Menu::hasAccess('sliders')) {
            $sliders = Slider::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
            return View('admin.sliders.order', ['sliders' => $sliders]);
        } else {
            return View('error');
        }
    }

    public function slidersOrderUpdate(Request $request)
    {
        $sliders = Slider::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
        foreach ($sliders as $slider) {
            $slider->timestamps = false;
            $id = $slider->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $slider->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
