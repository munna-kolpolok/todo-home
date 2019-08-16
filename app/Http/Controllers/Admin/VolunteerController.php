<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VolunteerStoreUpdateRequest;
use App\Models\Contact;
use App\Models\Volunteer;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Lang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Menu::hasAccess('volunteers')) {
            $volunteers = Volunteer::where('website_id','1')->orderBy('id','desc')->get();
            return View('admin.volunteers.index',['volunteers'=>$volunteers]);
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
        $contacts = Contact::orderBy('name')->get(['id', 'name']);
        return view('admin.volunteers.create',compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VolunteerStoreUpdateRequest $request)
    {
        dd($request->all());
        if (Menu::hasAccess("volunteers", "store")) {
            dd($request->all());
            return View('admin.volunteers.show', compact('volunteer'));
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
        if (Menu::hasAccess("volunteers", "view")) {

            $volunteer = Volunteer::find($id);
            return View('admin.volunteers.show', compact('volunteer'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess("volunteers", "delete")) {
            $volunteer = Volunteer::find($id);

            //delete existing image folder
            $path = public_path() . '/uploads/volunteers/' . $volunteer->id;
            if (File::exists($path)){
                File::deleteDirectory($path);
            }

            $volunteer->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.volunteers.index');
        } else {
            return View('error');
        }
    }
}
