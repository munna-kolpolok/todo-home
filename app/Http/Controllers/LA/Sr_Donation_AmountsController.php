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

use App\Models\Sr_Donation_Amount;

class Sr_Donation_AmountsController extends Controller
{
	public $show_action = true;
	public $view_col = 'amount';
	public $listing_cols = ['id', 'amount'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Sr_Donation_Amounts', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Sr_Donation_Amounts', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Sr_Donation_Amounts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Sr_Donation_Amounts');
		
		if(Menu::hasAccess('Sr_Donation_Amounts')) {
			return View('la.sr_donation_amounts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new sr_donation_amount.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created sr_donation_amount in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Sr_Donation_Amounts", "create")) {
		
			$rules = Module::validateRules("Sr_Donation_Amounts", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Sr_Donation_Amounts", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sr_donation_amounts.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified sr_donation_amount.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Sr_Donation_Amounts", "view")) {
			
			$sr_donation_amount = Sr_Donation_Amount::find($id);
			if(isset($sr_donation_amount->id)) {
				$module = Module::get('Sr_Donation_Amounts');
				$module->row = $sr_donation_amount;
				
				return view('la.sr_donation_amounts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('sr_donation_amount', $sr_donation_amount);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sr_donation_amount"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified sr_donation_amount.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Sr_Donation_Amounts", "edit")) {			
			$sr_donation_amount = Sr_Donation_Amount::find($id);
			if(isset($sr_donation_amount->id)) {	
				$module = Module::get('Sr_Donation_Amounts');
				
				$module->row = $sr_donation_amount;
				
				return view('la.sr_donation_amounts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('sr_donation_amount', $sr_donation_amount);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("sr_donation_amount"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified sr_donation_amount in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("Sr_Donation_Amounts", "edit")) {
			
			$rules = Module::validateRules("Sr_Donation_Amounts", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Sr_Donation_Amounts", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sr_donation_amounts.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified sr_donation_amount from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Sr_Donation_Amounts", "delete")) {
			Sr_Donation_Amount::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.sr_donation_amounts.index');
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
		$values = DB::table('sr_donation_amounts')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Sr_Donation_Amounts');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/sr_donation_amounts/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Sr_Donation_Amounts", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/sr_donation_amounts/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Sr_Donation_Amounts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.sr_donation_amounts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
