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

use App\Models\Religion;

class ReligionsController extends Controller
{
	public $show_action = true;
	public $view_col = 'religion_name';
	public $listing_cols = ['id', 'religion_name', 'religion_bn_name'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Religions', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Religions', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Religions.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Religions');
		
		if(Menu::hasAccess('Religions')) {
			return View('la.religions.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new religion.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created religion in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Religions", "create")) {
		
			$rules = Module::validateRules("Religions", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Religions", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.religions.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified religion.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Religions", "view")) {
			
			$religion = Religion::find($id);
			if(isset($religion->id)) {
				$module = Module::get('Religions');
				$module->row = $religion;
				
				return view('la.religions.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('religion', $religion);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("religion"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified religion.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Religions", "edit")) {			
			$religion = Religion::find($id);
			if(isset($religion->id)) {	
				$module = Module::get('Religions');
				
				$module->row = $religion;
				
				return view('la.religions.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('religion', $religion);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("religion"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified religion in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("Religions", "edit")) {
			
			$rules = Module::validateRules("Religions", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Religions", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.religions.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified religion from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Religions", "delete")) {
			Religion::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.religions.index');
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
		$values = DB::table('religions')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Religions');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/religions/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Religions", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/religions/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Religions", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.religions.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
