<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Http\Requests\Refugee\ProjectStoryTranslationRequest;
use App\Http\Requests\Refugee\ProjectStoryTranslationUpdateRequest;
use App\Models\Sr_Project_Story;
use App\Models\Sr_Project_Story_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class ProjectStoryTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    public function getTranslation(Request $request)
    {
        $projectStoryTranslation = Sr_Project_Story_Translation::find($request->id);
        return response()->json($projectStoryTranslation);
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
    public function store(ProjectStoryTranslationRequest $request)
    {
        if (Menu::hasAccess('Sr_Project_Stories', "create")) {
            $projectStoryId = $request->sr_project_story_id;
            $locale = $request->lng;
            $findDuplicate = Sr_Project_Story_Translation::where(['sr_project_story_id'=>$projectStoryId,'locale' =>$locale])->first();
            if(count($findDuplicate) > 0) {
                return redirect()->back()->withErrors('You are already added this language.Please try again different language.');
            }
            $projectStoryTranslation = new Sr_Project_Story_Translation();
            $projectStoryTranslation->sr_project_story_id = $projectStoryId;
            $projectStoryTranslation->locale = $locale;
            $projectStoryTranslation->title = $request->title;
            $projectStoryTranslation->description = $request->description;
            $projectStoryTranslation->save();
            Session::flash('message', Lang::get('messages.Saved successfully'));
            return redirect()->back();
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStoryTranslationUpdateRequest $request, Sr_Project_Story_Translation $sr_project_story_translation)
    {
        if (Menu::hasAccess('Sr_Project_Stories', "create")) {
            $data['sr_project_story_id'] = $request->sr_project_story_id;
            $data['locale'] = $request->lng;
            $data['title'] = $request->title;
            $data['description'] = $request->description;
            $sr_project_story_translation->update($data);
            Session::flash('message', Lang::get('messages.Saved successfully'));
            return redirect()->back();
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
    public function destroy(Sr_Project_Story_Translation $sr_project_story_translation)
    {
        if (Menu::hasAccess("Sr_Projects", "delete")) {
            $sr_project_story_translation->forceDelete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->back();
        } else {
            return View('error');
        }
    }
}
