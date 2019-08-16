<?php

namespace App\Http\Controllers\Admin\Marriage_Management;

use App\Http\Requests\Marriage_Management\GiftRequest;
use App\Models\Gift;
use App\Repositories\ImageUploadRepo;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

class GiftsController extends Controller
{
    function __construct()
    {
        $this->path = public_path() . '/uploads/gifts/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Menu::hasAccess("gifts")) {
            $gifts = Gift::orderby('id', 'desc')->get();
            return View('admin.gifts.index', [
                'gifts' => $gifts,
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
        if (Menu::hasAccess("gifts", "create")) {
            return View('admin.gifts.create');
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
    public function store(GiftRequest $request)
    {
        $gifts = Gift::orderBy('id', 'desc')->get();
        $serial_no = $gifts->max('serial_no') + 1;
        $data = $request->except('image');
        $data['serial_no'] = $serial_no;
        //uploads image
        if ($request->hasFile('image')) {
            $data['image'] = ImageUploadRepo::uploadImage($this->path, $request->file('image'),'405-330');
        }
        Gift::create($data);
        Session::flash('message', Lang::get('messages.Saved successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.gifts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gifts)
    {
        if (Menu::hasAccess("gifts", "view")) {
            return View('admin.gifts.show', compact('gifts'));
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
    public function edit(Gift $gifts)
    {
        if (Menu::hasAccess('gifts', 'edit')) {
            return view('admin.gifts.edit', compact('gifts'));
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
    public function update(Request $request, Gift $gifts)
    {
        if (Menu::hasAccess('gifts', 'edit')) {
            $data = $request->except( 'image');
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $data['image'] = ImageUploadRepo::uploadImage($this->path, $request->file('image'),'405-330',$gifts->image);
            }
            $gifts->update($data);
            Session::flash('seccess_msg', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.gifts.index');

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
    public function destroy(Gift $gifts)
    {
        if (Menu::hasAccess("gifts", "delete")) {
            //delete existing image folder
            ImageUploadRepo::unlinkPath($gifts->image);

            $gifts->delete();
            Session::flash('seccess_msg', Lang::get('messages.Deleted successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.gifts.index');
        } else {
            return View('error');
        }
    }

    public function order()
    {
        if (Menu::hasAccess('gifts')) {
            $gifts = Gift::orderBy('serial_no', 'asc')->get();
            return View('admin.gifts.order', ['gifts' => $gifts]);
        } else {
            return View('error');
        }
    }

    public function orderUpdate(Request $request)
    {
        $gifts = Gift::orderBy('serial_no', 'asc')->get();
        foreach ($gifts as $gift) {
            $gift->timestamps = false;
            $id = $gift->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $gift->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }

}
