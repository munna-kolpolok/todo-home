<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Models\Press;
use App\Models\Press_Category;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;
use File;
use Image;

class PressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Menu::hasAccess("presses")) {

            $presses = Press::where('website_id', '1')->orderby('id','desc')->get();

            return View('admin.presses.index', [
                'values'=>$presses,
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
        if(Menu::hasAccess("presses", "create"))
        {
            $categories = Press_Category::where('website_id', '1')->get();
            return View('admin.presses.create',[
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
    public function store(Request $request)
    {
        //dd($request->published_date[0]);

        foreach($request->published_date as $index => $value) {
            if (!empty($request->press_link[$index]) && !empty($request->description[$index]) && !empty($request->bn_description[$index]) && !empty($request->image[$index])) {
                $presses = Press::orderBy('id', 'desc')->get();
                $serial_no = $presses->max('serial_no') + 1;
                $press = new Press();
                $press->website_id = $request->website;
                $press->press_category_id = $request->press_category_id[$index];
                $press->published_date = CommonHelper::databseDateTimeFormatWithCurrentTime($value);
                $press->description = $request->description[$index];
                $press->bn_description = $request->bn_description[$index];
                $press->press_link = $request->press_link[$index];
                $press->is_video = $request->is_video[$index];
                $press->serial_no = $serial_no;
                $press->save();

                /*Image upload*/
                $path = public_path() . '/uploads/press';
                $database_image_folder_path='/uploads/press';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {

                    $press_image = $request->image[$index];
                    $image_name = '/'.$press->id.'.'.$press_image->getClientOriginalExtension();
                    $press_path_image=$path . $image_name;

                    Image::make($press_image->getRealPath())->resize(431, 554)->save($press_path_image);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $press->image =$database_image_path;
                    $press->save();
                }
            } elseif(++$index > 1) {
                Session::flash('message',"Previous Data is Saved Successfully.");
                return redirect()->route(config('laraadmin.adminRoute') . '.presses.index')->withErrors(['emptyWarning' => "Row $index all fields are required."]);
            } else {
                return redirect()->back()->withErrors(['emptyWarning' => "All fields are required."]);
            }

        }
        Session::flash('message',Lang::get('messages.Saved successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.presses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Press $presses)
    {
        if (Menu::hasAccess("presses", "view")) {
            return View('admin.presses.show', compact('presses'));
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
    public function edit(Press $presses)
    {
        if (Menu::hasAccess('presses','edit')) {
            $categories = Press_Category::where('website_id', '1')->get();
            $published_date = str_replace('-', '/', date('d-m-Y', strtotime($presses->published_date)));
            return view('admin.presses.edit', compact('presses','categories', 'published_date'));
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
    public function update(Requests\GiftRequest $request, Press $presses)
    {
        if (Menu::hasAccess('presses','edit')) {
            $data = $request->except('published_date','image');
            $data['published_date'] = !is_null($request->published_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->published_date))) : '';
            /*Image upload or remove*/
            if ($request->hasFile('image')) {
                $path = public_path() . '/uploads/press';
                $database_image_folder_path='/uploads/press';

                if (!File::exists($path)) {
                    $path = File::makeDirectory($path, 0777, true, true);
                }

                if ($path == true) {
                    $existing_image = public_path().'/'.$presses->image;
                    if (file_exists($existing_image)) {
                        //first unlink the image
                        @unlink($existing_image);
                    }
                    $press_image = $request->image;
                    $image_name = '/'.$presses->id.'.'.$press_image->getClientOriginalExtension();
                    $press_path_image=$path . $image_name;

                    Image::make($press_image->getRealPath())->resize(431, 554)->save($press_path_image);

                    $database_image_path=$database_image_folder_path.$image_name;
                    $presses->image =$database_image_path;
                    $presses->save();
                }

            }
            $presses->update($data);
            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.presses.index');

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
    public function destroy(Press $presses)
    {
        if (Menu::hasAccess("presses", "delete")) {

            //delete existing image folder
            $image_path = public_path() . '/' . $presses->image;
            if (file_exists($image_path)) {
                //first unlink the image
                @unlink($image_path);
            }

            $presses->delete();

            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.presses.index');
        } else {
            return View('error');
        }
    }

    public function pressOrder()
    {
        if (Menu::hasAccess('Food_Projects')) {
            $presses = Press::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
            return View('admin.presses.order', ['presses' => $presses]);
        } else {
            return View('error');
        }
    }

    public function pressOrderUpdate(Request $request)
    {
        $presses = Press::where('website_id', '1')->orderBy('serial_no', 'asc')->get();
        foreach ($presses as $press) {
            $press->timestamps = false;
            $id = $press->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $press->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }

}
