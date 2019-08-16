<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Project_Faq;
use App\Models\Sr_Project_Faq_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;
//use File;
use Image;


class ProjectFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('sr_project_faqs')) {
            $projects = Sr_Project::get();
            $languages = Language::get();
            $project_faqs = Sr_Project_Faq_Translation::orderby('id', 'desc')->get();
            return View('admin.save_refugee.project_faqs.index', [
                'values' => $project_faqs,
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
        if (Menu::hasAccess('sr_project_faqs', "create")) {
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
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
        ]);

        $project_faq = new Sr_Project_Faq();
        $project_faq->type = $request->type;
        $project_faq->sr_project_id = $request->sr_project_id;
        $project_faq->save();


        /*Project FAQs translation*/

        $projects_faq_trns = new Sr_Project_Faq_Translation();
        $projects_faq_trns->sr_project_faq_id = $project_faq->id;
        $projects_faq_trns->locale = $request->lang;
        $projects_faq_trns->question = $request->question;
        $projects_faq_trns->answer = $request->answer;
        $projects_faq_trns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_faqs.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess('sr_project_faqs', "view")) {

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
        if (Menu::hasAccess('sr_project_faqs', 'edit')) {

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
        if (Menu::hasAccess('sr_project_faqs', 'edit')) {
            $this->validate($request, [
                'question' => 'required',
                'answer' => 'required',
            ]);

            $projects_faq_trns = Sr_Project_Faq_Translation::find($id);
            $projects_faq_trns->question = $request->question;
            $projects_faq_trns->answer = $request->answer;
            $projects_faq_trns->save();

            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_faqs.index');

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
        if (Menu::hasAccess('sr_project_faqs', "delete")) {

            $project_faq_trns = Sr_Project_Faq_Translation::find($id);
            $project_faq = Sr_Project_Faq::find($project_faq_trns->sr_project_faq_id);


            $project_faq_trns->forcedelete();
            $project_faq->forcedelete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_faqs.index');
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
    public function getFaqData(Request $request)
    {
        $faq_trns = Sr_Project_Faq_Translation::find($request->id);
        $faq = Sr_Project_Faq::find($faq_trns->sr_project_faq_id);
        return ['faq_trns'=>$faq_trns,'faq'=>$faq];
    }
}
