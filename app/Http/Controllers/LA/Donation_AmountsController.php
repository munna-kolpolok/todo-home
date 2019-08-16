<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationAmountRequest;
use App\Models\Project;
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

use App\Models\Donation_Amount;

class Donation_AmountsController extends Controller
{
	public $show_action = true;
	public $view_col = 'amount';
	public $projects;
	public $listing_cols = ['id', 'amount', 'description', 'bn_description', 'currency', 'project_id',  'general_donation'];
	
	public function __construct() {
	    $this->projects=Project::get();

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Donation_Amounts', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Donation_Amounts', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Donation_Amounts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Donation_Amounts');
		//dd($this->projets);
		
		if(Menu::hasAccess('Donation_Amounts')) {
			return View('la.donation_amounts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'projects' => $this->projects,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new donation_amount.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created donation_amount in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	    //dd($request->all());
		if(Menu::hasAccess("Donation_Amounts", "create")) {
		   // dd($request->all());
		
			$rules = Module::validateRules("Donation_Amounts", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Donation_Amounts", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.donation_amounts.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified donation_amount.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Donation_Amounts", "view")) {
			
			$donation_amount = Donation_Amount::find($id);
			if(isset($donation_amount->id)) {
				$module = Module::get('Donation_Amounts');
				$module->row = $donation_amount;
				
				return view('la.donation_amounts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('donation_amount', $donation_amount);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("donation_amount"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified donation_amount.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Donation_Amounts", "edit")) {			
			$donation_amount = Donation_Amount::find($id);
			if(isset($donation_amount->id)) {	
				$module = Module::get('Donation_Amounts');
				
				$module->row = $donation_amount;
				
				return view('la.donation_amounts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'projects' => $this->projects,
				])->with('donation_amount', $donation_amount);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("donation_amount"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified donation_amount in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(DonationAmountRequest $request,Donation_Amount $donation_amounts)
	{
	    //dd($request->all());
		if(Menu::hasAccess("Donation_Amounts", "edit")) {

			/*$rules = Module::validateRules("Donation_Amounts", $request, true);
			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$insert_id = Module::updateRow("Donation_Amounts", $request, $id);*/

            $donation_amounts->update($request->all());

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.donation_amounts.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified donation_amount from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Donation_Amounts", "delete")) {
			Donation_Amount::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.donation_amounts.index');
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
		$values = DB::table('donation_amounts')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->where('currency','BDT')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Donation_Amounts');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/donation_amounts/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Donation_Amounts", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/donation_amounts/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Donation_Amounts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.donation_amounts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
