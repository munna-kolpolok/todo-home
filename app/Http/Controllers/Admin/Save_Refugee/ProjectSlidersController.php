<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Project_Slider;
use App\Models\Sr_Project_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;
//use File;
use Image;


class ProjectSlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Sr_Project_Sliders")) {
            $project_sliders = Sr_Project_Slider::with('translation')->orderby('id', 'desc')->get();
            $projects = Sr_Project::get();
            return View('admin.save_refugee.project_sliders.index', [
                'values' => $project_sliders,
                'projects' => $projects,
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
        if (Menu::hasAccess("Sr_Project_Sliders", "create")) {
            $projects = Sr_Project::with('translation')->orderby('id', 'desc')->get();
            // dd($projects);
            return View('admin.save_refugee.project_sliders.create', [
                'projects' => $projects,
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
    public function store(Request $request)
    {

        foreach ($request->image as $index => $value) {
            if (!empty($request->image[$index])) {

                $project_sliders = new Sr_Project_Slider();
                $project_sliders->sr_project_id = $request->sr_project_id;
                $project_sliders->save();

                /*Image upload*/
                $path = public_path() . '/uploads/projects/' . $request->sr_project_id;
                $database_image_folder_path = '/uploads/projects/' . $request->sr_project_id;

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {

                    $project_sliders_image = $request->image[$index];

                    // $image_name = '/'.$project_sliders->id.'.'.$project_sliders_image->getClientOriginalExtension();
                    $image_name = '/slider_' . $project_sliders->id . '.' . $project_sliders_image->getClientOriginalExtension();
                    $project_sliders_image_path = $path . $image_name;

                    Image::make($project_sliders_image->getRealPath())->resize(350, 208)->save($project_sliders_image_path);

                    $database_image_path = $database_image_folder_path . $image_name;
                    $project_sliders->image = $database_image_path;
                    $project_sliders->save();
                }
            } else {
                return redirect()->back()->withErrors("Something wrong");
            }
        }
        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_sliders.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("Sr_Project_Sliders", "view")) {

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
        if (Menu::hasAccess('Sr_Project_Sliders', 'edit')) {
            echo $id;
            die;

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
        if (Menu::hasAccess('Sr_Project_Sliders', 'edit')) {

            /*Image upload or remove*/
            $project_slider = Sr_Project_Slider::find($id);

            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/projects/' . $request->sr_project_id;
                $database_image_folder_path = '/uploads/projects/' . $request->sr_project_id;

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path() . '/' . $request->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $image = $request->image;
                    $image_name = '/slider_' . $id . '.' . $image->getClientOriginalExtension();
                    $image_path = $path . $image_name;
                    Image::make($image->getRealPath())->resize(350, 208)->save($image_path);

                    $database_image_path = $database_image_folder_path . $image_name;
                    $project_slider->image = $database_image_path;
                    $project_slider->save();
                }

            }
            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_sliders.index');

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
        if (Menu::hasAccess("Sr_Project_Sliders", "delete")) {

            //delete existing image folder
            $project_slier = Sr_Project_Slider::find($id);

            $image_path = public_path() . '/' . $project_slier->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            $project_slier->delete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_sliders.index');
        } else {
            return View('error');
        }

    }

    /**
     * Func for ajax request.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getProjectSlideImage(Request $request)
    {
        $project_slider = Sr_Project_Slider::find($request->id);

        return $project_slider;
    }
}
