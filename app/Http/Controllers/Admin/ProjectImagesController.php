<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectImagesRequest;
use App\Http\Requests\ProjectImageUpdateRequest;
use App\Models\Project;
use App\Models\Project_Image;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProjectImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('Project_Images')) {
            $projects = Project::orderBy('id')->get();
            $images = Project_Image::with('project')->orderBy('id', 'desc')->get();
            return View('admin.project_images.index',['images'=>$images,'projects' => $projects,'firstProject' => $projects->first()]);
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
        if (Menu::hasAccess('Project_Images','create')) {
            $projects = Project::orderBy('id','desc')->get();
            return View('admin.project_images.create',['projects'=>$projects]);
        } else {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectImagesRequest $request)
    {
        if (Menu::hasAccess('Project_Images','create')) {
            $data = [];
            $projectImages = Project_Image::orderBy('id', 'desc')->get();
            $serial_no = $projectImages->max('serial_no') + 1;
            $project_id = $request->project_id;

            foreach($request->images as $index => $image) {
                $incressSerialNo = $serial_no++;
                $path = public_path() . '/uploads/projects/'.$project_id.'/project_images/';
                $database_image_folder_path='/uploads/projects/'.$project_id.'/project_images/';

                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $project_image = $image;
                    $project_big_image = 'bidyanondo-project-images-'.$incressSerialNo.'-big.'.$project_image->getClientOriginalExtension();
                    $project_big_image_path= $path . $project_big_image;

                    $image_name = 'bidyanondo-project-images-'.$incressSerialNo.'.'.$project_image->getClientOriginalExtension();
                    $project_image_path=$path . $image_name;

                    Image::make($project_image->getRealPath())->resize(800, 550)->save($project_big_image_path);
                    Image::make($project_image->getRealPath())->resize(360, 250)->save($project_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$project_big_image;
                    $data[$index]['big_image'] =$database_image_path_big;
                    $data[$index]['image'] =$database_image_path;
                    $data[$index]['serial_no'] = $incressSerialNo;
                    $data[$index]['project_id'] = $project_id;
                }
            }
            Project_Image::insert($data);
            Session::flash('message',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.project_images.index');
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
    public function edit(Project_Image $project_images)
    {
        if (Menu::hasAccess('project_images','edit')) {
            $projects = Project::orderBy('id','desc')->get();
            return view('admin.project_images.edit', compact('projects','project_images'));
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectImageUpdateRequest $request, Project_Image $project_images)
    {
        if (Menu::hasAccess('project_images','edit')) {
            $data = $request->except('image');
            $project_id = $request->project_id;
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/projects/'.$project_id.'/project_images/';
                $database_image_folder_path='/uploads/projects/'.$project_id.'/project_images/';
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $existing_image = public_path().'/'.$project_images->image;
                    $existing_big_image = public_path().'/'.$project_images->big_image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                        @unlink($existing_big_image);
                    }
                    $project_image = $request->image;
                    $project_big_image = '/'.'bidyanondo-project-images-'.$project_images->id.'-'.time().'-big.'.$project_image->getClientOriginalExtension();
                    $project_big_image_path=$path . $project_big_image;

                    $image_name = '/'.'bidyanondo-project-images-'.$project_images->id.'-'.time().'.'.$project_image->getClientOriginalExtension();
                    $project_image_path=$path . $image_name;

                    Image::make($project_image->getRealPath())->resize(800, 550)->save($project_big_image_path);
                    Image::make($project_image->getRealPath())->resize(360, 250)->save($project_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$project_big_image;
                    $data['big_image'] = $database_image_path_big;
                    $data['image'] = $database_image_path;
                }

            }
            $project_images->update($data);
            Session::flash('message',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.project_images.index');

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
    public function destroy(Project_Image $project_images)
    {
        if (Menu::hasAccess("project_images", "delete")) {
            //delete existing image folder
            $image_path = public_path() . '/' . $project_images->image;
            $image_big_path = public_path() . '/' . $project_images->big_image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
                @unlink($image_big_path);
            }
            $project_images->delete();
            Session::flash('message',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.project_images.index');
        } else {
            return View('error');
        }
    }

    public function projectImageOrder($id)
    {
        if (Menu::hasAccess('project_images')) {
            $projectImages = Project_Image::where('project_id',$id)->with('project')->orderBy('serial_no','asc')->get();
            return View('admin.project_images.order',['projectImages'=>$projectImages, 'projectId' => $id]);
        } else {
            return View('error');
        }
    }

    public function projectImageOrderUpdate(Request $request)
    {
        $id = $request->project_id;
        $projectImages = Project_Image::where('project_id',$id)->orderBy('serial_no','asc')->get();
        foreach ($projectImages as $image) {
            $image->timestamps = false;
            $id = $image->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $image->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
