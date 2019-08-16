<?php

namespace App\Http\Controllers\Admin\Save_Refugee;

use App\Models\Sr_Gallery_Translation;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class GalleryTranslationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getTranslation(Request $request)
    {
        $galleryTranslation = Sr_Gallery_Translation::find($request->id);
        return response()->json($galleryTranslation);
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
    public function store(Request $request)
    {
        if (Menu::hasAccess('Sr_Galleries', "create")) {
            $galleryId = $request->sr_gallery_id;
            $locale = $request->lng;
            $findDuplicate = Sr_Gallery_Translation::where(['sr_gallery_id'=>$galleryId,'locale' =>$locale])->first();
            if(count($findDuplicate) > 0) {
                return redirect()->back()->withErrors('You are already added this language.Please try again different language.');
            }
            $galleryTranslation = new Sr_Gallery_Translation();
            $galleryTranslation->sr_gallery_id = $galleryId;
            $galleryTranslation->locale = $locale;
            $galleryTranslation->album_name = $request->album_name;
            $galleryTranslation->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sr_Gallery_Translation $sr_galleries_translation)
    {
        if (Menu::hasAccess('Sr_Galleries', "create")) {
            $data['album_name'] = $request->album_name;
            $sr_galleries_translation->update($data);
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
    public function destroy(Sr_Gallery_Translation $sr_galleries_translation)
    {
        if (Menu::hasAccess("Sr_Galleries", "delete")) {
            $sr_galleries_translation->forceDelete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->back();
        } else {
            return View('error');
        }
    }
}
