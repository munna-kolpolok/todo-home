<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Lang;
use Session;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Video_Category;

class Video_CategoriesController extends Controller
{
    public $show_action = true;
    public $view_col = 'name';
    public $listing_cols = ['id', 'website_id', 'name', 'bn_name'];

    public function __construct()
    {

        // Field Access of Listing Columns
        if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
            $this->middleware(function ($request, $next) {
                $this->listing_cols = ModuleFields::listingColumnAccessScan('Video_Categories', $this->listing_cols);
                return $next($request);
            });
        } else {
            $this->listing_cols = ModuleFields::listingColumnAccessScan('Video_Categories', $this->listing_cols);
        }
    }

    /**
     * Display a listing of the Video_Categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module = Module::get('Video_Categories');

        if (Menu::hasAccess('Video_Categories')) {
            return View('la.video_categories.index', [
                'show_actions' => $this->show_action,
                'listing_cols' => $this->listing_cols,
                'module' => $module
            ]);
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for creating a new video_category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created video_category in database.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Menu::hasAccess("Video_Categories", "create")) {

            $videoCategories = Video_Category::orderBy('id','desc')->get(['serial_no']);
            $serial_no = $videoCategories->max('serial_no') + 1;

            $rules = Module::validateRules("Video_Categories", $request);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->all();
            $data['serial_no'] = $serial_no;
            Video_Category::create($data);

            //$insert_id = Module::insert("Video_Categories", $request);


            Session::flash('message', Lang::get('messages.Saved successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.video_categories.index');

        } else {
            return View('error');
        }
    }

    /**
     * Display the specified video_category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("Video_Categories", "view")) {

            $video_category = Video_Category::find($id);
            if (isset($video_category->id)) {
                $module = Module::get('Video_Categories');
                $module->row = $video_category;

                return view('la.video_categories.show', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding"
                ])->with('video_category', $video_category);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("video_category"),
                ]);
            }
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for editing the specified video_category.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess("Video_Categories", "edit")) {
            $video_category = Video_Category::find($id);
            if (isset($video_category->id)) {
                $module = Module::get('Video_Categories');

                $module->row = $video_category;

                return view('la.video_categories.edit', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                ])->with('video_category', $video_category);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("video_category"),
                ]);
            }
        } else {
            return View('error');
        }
    }

    /**
     * Update the specified video_category in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Menu::hasAccess("Video_Categories", "edit")) {

            $rules = Module::validateRules("Video_Categories", $request, true);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();;
            }

            $insert_id = Module::updateRow("Video_Categories", $request, $id);

            Session::flash('message', Lang::get('messages.Updated successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.video_categories.index');

        } else {
            return View('error');
        }
    }

    /**
     * Remove the specified video_category from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess("Video_Categories", "delete")) {
            Video_Category::find($id)->delete();

            // Redirecting to index() method
            Session::flash('message', Lang::get('messages.Deleted successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.video_categories.index');
        } else {
            return View('error');
        }
    }

    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax()
    {
        $values = DB::table('video_categories')
            ->select($this->listing_cols)
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc');
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Video_Categories');

        for ($i = 0; $i < count($data->data); $i++) {
            for ($j = 0; $j < count($this->listing_cols); $j++) {
                $col = $this->listing_cols[$j];
                if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if ($col == $this->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/video_categories/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if ($this->show_action) {
                $output = '';
                if (Menu::hasAccess("Video_Categories", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/video_categories/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if (Menu::hasAccess("Video_Categories", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.video_categories.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    public function videoOrder()
    {
        if (Menu::hasAccess('projects')) {
            $videoCategories = Video_Category::orderBy('serial_no', 'asc')->get();
            return View('la.video_categories.order', ['videoCategories' => $videoCategories]);
        } else {
            return View('error');
        }
    }

    public function videoOrderUpdate(Request $request)
    {
        $videoCategories = Video_Category::orderBy('serial_no', 'asc')->get();
        foreach ($videoCategories as $videoCategory) {
            $videoCategory->timestamps = false;
            $id = $videoCategory->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $videoCategory->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);

    }

}
