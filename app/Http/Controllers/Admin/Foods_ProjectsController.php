<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Models\Food_Project;
use App\Models\Food_Item;
use App\Models\Food_Project_Detail;
use App\Models\Sector;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;;

class Foods_ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Menu::hasAccess("Food_Projects")) {

            $food_projects = Food_Project::orderby('id','desc')->get();

            return View('admin.food_projects.index', [
                'values'=>$food_projects,
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
        if(Menu::hasAccess("Food_Projects", "create"))
        {
            $food_items = Food_Item::orderBy('name')->get(['id', 'name','bn_name']);
            return View('admin.food_projects.create',compact('food_items'));
        }
        else
        {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\Food_ProjectsRequest $request)
    {
        $foodProjects = Food_Project::orderby('id','desc')->get();
        $serial_no = $foodProjects->max('serial_no') + 1;

        $data = $request->except('image','food_item_ids','sector_add');
        $data['serial_no'] = $serial_no;
        $data['created_ip_address'] = CommonHelper::getRealIpAddr();
        $food_projects = Food_Project::create($data);
        /*Image upload*/
        $path = public_path() . '/uploads/food_projects';
        $database_image_folder_path='/uploads/food_projects';

        if (!File::exists($path)) {
            $path = File::makeDirectory($path, 0777, true, true);
        }

        if ($path == true) {
            $food_project_image = $request->image;
            $image_name = '/'.$food_projects->id.'.'.$food_project_image->getClientOriginalExtension();
            $food_project_path_image=$path . $image_name;

            Image::make($food_project_image->getRealPath())->resize(310, 200)->save($food_project_path_image);
            $database_image_path=$database_image_folder_path.$image_name;
            $food_projects->image =$database_image_path;
            $food_projects->save();
        }

        if($request->food_menu==0){
            //Custom food menu
            foreach($request->food_item_ids as $index => $value) {

                $food_dtls = new Food_Project_Detail();
                $food_dtls->food_project_id = $food_projects->id;
                $food_dtls->food_item_id = $value;
                $food_dtls->save();
            }
        }

        /*Insert data to sector table when sector add = YES*/
        if($request->sector_add==1){
            /*Check name for website wize unique*/
            $isSectorExist=false;
            $Check_sectors = Sector::where('website_id',2)->get();
            if ($Check_sectors->contains('name', $food_projects->name)){
                $isSectorExist=true;
            }elseif ($Check_sectors->contains('bn_name', $food_projects->bn_name)){
                $isSectorExist=true;
            }

            if ($isSectorExist==false){
                $sector=new Sector();
                $sector->name=$food_projects->name;
                $sector->bn_name=$food_projects->bn_name;
                $sector->project_id=1;
                $sector->website_id=2;
                $sector->is_show=1;
                $sector->save();
            }

            /*Check name for website wize unique End */
        }
        /*End Insert data to sector table when sector add = YES*/

        Session::flash('message',Lang::get('messages.Saved successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.food_projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food_projects = Food_Project::find($id);
        $food_items = Food_Item::orderBy('name')->get(['id', 'name','bn_name']);
        $selected_food_items = Food_Project_Detail::where('food_project_id', $id)->get(['food_item_id']);
        if (Menu::hasAccess("Food_Projects", "view")) {
            return View('admin.food_projects.show', compact('food_projects','selected_food_items','food_items'));
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

        if (Menu::hasAccess('Food_Projects','edit')) {
            $food_projects = Food_Project::find($id);
            $food_items = Food_Item::orderBy('name')->get(['id', 'name','bn_name']);
            $selected_food_items = Food_Project_Detail::where('food_project_id', $id)->get(['food_item_id']);
            return view('admin.food_projects.edit', compact('food_projects','food_items','selected_food_items'));
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
    public function update(Requests\Food_ProjectsRequest $request,$id)
    {
        //dd($request->all()); die;
        $food_dtls = Food_Project_Detail::where('food_project_id', $id)->first();

        if (Menu::hasAccess('Food_Projects','edit')) {

            $food_projects = Food_Project::find($id);
            $food_projects->name=$request->name;
            $food_projects->bn_name=$request->bn_name;
            $food_projects->description=$request->description;
            $food_projects->bn_description=$request->bn_description;
            $food_projects->bn_description=$request->bn_description;
            $food_projects->min_no_unit=$request->min_no_unit;
            $food_projects->is_home=$request->is_home;
            $food_projects->is_menu=$request->is_menu;
            $food_projects->is_show=$request->is_show;
            $food_projects->food_menu=$request->food_menu;
            $food_projects->save();


           /*Image upload or remove*/
            if ($request->hasFile('image')) {

                $path = public_path() . '/uploads/food_projects';
                $database_image_folder_path='/uploads/food_projects';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path().'/'.$food_projects->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }

                    $food_project_image = $request->image;
                    $image_name = '/'.$food_projects->id.'.'.$food_project_image->getClientOriginalExtension();
                    $food_project_path_image=$path . $image_name;

                    Image::make($food_project_image->getRealPath())->resize(310, 200)->save($food_project_path_image);
                    $database_image_path=$database_image_folder_path.$image_name;
                    $food_projects->image =$database_image_path;
                    $food_projects->save();
                }
             }

            //Custom food menu
            if($request->food_menu==0){
                $old_items = Food_Project_Detail::where('food_project_id', $id)->get();
                $old_itemsArray=array();
                foreach($old_items as $val){
                    $old_itemsArray[$val->food_item_id]=$val->food_item_id;
                }
                $new_items=$request->food_item_ids;
                $insert_data=array_diff($new_items,$old_itemsArray);
                $delete_data=array_diff($old_itemsArray,$new_items);
                if(count($insert_data)>0){
                    /*New data insert*/
                    foreach($insert_data as $item){
                        $food_dtls = new Food_Project_Detail();
                        $food_dtls->food_project_id = $id;
                        $food_dtls->food_item_id = $item;
                        $food_dtls->save();
                    }
                }

                if(count($delete_data)>0){
                    /*Delete  from existing item*/
                    if (Menu::hasAccess("Food_Projects", "delete")) {
                        $del_item=implode(',',$delete_data);
                        $del_at=Carbon::now();
                        DB::statement("UPDATE `food_project_details` SET `deleted_at` = '$del_at' WHERE
`food_project_id` = $id AND food_item_id in($del_item)");
                    }
                }
            }else{
                /*delete all old food items*/
                $old_items = Food_Project_Detail::where('food_project_id', $id)->get();
                $old_itemsArray=array();
                foreach($old_items as $val){
                    $old_itemsArray[$val->food_item_id]=$val->food_item_id;
                }
                if(count($old_items)>0) {
                    $del_item = implode(',', $old_itemsArray);
                    $del_at = Carbon::now();
                    DB::statement("UPDATE `food_project_details` SET `deleted_at` = '$del_at' WHERE
`food_project_id` = $id AND food_item_id in($del_item)");
                }
            }
            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.food_projects.index');

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
        if (Menu::hasAccess("Food_Projects", "delete")) {

            //delete existing image folder
            $food_projects_data=Food_Project::find($id);
            $image_path = public_path() . '/' . $food_projects_data->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }
            $food_projects_data->delete();
            $old_items = Food_Project_Detail::where('food_project_id', $id)->get();
            $old_itemsArray=array();
            foreach($old_items as $val){
                $old_itemsArray[$val->food_item_id]=$val->food_item_id;
            }
            if(count($old_items)>0) {
                $del_item = implode(',', $old_itemsArray);
                $del_at = Carbon::now();
                DB::statement("UPDATE `food_project_details` SET `deleted_at` = '$del_at' WHERE
`food_project_id` = $id AND food_item_id in($del_item)");
            }

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.food_projects.index');
        } else {
            return View('error');
        }
    }

    public function foodProjectOrder()
    {
        if (Menu::hasAccess('Food_Projects')) {
            $foodProjects = Food_Project::orderBy('serial_no', 'asc')->get();
            return View('admin.food_projects.order', ['foodProjects' => $foodProjects]);
        } else {
            return View('error');
        }
    }

    public function foodProjectOrderUpdate(Request $request)
    {
        $foodProjects = Food_Project::orderBy('serial_no', 'asc')->get();
        foreach ($foodProjects as $project) {
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
