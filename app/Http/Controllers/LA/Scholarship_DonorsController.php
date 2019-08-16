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
use App\Helpers\CommonHelper;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Scholarship_Donor;
use App\Models\User;
use App\Models\Student;

class Scholarship_DonorsController extends Controller
{
	public $show_action = true;
	public $view_col = 'student_id';
	public $listing_cols = ['id', 'student_id', 'user_id'];
	
	public function __construct() {

		// Field Access of Listing Columns
		// if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
		// 	$this->middleware(function ($request, $next) {
		// 		$this->listing_cols = ModuleFields::listingColumnAccessScan('Scholarship_Donors', $this->listing_cols);
		// 		return $next($request);
		// 	});
		// } else {
		// 	$this->listing_cols = ModuleFields::listingColumnAccessScan('Scholarship_Donors', $this->listing_cols);
		// }
	}
	
	/**
	 * Display a listing of the Scholarship_Donors.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Scholarship_Donors');
		
		if(Menu::hasAccess('Scholarship_Donors')) {
			/*
			$students=DB::SELECT("SELECT s.`id`,s.`id_card`,s.`name`
			FROM `students` s
			WHERE s.id not in
			(SELECT student_id FROM `scholarship_donors` WHERE `deleted_at` is null)
			and s.deleted_at is null");
			*/
			$students=Student::orderBy('id_card','asc')->get();
            $donors=User::where('user_level',1)
            ->where('is_donor',1)
            ->get(['id','email']);

           	$scholarship_donors=Scholarship_Donor::orderBy('id','desc')->get();
			return View('la.scholarship_donors.index', [
				'show_actions' => $this->show_action,
				'values' => $scholarship_donors,
				'module' => $module,
				'donors' => $donors,
				'students' => $students,
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new scholarship_donor.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created scholarship_donor in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Scholarship_Donors", "create")) {
		
			$rules = Module::validateRules("Scholarship_Donors", $request);

			$messsages = array(
		        'student_id.unique'=>Lang::get('messages.This Student is already assigned to this Donor')
		    );
			//$table_name,$unique_field,$dependent_field,$dependent_input,$edit_field,$edit_id=null
			$rules = array(
                'student_id' => CommonHelper::twoFieldUniqueValidation('scholarship_donors','student_id','user_id','user_id','id'),
            );

			$validator = Validator::make($request->all(), $rules,$messsages);
			
			//$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Scholarship_Donors", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.scholarship_donors.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified scholarship_donor.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Scholarship_Donors", "view")) {
			
			$scholarship_donor = Scholarship_Donor::find($id);
			if(isset($scholarship_donor->id)) {
				$module = Module::get('Scholarship_Donors');
				$module->row = $scholarship_donor;
				
				return view('la.scholarship_donors.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('scholarship_donor', $scholarship_donor);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("scholarship_donor"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified scholarship_donor.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Scholarship_Donors", "edit")) {			
			$scholarship_donor = Scholarship_Donor::find($id);
			if(isset($scholarship_donor->id)) {	
				$module = Module::get('Scholarship_Donors');
				
				$module->row = $scholarship_donor;

				$donors=User::where('user_level',1)
	            ->where('is_donor',1)
	            ->get(['id','email']);
				
				return view('la.scholarship_donors.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'donors' =>$donors
				])->with('scholarship_donor', $scholarship_donor);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("scholarship_donor"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified scholarship_donor in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("Scholarship_Donors", "edit")) {
			
			$rules = Module::validateRules("Scholarship_Donors", $request, true);
			
			$validator = Validator::make($request->all(), $rules);

			$messsages = array(
		        'student_id.unique'=>Lang::get('messages.This Student is already assigned to this Donor')
		    );
			//$table_name,$unique_field,$dependent_field,$dependent_input,$edit_field,$edit_id=null
			$rules = array(
                'student_id' => CommonHelper::twoFieldUniqueValidation('scholarship_donors','student_id','user_id','user_id','id',$id),
            );

			$validator = Validator::make($request->all(), $rules,$messsages);

			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Scholarship_Donors", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.scholarship_donors.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified scholarship_donor from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Scholarship_Donors", "delete")) {
			Scholarship_Donor::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.scholarship_donors.index');
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
		$values = DB::table('scholarship_donors')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Scholarship_Donors');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/scholarship_donors/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Scholarship_Donors", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/scholarship_donors/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Scholarship_Donors", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.scholarship_donors.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
