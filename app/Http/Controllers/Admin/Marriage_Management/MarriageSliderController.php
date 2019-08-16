<?php

namespace App\Http\Controllers\Admin\Marriage_Management;

use App\Http\Requests\Marriage_Management\WeddingSlidersRequest;
use App\Models\Slider;
use App\Models\Wedding_Slider;
use App\Repositories\ImageUploadRepo;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;

class MarriageSliderController extends Controller
{
    function __construct()
    {
        $this->path = public_path() . '/uploads/mr_sliders/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("Wedding_Sliders")) {
            $sliders = Wedding_Slider::orderby('id', 'desc')->get();
            return View('admin.wedding_sliders.index', [
                'sliders' => $sliders,
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
        if (Menu::hasAccess("Wedding_Sliders", "create")) {
            return View('admin.wedding_sliders.create');
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
    public function store(WeddingSlidersRequest $request)
    {
        $sliders = Wedding_Slider::orderBy('id', 'desc')->get();
        $serial_no = $sliders->max('serial_no') + 1;
        $data = $request->except('image');
        $data['serial_no'] = $serial_no;

        /*Image upload*/
        if ($request->hasFile('image')) {
            $data['image'] = ImageUploadRepo::uploadImage($this->path, $request->file('image'),'1220-844');
        }
        Wedding_Slider::create($data);
        Session::flash('message', Lang::get('messages.Saved successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.wedding_sliders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Wedding_Slider $wedding_sliders)
    {
        if (Menu::hasAccess("Wedding_Sliders", "view")) {
            return View('admin.wedding_sliders.show', compact('wedding_sliders'));
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
    public function edit(Wedding_Slider $wedding_sliders)
    {
        if (Menu::hasAccess('Wedding_Sliders', 'edit')) {
            return view('admin.wedding_sliders.edit', compact('wedding_sliders'));
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
    public function update(WeddingSlidersRequest $request, Wedding_Slider $wedding_sliders)
    {
        if (Menu::hasAccess('Wedding_Sliders', 'edit')) {
            $data = $request->except('image');
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $data['image'] = ImageUploadRepo::uploadImage($this->path, $request->file('image'),'1220-844',$wedding_sliders->image);
            }
            $wedding_sliders->update($data);
            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.wedding_sliders.index');
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
    public function destroy(Wedding_Slider $wedding_sliders)
    {
        if (Menu::hasAccess("Wedding_Sliders", "delete")) {
            //Unlink image
            ImageUploadRepo::unlinkPath($wedding_sliders->image);
            $wedding_sliders->delete();
            Session::flash('message', Lang::get('messages.Deleted successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.wedding_sliders.index');
        } else {
            return View('error');
        }

    }

    public function slidersOrder()
    {
        if (Menu::hasAccess('Wedding_Sliders')) {
            $sliders = Wedding_Slider::orderBy('serial_no', 'asc')->get();
            return View('admin.wedding_sliders.order', ['sliders' => $sliders]);
        } else {
            return View('error');
        }
    }

    public function slidersOrderUpdate(Request $request)
    {
        $sliders = Wedding_Slider::orderBy('serial_no', 'asc')->get();
        foreach ($sliders as $slider) {
            $slider->timestamps = false;
            $id = $slider->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $slider->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
