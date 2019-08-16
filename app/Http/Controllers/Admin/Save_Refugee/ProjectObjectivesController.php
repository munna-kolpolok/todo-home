<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Project_Objective;
use App\Models\Sr_Project_Objective_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;
//use File;
use Image;


class ProjectObjectivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('Sr_Project_Objectives')) {
            $projects = Sr_Project::get();
            $languages = Language::get();
            $project_objectives = Sr_Project_Objective_Translation::orderby('id', 'desc')->get();
            return View('admin.save_refugee.project_objectives.index', [
                'values' => $project_objectives,
                'projects' => $projects,
                'languages' => $languages,
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
        if (Menu::hasAccess('Sr_Project_Objectives', "create")) {
            die;
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

        $projects_obj = new Sr_Project_Objective();
        $projects_obj->sr_project_id = $request->sr_project_id;
        $projects_obj->save();


        /*Project obj translation*/

        $projects_obj_trns = new Sr_Project_Objective_Translation();
        $projects_obj_trns->sr_project_objective_id = $projects_obj->id;
        $projects_obj_trns->objective = $request->objective;
        $projects_obj_trns->locale = $request->lang;
        $projects_obj_trns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_objectives.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess('Sr_Project_Objectives', "view")) {

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
        if (Menu::hasAccess('Sr_Project_Objectives', 'edit')) {

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
        if (Menu::hasAccess('Sr_Project_Objectives', 'edit')) {
            $this->validate($request, [
                'objective' => 'required',
            ]);

            $projects_obj_trns = Sr_Project_Objective_Translation::find($id);
            $projects_obj_trns->objective = $request->objective;
            $projects_obj_trns->save();

            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_objectives.index');

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
        if (Menu::hasAccess('Sr_Project_Objectives', "delete")) {

            $project_obj_trns = Sr_Project_Objective_Translation::find($id);
            $project_obj = Sr_Project_Objective::find($project_obj_trns->sr_project_objective_id);


            $project_obj_trns->forcedelete();
            $project_obj->forcedelete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_objectives.index');
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
    public function getObjData(Request $request)
    {
        $project_obj_tns = Sr_Project_Objective_Translation::find($request->id);
        $project_obj = Sr_Project_Objective::find($project_obj_tns->sr_project_objective_id);

        return ['trns'=>$project_obj_tns,'proj'=>$project_obj];
    }
}

