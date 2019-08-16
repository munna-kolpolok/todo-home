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

use App\Models\Payment_Method;

class Payment_MethodsController extends Controller
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'bn_name'];
	
	public function __construct() {

		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Payment_Methods', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Payment_Methods', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Payment_Methods.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Payment_Methods');
		
		if(Menu::hasAccess('Payment_Methods')) {
			return View('la.payment_methods.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new payment_method.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created payment_method in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Payment_Methods", "create")) {
            $payments = Payment_Method::orderBy('id', 'desc')->get();
            $serial_no = $payments->max('serial_no') + 1;
			$rules = Module::validateRules("Payment_Methods", $request);
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

            $request->request->add(['serial_no' => $serial_no]);
			//$insert_id = Module::insert("Payment_Methods", $request);
            Payment_Method::create($request->all());
			Session::flash('message',Lang::get('messages.Saved successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.payment_methods.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified payment_method.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Payment_Methods", "view")) {
			
			$payment_method = Payment_Method::find($id);
			if(isset($payment_method->id)) {
				$module = Module::get('Payment_Methods');
				$module->row = $payment_method;
				
				return view('la.payment_methods.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('payment_method', $payment_method);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("payment_method"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified payment_method.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Payment_Methods", "edit")) {			
			$payment_method = Payment_Method::find($id);
			if(isset($payment_method->id)) {	
				$module = Module::get('Payment_Methods');
				
				$module->row = $payment_method;
				
				return view('la.payment_methods.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('payment_method', $payment_method);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("payment_method"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified payment_method in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("Payment_Methods", "edit")) {
			
			$rules = Module::validateRules("Payment_Methods", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Payment_Methods", $request, $id);

			Session::flash('message',Lang::get('messages.Updated successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.payment_methods.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified payment_method from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Payment_Methods", "delete")) {
			Payment_Method::find($id)->delete();
			
			// Redirecting to index() method
			Session::flash('message',Lang::get('messages.Deleted successfully'));
			
			return redirect()->route(config('laraadmin.adminRoute') . '.payment_methods.index');
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
		$values = DB::table('payment_methods')
			->select($this->listing_cols)
			->whereNull('deleted_at')
			->orderBy('id','desc');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Payment_Methods');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/payment_methods/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Menu::hasAccess("Payment_Methods", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/payment_methods/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Menu::hasAccess("Payment_Methods", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.payment_methods.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this entry?\')"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}

    public function paymentsOrder()
    {
        if (Menu::hasAccess('Currencies')) {
            $payments = Payment_Method::orderBy('serial_no','asc')->get();
            return View('la.payment_methods.order',['payments'=>$payments]);
        } else {
            return View('error');
        }
    }

    public function paymentsOrderUpdate(Request $request)
    {
        $payments = Payment_Method::orderBy('serial_no','asc')->get();
        foreach ($payments as $payment) {
            $payment->timestamps = false;
            $id = $payment->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $payment->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }
}
