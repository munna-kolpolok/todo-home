<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\User_Level;

class User_LevelsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('User_Levels', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('User_Levels', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the User_Levels.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('User_Levels');
		
		if(Menu::hasAccess('User_Levels')) {
			return View('la.user_levels.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new user_level.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created user_level in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("User_Levels", "create")) {
		
			$rules = Module::validateRules("User_Levels", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("User_Levels", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.user_levels.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified user_level.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("User_Levels", "view")) {
			
			$user_level = User_Level::find($id);
			if(isset($user_level->id)) {
				$module = Module::get('User_Levels');
				$module->row = $user_level;
				
				return view('la.user_levels.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('user_level', $user_level);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("user_level"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified user_level.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("User_Levels", "edit")) {			
			$user_level = User_Level::find($id);
			if(isset($user_level->id)) {	
				$module = Module::get('User_Levels');
				
				$module->row = $user_level;
				
				return view('la.user_levels.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('user_level', $user_level);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("user_level"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified user_level in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("User_Levels", "edit")) {
			
			$rules = Module::validateRules("User_Levels", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("User_Levels", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.user_levels.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified user_level from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("User_Levels", "delete")) {
			User_Level::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.user_levels.index');
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
		$values = DB::table('user_levels')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('User_Levels');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/user_levels/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("User_Levels", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/user_levels/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("User_Levels", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.user_levels.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
