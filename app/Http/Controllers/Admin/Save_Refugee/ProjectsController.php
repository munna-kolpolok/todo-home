<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
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


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Sr_Projects")) {

//            $projects = Sr_Project::with(['translations'=> function($query) {
//                $query->where('locale','en');
//            }])->orderby('id','desc')->get();

            $projects = Sr_Project::with('translation')->orderby('id', 'desc')->get();
            //dd($projects);
            return View('admin.save_refugee.projects.index', [
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
        if (Menu::hasAccess("Sr_Projects", "create")) {
            return View('admin.save_refugee.projects.create');
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
    public function store(Requests\SrProjectsRequest $request)
    {
        //dd($request->all()); die();
        $projects = new Sr_Project();
        $projects->target = $request->target;
        $projects->video_link = $request->video_link;
        $projects->is_menu = $request->is_menu;
        $projects->is_home = $request->is_home;
        $projects->is_show = $request->is_show;
        $projects->save();

        /*Image upload*/
        $database_image_path = null;
        $path = public_path() . '/uploads/projects/' . $projects->id;
        $database_image_folder_path = '/uploads/projects/' . $projects->id;

        if (!File::exists($path)) {
            $uploads_directory = File::makeDirectory($path, 0777, true, true);
        }
           /* if ($uploads_directory == true) {*/
                if ($request->hasFile('project_image')) {
                    $projects_image = $request->file('project_image');
                    $projects_image_name = '/main.' . $projects_image->getClientOriginalExtension();
                    $projects_path_image = $path . $projects_image_name;

                    Image::make($projects_image->getRealPath())->resize(320, 240)->save($projects_path_image);
                    $database_image_path = $database_image_folder_path . $projects_image_name;
                    $projects->project_image = $database_image_path;
                    $projects->save();
                }
           /* }*/


        /*Project translation data */
        $projects_tns = new Sr_Project_Translation();
        $projects_tns->sr_project_id = $projects->id;
        $projects_tns->locale = 'en';
        $projects_tns->name = $request->name;
        $projects_tns->title = $request->title;
        $projects_tns->subtitle = $request->subtitle;
        $projects_tns->description = $request->description;
        $projects_tns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("Sr_Projects", "view")) {
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
        if (Menu::hasAccess('Sr_Projects', 'edit')) {
            $project = Sr_Project::find($id);
            $project_transtaltion = Sr_Project_Translation::where('sr_project_id', $id)->get();
            //$languages = Language::where('code', '!=' , 'en')->get();
            $languages = Language::get();
            return view('admin.save_refugee.projects.edit', compact(['project', 'project_transtaltion','languages']));
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
        if (Menu::hasAccess('Sr_Projects', 'edit')) {
            $data = $request->except('project_image');
            $this->validate($request, [
                'target' => 'required',
                'video_link' => 'required',
            ]);

            $project = Sr_Project::find($id);
            $project->target = $request->target;
            $project->video_link = $request->video_link;
            $project->is_menu = $request->is_menu;
            $project->is_home = $request->is_home;
            $project->is_show = $request->is_show;
            $project->save();


            /*Image upload or remove*/
            if ($request->hasFile('project_image')) {

                $path = public_path() . '/uploads/projects/' . $project->id;
                $database_image_folder_path = '/uploads/projects/' . $project->id;

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path() . '/' . $project->project_image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $image = $request->project_image;
                    $image_name = '/' . $project->id . '.' . $image->getClientOriginalExtension();
                    $image_path = $path . $image_name;

                    Image::make($image->getRealPath())->resize(320, 240)->save($image_path);

                    $database_image_path = $database_image_folder_path . $image_name;
                    $project->project_image = $database_image_path;
                    $project->save();
                }

            }
            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.edit',$project->id);

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
        if (Menu::hasAccess("Sr_Projects", "delete")) {

            $project=Sr_Project::find($id);

            //delete existing image
            $image_path = public_path() . '/' . $project->project_image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            Sr_Project_Translation::where('sr_project_id', $id)->forcedelete();
            $project->delete();

            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.index');
        } else {
            return View('error');
        }

    }
}
