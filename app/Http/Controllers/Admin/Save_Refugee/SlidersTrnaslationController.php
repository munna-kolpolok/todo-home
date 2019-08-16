<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Project_Translation;
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


class SlidersTrnaslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("sr_sliders")) {

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
        //dd($request->all());
         //$request->lang='en';
        $exist_lan = Sr_Slider_Translation::where(['sr_slider_id' => $request->sr_slider_id, 'locale' => $request->lang])->get();
         //dd($exist_lan);
        if (count($exist_lan) > 0) {
            return redirect()->back()->withErrors('Project Details in this Language already exist!');
        }
        $slider_tns = new Sr_Slider_Translation();
        $slider_tns->sr_slider_id = $request->sr_slider_id;
        $slider_tns->locale = $request->lang;
        $slider_tns->title = $request->title;
        $slider_tns->sub_title = $request->sub_title;
        $slider_tns->description_up = $request->description_up;
        $slider_tns->description_down = $request->description_down;
        $slider_tns->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));
        /* return redirect()->route(config('laraadmin.adminRoute') . '.sr_projects.index');*/
        return redirect()->route(config('laraadmin.adminRoute') . '.sr_sliders.edit', $slider_tns->sr_slider_id);
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
            //$project = Sr_Project::find($id);
            $languages = Language::get();
            $project_transtaltions = Sr_Project_Translation::find($id);
            //dd($project_transtaltions);
            return view('admin.save_refugee.projects.project_transtaltion_edit', compact(['project_transtaltions', 'languages']));
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
            $this->validate($request,[
                'title'=>'required',
                'sub_title'=>'required',
                'description_up'=>'required',
                'description_down'=>'required',
            ]);
            $sr_slider_tranlation = Sr_Slider_Translation::find($id);
            $sr_slider_tranlation->title = $request->title;
            $sr_slider_tranlation->sub_title = $request->sub_title;
            $sr_slider_tranlation->description_up = $request->description_up;
            $sr_slider_tranlation->description_down = $request->description_down;
            $sr_slider_tranlation->save();


            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_sliders.edit', $sr_slider_tranlation->sr_slider_id);

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
            $data = Sr_Project_Translation::find($id);
            $data->delete();

            $slider_trns = Sr_Slider_Translation::find($id);
            $slider = Sr_Slider::find($slider_trns->sr_slider_id);


            $slider_trns->forcedelete();
            $slider->forcedelete();

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
    public function getSliderLang(Request $request)
    {
        $slider_trns_dtls = Sr_Slider_Translation::find($request->id);
        return $slider_trns_dtls;
    }
}
