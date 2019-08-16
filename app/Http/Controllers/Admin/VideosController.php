<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Models\Video_Category;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("videos")) {
            $videos = Video::where('website_id', '1')->orderby('id', 'desc')->get();
            return View('admin.videos.index', [
                'values' => $videos,
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
        if (Menu::hasAccess("videos", "create")) {
            $categories = Video_Category::where('website_id', '1')->get();
            // echo "video create page.."; die;
            return View('admin.videos.create', [
                'categories' => $categories,
            ]);
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
    public function store(Requests\VideoRequest $request)
    {
        foreach ($request->video_category_id as $index => $value) {
            $video = new Video();
            $video->video_category_id = $request->video_category_id[$index];
            $video->video_link = $request->video_link[$index];
            $video->website_id = $request->website;
            $video->save();

            /*Image upload*/
            $path = public_path() . '/uploads/videos';
            $database_image_folder_path = '/uploads/videos';

            if (!File::exists($path)) {
                $path = File::makeDirectory($path, 0777, true, true);
            }

            if ($path == true) {

                $video_image = $request->image[$index];
                $image_name = '/' . 'bidyanondo-'.$video->id.'-'.time() . '.' . $video_image->getClientOriginalExtension();
                $video_image_path = $path . $image_name;

                Image::make($video_image->getRealPath())->resize(348, 235)->save($video_image_path);

                $database_image_path = $database_image_folder_path . $image_name;
                $video->image = $database_image_path;
                $video->save();
            }


        }
        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.videos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $videos)
    {
        if (Menu::hasAccess("videos", "view")) {
            return View('admin.videos.show', compact('videos'));
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
    public function edit(Video $videos)
    {
        if (Menu::hasAccess('videos', 'edit')) {
            $categories = Video_Category::where('website_id', '1')->get();
            return view('admin.videos.edit', compact('videos', 'categories'));
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
    public function update(Requests\VideoUpdateRequest $request, Video $videos)
    {
        if (Menu::hasAccess('videos', 'edit')) {
            $data = $request->except('image');

            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/videos';
                $database_image_folder_path = '/uploads/videos';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path() . '/' . $videos->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $video_image = $request->image;
                    $image_name = '/' . 'bidyanondo-'.$videos->id.'-'.time() . '.' . $video_image->getClientOriginalExtension();
                    $video_image_path = $path . $image_name;

                    Image::make($video_image->getRealPath())->resize(348, 235)->save($video_image_path);

                    $database_image_path = $database_image_folder_path . $image_name;
                    $videos->image = $database_image_path;
                    $videos->website_id = 1;
                    $videos->save();
                }

            }
            $videos->update($data);
            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.videos.index');

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
    public function destroy(Video $videos)
    {
        if (Menu::hasAccess("videos", "delete")) {

            //delete existing image folder
            $image_path = public_path() . '/' . $videos->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            $videos->delete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.videos.index');
        } else {
            return View('error');
        }

    }

    /*Get Ajax data */
    public function get_video_cat_ajax(Request $request)
    {
        //return $request->website;
        //return  "SELECT id, name FROM video_categories WHERE website='$request->website' and deleted_at is null";
        $results = DB::SELECT("SELECT id, name FROM video_categories WHERE website_id='$request->website' and deleted_at is null");
        $cat_options = array();
        foreach ($results as $data) {
            $cat_options[$data->id] = $data->name;
        }
        return json_encode($cat_options);
    }
}
