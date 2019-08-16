<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\Project_Type;
use App\Models\Sector;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CommonHelper;
use Image;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess('projects')) {
            $projects = Project::orderBy('id','desc')->get();
            return View('admin.projects.index',['projects'=>$projects]);
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
        if (Menu::hasAccess('projects','create')) {
            $project_types = Project_Type::orderBy('id','desc')->get();
            $projects = Project::where('parent', null)->orderBy('id','desc')->get();
            return View('admin.projects.create', compact('project_types','projects'));
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
    public function store(ProjectRequest $request)
    {
        if (Menu::hasAccess("projects", "create")) {
            $projects = Project::orderBy('id','desc')->get(['serial_no']);
            $serial_no = $projects->max('serial_no') + 1;
            $user_id = Auth::id();
            $data = $request->except(['parent', 'project_type_id', 'project_start_date','project_image','project_big_image','project_background_image','sector_add']);
            $data['project_start_date'] = !is_null($request->project_start_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->project_start_date))) : '';
            $data['project_type_id'] = !empty($request->project_type_id) ? $request->project_type_id : null;
            $data['parent'] = !empty($request->parent) ? $request->parent : null;
            $data['created_by'] =$user_id;
            $data['serial_no'] = $serial_no;
            $data['created_ip_address'] = CommonHelper::getRealIpAddr();

            $project = Project::create($data);

            //upload image if exist
            $path = public_path() . '/uploads/projects/' . $project->id;
            $database_image_folder_path='/uploads/projects/' . $project->id;

            if (!File::exists($path)) {
                $project_upload_directory = File::makeDirectory($path, 0777, true, true);

                if ($project_upload_directory == true) {
                    //Image 1
                    if ($request->hasFile('project_image')) {
                        $project_image = $request->file('project_image');

                        $request->name = preg_replace('/\s\s+/', ' ', $request->name);// remove multiple space
                        $img_new_name=str_replace(' ', '-', $request->name).'-small-'.time();
                        $image_name = '/'.$img_new_name.'.' .$project_image->getClientOriginalExtension();
                        $project_path_image=$path . $image_name;

                        Image::make($project_image->getRealPath())->resize(600, 422)->save($project_path_image);

                        $database_image_path=$database_image_folder_path.$image_name;
                        $project->project_image =$database_image_path;
                        $project->save();
                    }
                    //Image 2
                    if ($request->hasFile('project_big_image')) {
                        $project_big_image = $request->file('project_big_image');

                        $request->name = preg_replace('/\s\s+/', ' ', $request->name);// remove multiple space
                        $img_new_name=str_replace(' ', '-', $request->name).'-big-'.time();
                        $image_name = '/'.$img_new_name.'.'.$project_big_image->getClientOriginalExtension();
                        $project_path_image=$path . $image_name;

                        Image::make($project_big_image->getRealPath())->resize(450, 500)->save($project_path_image);

                        $database_image_path=$database_image_folder_path.$image_name;
                        $project->project_big_image =$database_image_path;
                        $project->save();
                    }

                }

            }

            /*Insert data to sector table when sector add = YES*/
            if($request->sector_add==1){
                /*Check name for website wize unique*/
                $isSectorExist=false;
                $Check_sectors = Sector::where('website_id',1)->get();
                if ($Check_sectors->contains('name', $project->name)){
                    $isSectorExist=true;
                }elseif ($Check_sectors->contains('bn_name', $project->bn_name)){
                    $isSectorExist=true;
                }

                if ($isSectorExist==false){
                    $sector=new Sector();
                    $sector->name=$project->name;
                    $sector->bn_name=$project->bn_name;
                    $sector->project_id=$project->id;
                    $sector->is_show=1;
                    $sector->save();
                }

                /*Check name for website wize unique End */
            }
            /*End Insert data to sector table when sector add = YES*/

            Session::flash('seccess_msg',Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.projects.index');

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
        if (Menu::hasAccess("projects", "view")) {

            $project = Project::find($id);
            return View('admin.projects.show', compact('project'));
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('projects','edit')) {
            $project_types = Project_Type::orderBy('id','desc')->get();
            $projects = Project::where('parent', null)->orderBy('id','desc')->get();
            $project = Project::find($id);
            $project_start_day = str_replace('-', '/', date('d-m-Y', strtotime($project->project_start_date)));
            return View('admin.projects.edit', compact('project_types', 'projects', 'project','project_start_day'));
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
    public function update(ProjectRequest $request, $id)
    {
        if (Menu::hasAccess("projects", "edit")) {
            $user_id=Auth::id();

            $project = Project::find($id);

            $data = $request->except(['parent', 'project_type_id', 'project_start_date']);
            $data['project_start_date'] = !is_null($request->project_start_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->project_start_date))) : '';

            $data['project_type_id'] = !empty($request->project_type_id) ? $request->project_type_id : null;
            $data['parent'] = !empty($request->parent) ? $request->parent : null;;
            $data['updated_by'] =$user_id;
            $data['updated_ip_address'] = CommonHelper::getRealIpAddr();

            $project->update($data);

            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.projects.index');

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
    public function destroy($id)
    {
        if (Menu::hasAccess("projects", "delete")) {
            Sector::where('project_id',$id)->delete();
            $project = Project::find($id);

            //delete existing image folder
            $path = public_path() . '/uploads/projects/' . $project->id;
            if (File::exists($path)){
                File::deleteDirectory($path);
            }

            $project->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.projects.index');
        } else {
            return View('error');
        }
    }

    public function image($id)
    {
        $project = Project::find($id);
        return View('admin.projects.image_showcase', compact('project'));

    }

    public function updateImage($id, ProductImageRequest $request)
    {

        $project = Project::find($id);
        $project_path = public_path() . '/uploads/projects/'. $project->id;

        $database_image_folder_path='/uploads/projects/'. $project->id;
        //Image 1
        if ($request->hasFile('project_image')) {
            $project_image = $request->file('project_image');

            $project->name = preg_replace('/\s\s+/', ' ', $project->name);// remove multiple space
            $img_new_name=str_replace(' ', '-', $project->name).'-small-'.time();
            $image_name = '/'.$img_new_name.'.' .$project_image->getClientOriginalExtension();

            $project_path_image=$project_path . $image_name;
            $project_path_image_old= public_path() .$project->project_image;
            if (file_exists($project_path_image_old)) {
                //first unlink the image
                @unlink($project_path_image_old);
            }
            Image::make($project_image->getRealPath())->resize(600, 422)->save($project_path_image);

            $database_image_path=$database_image_folder_path.$image_name;
            $project->project_image =$database_image_path;
            $project->save();
        }
        //Image 2
        if ($request->hasFile('project_big_image')) {
            $project_poster_image = $request->file('project_big_image');

            $project->name = preg_replace('/\s\s+/', ' ', $project->name);// remove multiple space
            $img_new_name=str_replace(' ', '-', $project->name).'-big-'.time();
            $image_name = '/'.$img_new_name.'.'.$project_poster_image->getClientOriginalExtension();

            $project_path_image=$project_path . $image_name;
            $project_path_image_old= public_path() .$project->project_big_image;
            if (file_exists($project_path_image_old)) {
                //first unlink the image
                @unlink($project_path_image_old);
            }
            Image::make($project_poster_image->getRealPath())->resize(450, 500)->save($project_path_image);
            $database_image_path=$database_image_folder_path.$image_name;
            $project->project_big_image =$database_image_path;
            $project->save();
        }


        Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.projects.index');

    }

    public function projectOrder()
    {
        if (Menu::hasAccess('projects')) {
            $projects = Project::orderBy('serial_no','asc')->get();
            return View('admin.projects.order',['projects'=>$projects]);
        } else {
            return View('error');
        }
    }

    public function projectOrderUpdate(Request $request)
    {
        $projects = Project::orderBy('serial_no','asc')->get();
        foreach ($projects as $project) {
            $project->timestamps = false;
            $id = $project->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $project->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }

}
