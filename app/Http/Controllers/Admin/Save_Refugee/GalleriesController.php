<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Http\Requests\Refugee\GalleryRequest;
use App\Http\Requests\Refugee\GalleryUpdateRequest;
use App\Models\Sr_Gallery;
use App\Models\Sr_Gallery_Translation;
use App\Repositories\SrProjectRepo;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Image;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Sr_Galleries")) {
            $galleries = Sr_Gallery::with('englishGallery','mainImage')->orderBy('id', 'desc')->get();
            //dd($galleries);
            return View('admin.save_refugee.gallery.index', compact('galleries'));
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
        if (Menu::hasAccess("Sr_Galleries",'create')) {
            return View('admin.save_refugee.gallery.create');
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
    public function store(GalleryRequest $request)
    {
        if (Menu::hasAccess("Sr_Galleries", "create")) {
            $data = [];
            $gallery = Sr_Gallery::create(['no_of_image' => 9]);
            $galleryId = $gallery->id;
            //Gallery Translation data
            $galleryTranslation = new Sr_Gallery_Translation();
            $galleryTranslation->sr_gallery_id = $galleryId;
            $galleryTranslation->album_name = $request->album_name;
            $galleryTranslation->locale = 'en';
            $galleryTranslation->save();

            //Image upload
            $database_image_path = null;
            $path = public_path() . '/uploads/gallery/' . $galleryId. '/';
            $database_image_folder_path = '/uploads/gallery/' . $galleryId. '/';

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
                    $gallery->gallery_images()->createMany($data);
                }
            }

            Session::flash('message', Lang::get('messages.Saved successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_galleries.index');

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
        if (Menu::hasAccess('Sr_Galleries', 'edit')) {
            $gallery = Sr_Gallery::with('galleriesTranslations')->find($id);
            $languageOptions = (new SrProjectRepo)->languagesExceptEnglish();
            $languageOptionsWithEnglish = (new SrProjectRepo)->languagesExceptEnglish(false);
            return view('admin.save_refugee.gallery.edit', compact('gallery', 'languageOptions', 'languageOptionsWithEnglish'));
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
    public function update(GalleryUpdateRequest $request, Sr_Gallery $sr_galleries)
    {
        $data = [];
        $galleryId = $sr_galleries->id;
        //Update album name
        $sr_galleries->englishGallery->album_name = $request->album_name;
        $sr_galleries->englishGallery->save();
        //define database and public path
        $database_image_path = null;
        $path = public_path() . '/uploads/gallery/' . $galleryId. '/';
        $database_image_folder_path = '/uploads/gallery/' . $galleryId. '/';

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
                    $existing_image_db = $sr_galleries->gallery_images()->where('image',$existing_image)->first();
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
            return redirect()->back()->with('message', Lang::get('messages.Saved successfully'));
        } else {
            redirect()->back()->withErrors('Upload Directory Does\'n exist.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sr_Gallery $sr_galleries)
    {
        if (Menu::hasAccess("Sr_Galleries", "delete")) {

            //delete existing image folder
            $path =  public_path() . '/uploads/gallery/' . $sr_galleries->id. '/';
            if (File::exists($path)) {
                File::deleteDirectory($path);
            }
            $sr_galleries->galleriesTranslations()->forceDelete();
            $sr_galleries->gallery_images()->forceDelete();
            $sr_galleries->forceDelete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.sr_galleries.index');
        } else {
            return View('error');
        }
    }
}
