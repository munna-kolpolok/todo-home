<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Gallery_Category;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Menu::hasAccess("galleries")) {
            $galleries = Gallery::where('website_id', '1')->orderby('id','desc')->get();
            return View('admin.galleries.index', [
                'values'=>$galleries,
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
        if(Menu::hasAccess("galleries", "create"))
        {
            $categories = Gallery_Category::where('website_id', '1')->get();
            return View('admin.galleries.create',[
                'categories'=>$categories,
            ]);
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
    public function store(Requests\GalleryRequest $request)
    {
        foreach($request->images as $index => $image) {
                $galleries = new Gallery();
                $galleries->gallery_category_id = $request->gallery_category_id;
                $galleries->website_id = 1;
                $galleries->save();

                /*Image upload*/
                $path = public_path() . '/uploads/gallery';
                $database_image_folder_path='/uploads/gallery';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if (File::exists($path)) {
                    $gallery_image = $image;
                    $gallery_big_image = '/'.'bidyanondo-'.$galleries->id.'-'.time().'-big.'.$gallery_image->getClientOriginalExtension();
                    $gallery_big_image_path=$path . $gallery_big_image;

                    $image_name = '/'.'bidyanondo-'.$galleries->id.'-'.time().'.'.$gallery_image->getClientOriginalExtension();
                    $gallery_image_path=$path . $image_name;

                    Image::make($gallery_image->getRealPath())->resize(800, 550)->save($gallery_big_image_path);
                    Image::make($gallery_image->getRealPath())->resize(360, 250)->save($gallery_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$gallery_big_image;
                    $galleries->gallery_big_image =$database_image_path_big;
                    $galleries->gallery_image =$database_image_path;
                    //dd($galleries->gallery_image);
                    $galleries->save();
                }
        }
        Session::flash('message',Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.galleries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $galleries)
    {
        if (Menu::hasAccess("galleries", "view")) {
            return View('admin.galleries.show', compact('galleries'));
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
    public function edit(Gallery $galleries)
    {
        if (Menu::hasAccess('galleries','edit')) {
             $categories = Gallery_Category::where('website_id', '1')->get();
            return view('admin.galleries.edit', compact('galleries','categories'));
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
    public function update(Requests\GalleryUpdateRequest $request, Gallery $galleries)
    {
         if (Menu::hasAccess('galleries','edit')) {
            $data = $request->except('image');
            
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/gallery';
                $database_image_folder_path='/uploads/gallery';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path().'/'.$galleries->image;
                    $image_big_path = public_path() . '/' . $galleries->gallery_big_image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                        @unlink($image_big_path);
                    }
                     $gallery_image = $request->image;

                    $gallery_big_image = '/'.'bidyanondo-'.$galleries->id.'-'.time().'-big.'.$gallery_image->getClientOriginalExtension();
                    $gallery_big_image_path=$path . $gallery_big_image;

                    $image_name = '/'.'bidyanondo-'.$galleries->id.'-'.time().'.'.$gallery_image->getClientOriginalExtension();
                    $gallery_image_path=$path . $image_name;

                    Image::make($gallery_image->getRealPath())->resize(800, 550)->save($gallery_big_image_path);
                    Image::make($gallery_image->getRealPath())->resize(360, 250)->save($gallery_image_path);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $database_image_path_big=$database_image_folder_path.$gallery_big_image;
                    $galleries->gallery_big_image =$database_image_path_big;
                    $galleries->website_id = $request->website;
                    $galleries->gallery_image =$database_image_path;
                    $galleries->save();
                }

            }
            $galleries->update($data);
            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.galleries.index');

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
    public function destroy(Gallery $galleries)
    {
       if (Menu::hasAccess("galleries", "delete")) {

            //delete existing image folder
            $image_path = public_path() . '/' . $galleries->gallery_image;
            $image_big_path = public_path() . '/' . $galleries->gallery_big_image;
            //$image_path = public_path() . '/' . $galleries->gallery_image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
                @unlink($image_big_path);
            }

            $galleries->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.galleries.index');
        } else {
            return View('error');
        }
    
    }

    /*Get ajax data */
    public function get_gallery_cat_ajax(Request $request){
        //return $request->website;
        //return  "SELECT id, name FROM press_categories WHERE website='$request->website' and deleted_at is null";
        $results= DB::SELECT("SELECT id, name FROM gallery_categories WHERE website='$request->website' and deleted_at is null");
        $cat_options=array();
        foreach($results as $data){
            $cat_options[$data->id]=$data->name;
        }
        return json_encode($cat_options);
    }
}
