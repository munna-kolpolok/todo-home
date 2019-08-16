<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Http\Requests\Refugee\ProjectStoryRequest;
use App\Http\Requests\Refugee\ProjectStoryUpdateRequest;
use App\Models\Language;
use App\Models\Sr_Project_Story;
use App\Models\Sr_Project_Story_Image;
use App\Models\Sr_Project_Story_Translation;
use App\Repositories\SrProjectRepo;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Image;

class ProjectsStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Sr_Project_Stories")) {
            $projectStories = Sr_Project_Story::with('project', 'englishStory', 'mainImage')->orderBy('id', 'desc')->get();
            //dd($projectStories);
            return View('admin.save_refugee.projects_story.index', compact('projectStories'));
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
        if (Menu::hasAccess("Sr_Project_Stories", 'create')) {
            $projectOptions = (new SrProjectRepo)->projects();
            return View('admin.save_refugee.projects_story.create', compact('projectOptions'));
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
    public function store(ProjectStoryRequest $request)
    {
        if (Menu::hasAccess("Sr_Project_Stories", "create")) {
            $data = [];
            $projectId = $request->sr_project_id;
            $projectStoryData = $request->only('sr_project_id', 'video_link');
            $projectStoryData['no_of_image'] = $request->no_of_image ? $request->no_of_image : '0';
            //store project story data
            $projectStory = Sr_Project_Story::create($projectStoryData);
            //store project story translation data
            $projectStoryTranslation = new Sr_Project_Story_Translation();
            $projectStoryTranslation->sr_project_story_id = $projectStory->id;
            $projectStoryTranslation->locale = 'en';
            $projectStoryTranslation->title = $request->title;
            $projectStoryTranslation->description = $request->description;
            $projectStoryTranslation->save();

            //Image upload
            $database_image_path = null;
            $path = public_path() . '/uploads/projects/' . $projectId . '/project_stories/' . $projectStory->id . '/';
            $database_image_folder_path = '/uploads/projects/' . $projectId . '/project_stories/' . $projectStory->id . '/';

            if (!File::exists($path)) {
                $uploads_directory = File::makeDirectory($path, 0777, true, true);

                if ($uploads_directory == true) {
                    if ($request->hasFile('images')) {
                        //dd($request->images);
                        foreach ($request->images as $key => $image) {
                           // $image_name = $key . '.' . $image->getClientOriginalExtension();
                            $image_name = $key . '.' . 'jpg';
                            $projects_path_image = $path . $image_name;
                            Image::make($image->getRealPath())->resize(540, 370)->save($projects_path_image);
                            $data[$key]['image'] = $database_image_folder_path . $image_name;
                        }
                    }
                    $projectStory->projectStoryImages()->createMany($data);
                }
            }

            Session::flash('message', Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_story.index');

        } else {
            return View('error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('Sr_Project_Stories', 'edit')) {
            $sr_project_story = Sr_Project_Story::with('project', 'projectStoryTranslations', 'projectStoryImages')->find($id);
            $projectName = (new SrProjectRepo)->findProjectName($sr_project_story->sr_project_id);
            $projectOptions = (new SrProjectRepo)->projects();
            $languageOptions = (new SrProjectRepo)->languagesExceptEnglish();
            $languageOptionsWithEnglish = (new SrProjectRepo)->languagesExceptEnglish(false);
            return view('admin.save_refugee.projects_story.edit', compact('sr_project_story', 'projectOptions', 'languageOptions', 'languageOptionsWithEnglish', 'projectName'));
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
    public function update(ProjectStoryUpdateRequest $request, Sr_Project_Story $sr_project_story)
    {
        if (isset($request->images )) {
            $database_image_path = null;
            $path = public_path() . '/uploads/projects/' . $sr_project_story->sr_project_id . '/project_stories/' . $sr_project_story->id . '/';
            $database_image_folder_path = '/uploads/projects/' . $sr_project_story->sr_project_id . '/project_stories/' . $sr_project_story->id . '/';

            if (!File::exists($path)) {
                $path = File::makeDirectory($path, 0777, true, true);
            }

            if ($path == true) {
                //delete existing image

                foreach ($request->images as $key => $image) {
                    if (is_file($image)) {
                        $image_name = $key . '.' . 'jpg';
                        $existing_image = $database_image_folder_path.$image_name;
                        //find existing image in db
                        $existing_image_db = $sr_project_story->projectStoryImages()->where('image',$existing_image)->first();
                        //delete existing upload directory file
                        $existing_image_upload_directory=$path.$image_name;
                        if (file_exists($existing_image_upload_directory)) {
                            //first unlink the image
                            @unlink($existing_image_upload_directory);
                        }
                        //dd($existing_image_db);
                        $projects_path_image = $path . $image_name;
                        Image::make($image->getRealPath())->resize(540, 370)->save($projects_path_image);
                        $existing_image_db->image = $database_image_folder_path . $image_name;
                        $existing_image_db->save();
                    }
                }
                //Session::flash('message', Lang::get('messages.Saved successfully'));
            } else {
                redirect()->back()->withErrors('Upload Directory Does\'n exist.');
            }
        }
        $sr_project_story->video_link = $request->video_link;
        $sr_project_story->save();
        return redirect()->back()->with('message', Lang::get('messages.Saved successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sr_Project_Story $sr_project_story)
    {
        if (Menu::hasAccess("Sr_Projects", "delete")) {

            //delete existing image folder
            $path = public_path() . '/uploads/projects/' . $sr_project_story->sr_project_id . '/project_stories/' . $sr_project_story->id;
            if (File::exists($path)) {
                File::deleteDirectory($path);
            }
            $sr_project_story->projectStoryTranslations()->forceDelete();
            $sr_project_story->projectStoryImages()->forceDelete();
            $sr_project_story->forceDelete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_project_story.index');
        } else {
            return View('error');
        }
    }
}
