<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Lang;
use Response;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\Menu;
use Dwij\Laraadmin\Models\ModuleFields;
use App\Helpers\CommonHelper;


use App\Models\Order;
use App\Models\Order_Detail;

class OrdersController extends Controller
{
	public $show_action = true;
	public $view_col = 'category_name';
	public $listing_cols = ['id', 'group_id', 'category_name'];
	
	public function __construct() {

	}
	
	/**
	 * Display a listing of the Payments.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if(Menu::hasAccess('Orders')) {
			$list_values = Order::where('status','>','1')
			->orderBy('id','desc')->get();
			return View('shop.orders.index', [
				'values' => $list_values,
			]);
		} else {
			return View('error');
        }
	}

	/**
	 * Show the form for creating a new category.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created category in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Menu::hasAccess("Payments", "create")) {
			$user_id=Auth::id();

			$rules = array(
                //'receive_voucher_no'=> 'required|unique:receive_infos,receive_voucher_no,NULL,id,deleted_at,NULL',
                'order_id'=> 'required',
                'amount'=> 'required',
                'payment_date'=> 'required'

            );
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			//..............order part start.................
			$order=Order::find($request->order_id);
			if($request->amount!=$order->due)
			{
				return redirect()->back()->withErrors('Due is TK '.$order->due);
			}
			$last_due=$order->due-$request->amount;
			$order->paid_amount=$request->amount;
			$order->due=$last_due;
			if($last_due==0)
			{
				$order->status=4;
			}
			$order->updated_by=$user_id;
			$order->updated_ip_address=CommonHelper::getRealIpAddr();
			$order->save();
			//..............order part end.................
			
			//..............Payment part start.................
			$payment=new Payment;
			$payment->order_id=$request->order_id;
			$payment->payment_date=CommonHelper::databseDateTimeFormatWithCurrentTime($request->payment_date);
			$payment->amount=$request->amount;
			$payment->created_by=$user_id;
			$payment->created_ip_address=CommonHelper::getRealIpAddr();
			$payment->save();
			//..............Payment part end.................

			//$insert_id = Module::insert("Payments", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.payments.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Display the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Menu::hasAccess("Orders", "view")) {
			
			$order = Order::find($id);
			if(isset($order->id)) {
				
				$order_details=Order_Detail::where('order_id',$order->id)->get();;
				
				return view('shop.orders.show', [
					'order_details' => $order_details
				])->with('order', $order);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("category"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Show the form for editing the specified category.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Menu::hasAccess("Payments", "edit")) {			
			$payment = Payment::find($id);
			if(isset($payment->id)) {	
				//$module = Module::get('Payments');
				
				//$module->row = $category;
				
				return view('shop.payments.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('payment', $payment);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("category"),
				]);
			}
		} else {
			return View('error');
		}
	}

	/**
	 * Update the specified category in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Menu::hasAccess("Payments", "edit")) {
			
			$rules = Module::validateRules("Payments", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Payments", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.Payments.index');
			
		} else {
			return View('error');
		}
	}

	/**
	 * Remove the specified category from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Menu::hasAccess("Orders", "delete")) {
			$order_details=Order_Detail::where('order_id',$id)->get();
            foreach ($order_details as $key => $value) {
                Order_Detail::find($value->id)->delete();
            }
            $order = Order::find($id);
            $order->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.orders.index');
		} else {
			return View('error');
		}
	}

	public function order_load(Request $request)
	{
		$result = DB::table('orders')
                    ->where('id',$request->order_id)
                    ->whereNull('deleted_at')
                    ->first();
        return Response::json($result);
	}
	public function change_status($id,$status)
	{
		$order = Order::find($id);
		$order->status=$status;
		$order->save();
		return redirect()->route(config('laraadmin.adminRoute') . '.orders.index');

	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	
}
