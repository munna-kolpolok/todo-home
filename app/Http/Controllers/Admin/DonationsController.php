<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dwij\Laraadmin\Models\Menu;
use DB;
use Validator;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Input;
use Response;
use Lang;
use Session;
use PDF;
use Auth;
use Carbon\Carbon;
use App\Helpers\CommonHelper;

use App\Models\Donation;

class DonationsController extends Controller
{
    public $show_action = true;

    public function __construct()
    {
        $this->menu_id = Menu::get('Donations');
    }

    public function index()
    {
        if(Menu::hasAccess($this->menu_id)) {

            $list_values = Donation::orderby('id','desc')->get();

            return View('admin.donations.index', [
                'show_actions' => $this->show_action,
                'values'=>$list_values,
            ]);
        } else {
            return View('error');
        }
    }
    public function create()
    {
        if(Menu::hasAccess("Donations", "create"))
        {
            $students=Student::get(['id','name']);
            $donors=User::where('user_level',1)->get(['id','email']);
            $years=CommonHelper::years_list();
            //print_r($years);die();
            return View('admin.scholarship.add_form',[
                'students'=>$students,
                'donors'=>$donors,
                'years'=>$years,
                ]);
        }
        else
        {
            return View('error');
        }
    }
    public function edit($id)
    {
        if(Menu::hasAccess("Donations", "edit"))
        {
            $Donation=Donation::find($id);
            $sectors=Sector::get(['id','name','bn_name']);
            $payment_methods=Payment_Method::get(['id','name','bn_name']);

            return View('admin.Donation.edit_form',[
                'Donation'=>$Donation,
                'payment_methods'=>$payment_methods,
                'sectors'=>$sectors
                ]);
        }
        else
        {
            return View('error');
        }
    }
    public function store(Request $request){

        if(Menu::hasAccess("Donations", "create"))
        {
            $rules = array(
                'donate_date'=> 'required',
                'year' => 'required',
                'student_id'=> 'required',
                'amount' => 'required',
                'payment_method'=> 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            

            Session::flash('message',Lang::get('messages.Saved successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.Donations.index');
        }
        else
        {
            return View('error');
        }
    }
    public function update(Request $request,$id)
    {
        if(Menu::hasAccess("Donations", "edit"))
        {
            $rules = array(
                'amount'=> 'required',
                'money_get'=> 'required',
                'need_clarification'=> 'required',
                'payment_method_id'=> 'required',
                'sector_id'=> 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $Donation=Donation::find($id);
            
            
            $Donation->updated_by=Auth::id();
            $Donation->updated_ip_address=CommonHelper::getRealIpAddr();
            $Donation->save();

            Session::flash('message',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.donations.index');
        }
        else
        {
            return View('error');
        }
    }

    public function destroy($id){
        if(Menu::hasAccess("Donations", "delete")) {
            Donation::find($id)->delete();

            Session::flash('message',Lang::get('messages.Deleted successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.Donations.index');
        }else{
            return View('error');
        }
    }
    public function show($id){
        
    }

}
