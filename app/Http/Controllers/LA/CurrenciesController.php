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

use App\Models\Currency;

class CurrenciesController extends Controller
{
	public $show_action = true;
	public $view_col = 'currency_name';
	public $listing_cols = ['id', 'currency_name', 'currency_code', 'tk_convert_amount', 'min_donate_amount', 'max_donate_amount', 'paypal'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Currencies', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Currencies', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Currencies.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Currencies');
		
		if(Menu::hasAccess('Currencies')) {
			return View('la.currencies.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new currency.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created currency in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Currencies", "create")) {
            $currencies = Currency::orderBy('id', 'desc')->get();
            $serial_no = $currencies->max('serial_no') + 1;

			$rules = Module::validateRules("Currencies", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}


			$request->request->add(['serial_no' => $serial_no]);
			//$insert_id = Module::insert("Payment_Methods", $request);
            Currency::create($request->all());
			//$insert_id = Module::insert("Currencies", $request);

			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.currencies.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified currency.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Currencies", "view")) {
			
			$currency = Currency::find($id);
			if(isset($currency->id)) {
				$module = Module::get('Currencies');
				$module->row = $currency;
				
				return view('la.currencies.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('currency', $currency);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("currency"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified currency.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Currencies", "edit")) {			
			$currency = Currency::find($id);
			if(isset($currency->id)) {	
				$module = Module::get('Currencies');
				
				$module->row = $currency;
				
				return view('la.currencies.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('currency', $currency);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("currency"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified currency in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Currency $currencies)
	{
		if(Menu::hasAccess("Currencies", "edit")) {
			
			$rules = Module::validateRules("Currencies", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$currencies->update($request->all());
			//$insert_id = Module::updateRow("Currencies", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.currencies.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified currency from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Currencies", "delete")) {
			Currency::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.currencies.index');
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
		$values = DB::table('currencies')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Currencies');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/currencies/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Currencies", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/currencies/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Currencies", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.currencies.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

    public function currenciesOrder()
    {
        if (Menu::hasAccess('Currencies')) {
            $currencies = Currency::orderBy('serial_no','asc')->get();
            return View('la.currencies.order',['currencies'=>$currencies]);
        } else {
            return View('error');
        }
    }

    public function currenciesOrderUpdate(Request $request)
    {
        $currencies = Currency::orderBy('id','desc')->get();
        foreach ($currencies as $project) {
            $project->timestamps = false;
            $id = $project->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $project->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
