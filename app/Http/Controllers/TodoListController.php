<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Lang;
use Session;
use Validator;

use App\Models\Work;

class TodoListController extends Controller
{
	
	public function __construct() {
	}
	
	/**
	 * Display a listing of the Accounts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$works=Work::orderby('serial_no','asc')->get();
		return View('welcome',compact('works'));
	}

	public function store(Request $request)
	{
		$works = Work::orderBy('id', 'desc')->get();
        $serial_no = $works->max('serial_no') + 1;

		$data=$request->all();
		$data['serial_no'] = $serial_no;
		Work::create($data);

		return redirect()->back();
	}
	public function status($status,$id)
	{
		$work=Work::find($id);
		$work->status=$status;
		$work->save();
		return redirect()->back();
	}
	// public function todoOrder(Request $request)
	// {
	// 	print_r($request->all());die();
	// }
	public function todoOrder(Request $request)
    {
    	//print_r($request->all());die();
    	if(isset($request->work_id))
    	{
    		$work=Work::find($request->work_id);
    		$work->status=$request->status;
    		$work->save();
    	}
        $works = Work::orderBy('serial_no', 'asc')->get();
        foreach ($works as $work) {
            $work->timestamps = false;
            $id = $work->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $work->update(['serial_no' => $order['position']]);
                }
            }
        }
        return response()->json('Update Successfully.', 200);
    }


}
