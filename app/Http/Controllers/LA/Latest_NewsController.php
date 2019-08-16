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

use App\Models\Latest_News;

class Latest_NewsController extends Controller
{
	public $show_action = true;
	public $view_col = 'news';
	public $listing_cols = ['id', 'website_id', 'news', 'bn_news', 'status'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Latest_News', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Latest_News', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Latest_News.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Latest_News');
		
		if(Menu::hasAccess('Latest_News')) {
			return View('la.latest_news.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new latest_news.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created latest_news in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Latest_News", "create")) {

            $latestNews = Latest_News::orderBy('id', 'desc')->get();
            $serial_no = $latestNews->max('serial_no') + 1;

			$rules = Module::validateRules("Latest_News", $request);
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

            $request->request->add(['serial_no' => $serial_no]);
            Latest_News::create($request->all());
			//$insert_id = Module::insert("Latest_News", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.latest_news.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified latest_news.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Latest_News", "view")) {
			
			$latest_news = Latest_News::find($id);
			if(isset($latest_news->id)) {
				$module = Module::get('Latest_News');
				$module->row = $latest_news;
				
				return view('la.latest_news.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('latest_news', $latest_news);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("latest_news"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified latest_news.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Latest_News", "edit")) {			
			$latest_news = Latest_News::find($id);
			if(isset($latest_news->id)) {	
				$module = Module::get('Latest_News');
				
				$module->row = $latest_news;
				
				return view('la.latest_news.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('latest_news', $latest_news);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("latest_news"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified latest_news in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Latest_News $latest_news)
	{
		if(Menu::hasAccess("Latest_News", "edit")) {
			
			$rules = Module::validateRules("Latest_News", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			$latest_news->update($request->all());
			//$insert_id = Module::updateRow("Latest_News", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.latest_news.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified latest_news from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Latest_News", "delete")) {
			Latest_News::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.latest_news.index');
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
		$values = DB::table('latest_news')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Latest_News');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/latest_news/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Latest_News", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/latest_news/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Latest_News", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.latest_news.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

    public function newsOrder()
    {
        if (Menu::hasAccess('Latest_News')) {
            $latestNews = Latest_News::orderBy('serial_no','asc')->get();
            return View('la.latest_news.order',['latestNews'=>$latestNews]);
        } else {
            return View('error');
        }
    }

    public function newsOrderUpdate(Request $request)
    {
        $latestNews = Latest_News::orderBy('serial_no','asc')->get();
        foreach ($latestNews as $news) {
            $news->timestamps = false;
            $id = $news->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $news->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
