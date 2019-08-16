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


class ProjectsTrnaslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Sr_Projects")) {

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
    public function store(Requests\SrProjectsTranslationRequest $request)
    {
       // $request->lang='en';
        $exist_lan=Sr_Project_Translation::where(['sr_project_id'=>$request->sr_project_id,'locale'=>$request->lang])->get();
       // dd($exist_lan);
        if(count($exist_lan)>0){
            return redirect()->back()->withErrors('Project Details in this Language already exist!');
        }
        $projects_tns = new Sr_Project_Translation();
        $projects_tns->sr_project_id = $request->sr_project_id;
        $projects_tns->locale = $request->lang;
        $projects_tns->name = $request->name;
        $projects_tns->title = $request->title;
        $projects_tns->subtitle = $request->subtitle;
        $projects_tns->description = $request->description;
        $projects_tns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));
       /* return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.index');*/
        return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.edit',$projects_tns->sr_project_id);
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
            //$project = Sr_Project::find($id);
            $languages = Language::get();
            $project_transtaltions = Sr_Project_Translation::find($id);
            //dd($project_transtaltions);
            return view('admin.save_refugee.projects.project_transtaltion_edit', compact(['project_transtaltions','languages']));
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
    public function update(Request $request, Sr_Project_Translation $sr_projects_tranlation)
    {
       // dd($request->all());
        if (Menu::hasAccess('Sr_Projects', 'edit')) {
            /*$data = $request->all();
            $sr_projects_tranlation->update();*/
            $sr_projects_tranlation=Sr_Project_Translation::find($request->id);
            //$sr_projects_tranlation->locale = $request->lang;
            $sr_projects_tranlation->name = $request->name;
            $sr_projects_tranlation->title = $request->title;
            $sr_projects_tranlation->subtitle = $request->subtitle;
            $sr_projects_tranlation->description = $request->description;
            $sr_projects_tranlation->save();


            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
           return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.edit',$sr_projects_tranlation->sr_project_id);

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
    public function destroy( $id)
    {
        if (Menu::hasAccess("Sr_Projects", "delete")) {
            $data=Sr_Project_Translation::find($id);
            $data->delete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sliders.index');
        } else {
            return View('error');
        }

    }

    /**
     * Ajax data response func.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getProjectLang(Request $request)
    {
        $project_lang = Sr_Project_Translation::find($request->id);
        return $project_lang;
    }
}
