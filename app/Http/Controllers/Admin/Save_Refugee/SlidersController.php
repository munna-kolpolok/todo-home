<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Slider;
use App\Models\Sr_Slider_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;
//use File;
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
        if (Menu::hasAccess("sr_sliders")) {

            $projects = Sr_Slider::with('translation')->orderby('id', 'desc')->get();
            // dd($projects);
            return View('admin.save_refugee.sliders.index', [
                'values' => $projects,
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
        if (Menu::hasAccess("sr_sliders", "create")) {
            $projects = Sr_Project::get();
            return View('admin.save_refugee.sliders.create', compact('projects', $projects));
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
    public function store(Requests\SrSlidersRequest $request)
    {
        //dd($request->all());
        $sr_sliders = new Sr_Slider();
        $sr_sliders->type = $request->type;
        if($request->type==1)
        {
            $sr_sliders->sr_project_id = $request->sr_project_id;
        }
        $sr_sliders->content_align = $request->content_align;
        $sr_sliders->save();

        /*Image upload*/
        $database_image_path = null;
        $path = public_path() . '/uploads/sliders/';
        $database_image_folder_path = '/uploads/sliders/';

        if (!File::exists($path)) {
            $uploads_directory = File::makeDirectory($path, 0777, true, true);
        }
        if ($database_image_folder_path == true) {
            if ($request->hasFile('image')) {
                $sr_sliders_image = $request->file('image');

                $sr_sliders_image_name = 'sr_'.$sr_sliders->id . '.' . $sr_sliders_image->getClientOriginalExtension();
                $sr_sliders_path_image = $path . $sr_sliders_image_name;

                Image::make($sr_sliders_image->getRealPath())->resize(1920, 1280)->save($sr_sliders_path_image);
                $database_image_path = $database_image_folder_path . $sr_sliders_image_name;
                $sr_sliders->image = $database_image_path;
                $sr_sliders->save();
            }
        }

        /*Sliders translation data */
        $sliders_tns = new Sr_Slider_Translation();
        $sliders_tns->sr_slider_id = $sr_sliders->id;
        $sliders_tns->locale = 'en';
        $sliders_tns->title = $request->title;
        $sliders_tns->sub_title = $request->sub_title;
        $sliders_tns->description_up = $request->description_up;
        $sliders_tns->description_down = $request->description_down;
        $sliders_tns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("sr_sliders", "view")) {
            die;
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
    public function edit($id)
    {
        if (Menu::hasAccess('sr_sliders', 'edit')) {
            $projects = Sr_Project::get();
            $sr_slider = Sr_Slider::find($id);
            $sr_slider_trns = Sr_Slider_Translation::where('sr_slider_id', $id)->get();
            $languages = Language::get();
            return view('admin.save_refugee.sliders.edit', compact(['projects', 'sr_slider','sr_slider_trns', 'languages']));
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
    public function update(Request $request, $id)
    {
        if (Menu::hasAccess('sr_sliders', 'edit')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,jpg,png|max:10000',
            ]);

            $sr_sliders = Sr_Slider::find($id);
            $sr_sliders->type = $request->type;
            if($request->type==1)
            {
                $sr_sliders->sr_project_id = $request->sr_project_id;
            }
            $sr_sliders->content_align = $request->content_align;
            $sr_sliders->save();

            /*Image upload or remove*/
            if ($request->hasFile('image')) {

                $path = public_path() . '/uploads/sliders/';
                $database_image_folder_path = '/uploads/sliders/';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path() . '/' . $sr_sliders->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $image = $request->image;

                    $sr_sliders_image_name = 'sr_'.$sr_sliders->id . '.' . $image->getClientOriginalExtension();
                    $sr_sliders_path_image = $path . $sr_sliders_image_name;

                    Image::make($image->getRealPath())->resize(1920, 1280)->save($sr_sliders_path_image);
                    $database_image_path = $database_image_folder_path . $sr_sliders_image_name;
                    $sr_sliders->image = $database_image_path;
                    $sr_sliders->save();
                }
            }

            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_sliders.edit', $sr_sliders->id);

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
    public function destroy($id)
    {
        if (Menu::hasAccess("sr_sliders", "delete")) {

            //delete existing image folder
            $sr_slider = Sr_Slider::find($id);

            $image_path = public_path() . '/' . $sr_slider->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            $sr_slider->delete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_sliders.index');
        } else {
            return View('error');
        }

    }
}
