<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Language;
use App\Models\Sr_Project;
use App\Models\Sr_Project_Faq;
use App\Models\Sr_Video;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;
//use File;
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
        if (Menu::hasAccess('Sr Videos')) {
            $videos = Sr_Video::orderby('id', 'desc')->get();
            return View('admin.save_refugee.videos.index', [
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
        if (Menu::hasAccess('Sr Videos', "create")) {
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
            'image' => 'image|mimes:jpeg,jpg,png|max:10000',
        ]);

        $sr_videos = new Sr_Video();
        $sr_videos->video_link = $request->video_link;
        $sr_videos->save();

        /*Image upload*/
        $database_image_path = null;
        $path = public_path() . '/uploads/videos/';
        $database_image_folder_path = '/uploads/videos/';

        if (!File::exists($path)) {
            $uploads_directory = File::makeDirectory($path, 0777, true, true);
        }
        if ($database_image_folder_path == true) {
            if ($request->hasFile('image')) {
                $sr_videos_image = $request->file('image');

                $sr_videos_image_name = $sr_videos->id . '.' . $sr_videos_image->getClientOriginalExtension();
                $sr_videos_path_image = $path . $sr_videos_image_name;

                Image::make($sr_videos_image->getRealPath())->resize(375, 257)->save($sr_videos_path_image);
                $database_image_path = $database_image_folder_path . $sr_videos_image_name;
                $sr_videos->image = $database_image_path;
                $sr_videos->save();
            }
        }



        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route(config('laraadmin.adminRoute') . '.sr_video.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess('Sr Videos', "view")) {

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
        if (Menu::hasAccess('Sr Videos', 'edit')) {

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
        if (Menu::hasAccess('Sr Videos', 'edit')) {
            $this->validate($request, [
                'image' => 'image|mimes:jpeg,jpg,png|max:10000',
            ]);

            $sr_video =  Sr_Video::find($id);
            $sr_video->video_link = $request->video_link;
            $sr_video->save();

            /*Image upload*/
            $database_image_path = null;
            $path = public_path() . '/uploads/videos/';
            $database_image_folder_path = '/uploads/videos/';

            if (!File::exists($path)) {
                $uploads_directory = File::makeDirectory($path, 0777, true, true);
            }

            if ($database_image_folder_path == true) {
                if ($request->hasFile('image')) {
                    $existing_image = public_path() . '/' . $sr_video->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $sr_video_image = $request->file('image');


                    $sr_video_image_name = $sr_video->id . '.' . $sr_video_image->getClientOriginalExtension();
                    $sr_video_path_image = $path . $sr_video_image_name;

                    Image::make($sr_video_image->getRealPath())->resize(375, 257)->save($sr_video_path_image);
                    $database_image_path = $database_image_folder_path . $sr_video_image_name;
                    $sr_video->image = $database_image_path;
                    $sr_video->save();
                }
            }
            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_video.index');

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
        if (Menu::hasAccess('Sr Videos', "delete")) {

            $video = Sr_Video::find($id);

            $image_path = public_path() . '/' . $video->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }
            $video->forcedelete();

            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_video.index');
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
    public function getVideo(Request $request)
    {
        $video = Sr_Video::find($request->id);

        return $video;
    }
}
