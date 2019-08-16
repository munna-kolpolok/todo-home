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

use App\Models\Scholarship;
use App\Models\Scholarship_Donation;
use App\Models\Student;
use App\Models\User;
use App\Models\Currency;
use App\Models\Scholarship_Donor;



class ScholarshipsController extends Controller
{
    public $show_action = true;

    public function __construct()
    {
        $this->menu_id = Menu::get('Scholarships');
    }

    public function index()
    {
        if(Menu::hasAccess($this->menu_id)) {

            $list_values = Scholarship::orderby('id','desc')->get();

            return View('admin.scholarship.index', [
                'show_actions' => $this->show_action,
                'values'=>$list_values,
            ]);
        } else {
            return View('error');
        }
    }
    public function create()
    {
        if(Menu::hasAccess("Scholarships", "create"))
        {
            //$students=Student::get(['id','name','id_card']);
            $students=DB::SELECT("SELECT s.id,s.name,s.id_card
            FROM `scholarship_donors` sd
            inner join students s on(s.id=sd.`student_id`)
            and sd.`deleted_at` is null
            and s.`deleted_at` is null");
            $currencies=Currency::orderBy('serial_no')->get(['id','currency_code','currency_name']);
            $donors=User::where('user_level',1)->get(['id','email']);
            $years=CommonHelper::years_list();
            //print_r($years);die();
            return View('admin.scholarship.add_form',[
                'students'=>$students,
                'donors'=>$donors,
                'years'=>$years,
                'currencies'=>$currencies,
                ]);
        }
        else
        {
            return View('error');
        }
    }
    public function edit($id)
    {
        if(Menu::hasAccess("Scholarships", "edit"))
        {
            $scholarship=Scholarship::find($id);
            $donors=User::where('user_level',1)->get(['id','email']);

            return View('admin.scholarship.edit_form',[
                'scholarship'=>$scholarship,
                'donors'=>$donors
                ]);
        }
        else
        {
            return View('error');
        }
    }
    public function store(Request $request){

        if(Menu::hasAccess("Scholarships", "create"))
        {
            $rules = array(
                'donate_date'=> 'required',
                'currency_id'=> 'required',
                'year' => 'required',
                'student_id'=> 'required',
                'amount' => 'required',
                'payment_method'=> 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $scholarship_exist=Scholarship::where('student_id',$request->student_id)
            ->where('year',$request->year)
            ->count();
            $student=Student::find($request->student_id);
            if($scholarship_exist>0)
            {
                return redirect()->back()->withErrors(Lang::get('Scholarship is already exist for - '.$student->name .' in '.$request->year));
            }
           
            $start_date=$request->year.'-01-01';
            $end_date=$request->year.'-12-31';
            
            $currency=Currency::find($request->currency_id);
            $v_donate_tk=$request->amount*$currency->tk_convert_amount;

            $scholarship=new Scholarship;
            $scholarship->student_id=$request->student_id;
            //$scholarship->donor_id=$request->donor_id;
            //$scholarship->scholarship_date=CommonHelper::databseDateFormat($request->scholarship_date);
            $scholarship->year=$request->year;
            $scholarship->duration=12;
            $scholarship->start_date=$start_date;
            $scholarship->end_date=$end_date;
            $scholarship->scholarship_amount=$student->scholarship_amount;

            $scholarship->donated_amount=$v_donate_tk;
            $scholarship->due=$student->scholarship_amount-$v_donate_tk;

            $scholarship->last_donate_date=CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);
            $scholarship->created_by=Auth::id();
            $scholarship->created_ip_address=CommonHelper::getRealIpAddr();
            $scholarship->save();

            $scholarshipId= $scholarship->id;

            //.........update students start..........
            $student=Student::find($request->student_id);
            $student->is_scholarship=1;
            $student->save();
            //.........update students end..........

            //.........insert students donations start..........
            $scholarship_donation=new Scholarship_Donation;
            $scholarship_donation->scholarship_id=$scholarshipId;
            $scholarship_donation->user_id=$request->user_id;
            $scholarship_donation->amount=$request->amount;
            $scholarship_donation->currency_id=$request->currency_id;

            $scholarship_donation->tk_convert_amount=$currency->tk_convert_amount;
            $scholarship_donation->tk_amount=$v_donate_tk;

            $scholarship_donation->donate_date=CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);

            $scholarship_donation->type=1;
            $scholarship_donation->payment_method=$request->payment_method;
            $scholarship_donation->slip_no=trim($request->slip_no);
            $scholarship_donation->payment_description=trim($request->payment_description);
            
            $scholarship_donation->created_by=Auth::id();
            $scholarship_donation->created_ip_address=CommonHelper::getRealIpAddr();
            $scholarship_donation->save();
            //.........insert students donations end..........

            //...........Update user as donor start........
            $user=User::find($request->user_id);
            $user->is_donor=1;
            $user->save();
            //...........Update user as donor end........

            Session::flash('message',Lang::get('messages.Saved successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.scholarships.index');
        }
        else
        {
            return View('error');
        }
    }
    public function update(Request $request,$id)
    {
        if(Menu::hasAccess("Scholarships", "edit"))
        {
            $rules = array(
                'scholarship_amount'=> 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $scholarship=Scholarship::find($id);
            $due=$request->scholarship_amount-$scholarship->scholarship_amount;

            $scholarship->scholarship_amount=$request->scholarship_amount;
            $scholarship->due=$scholarship->due+($due);
            //$scholarship->scholarship_date=CommonHelper::databseDateFormat($request->scholarship_date);
            $scholarship->updated_by=Auth::id();
            $scholarship->updated_ip_address=CommonHelper::getRealIpAddr();
            $scholarship->save();

            Session::flash('message',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.scholarships.index');
        }
        else
        {
            return View('error');
        }
    }

    public function destroy($id){
        if(Menu::hasAccess("Scholarships", "delete")) {
            //$this->ledger_receive_delete($id);

            $scholarship_donations_all=Scholarship_Donation::where('scholarship_id',$id)->get();
            foreach ($scholarship_donations_all as $key => $value) {
                Scholarship_Donation::find($value->id)->delete();
            }
            $scholarship = Scholarship::find($id);
            //.........update students start..........
            // $student=Student::where('id',$scholarship->id)
            // ->where('scholarship_id',$scholarship->student_id)
            // ->get();
            // if(isset($student->id))
            // {
            //     $student->is_scholarship=2;
            //     $student->scholarship_id=Null;
            //     $student->save();
            // }
            //.........update students end..........

            $scholarship->delete();
            Session::flash('message',Lang::get('messages.Deleted successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.scholarships.index');
        }else{
            return View('error');
        }
    }
    public function show($id){
        $show_receive_info = Receive_Info::show_receive_info($id);
        $show_receive_items = Receive_Item::show_receive_items($id);
        $print_url = url(config('laraadmin.adminRoute') .'/Scholarships/purchase_voucher/'.$id);
        return View('inventory.Scholarships.show',[
            'receive_info'=>$show_receive_info,
            'receive_items'=>$show_receive_items,
            'print_url'=>$print_url
            ]);
    }

    
    public function donations($id)
    {
        //echo $id;die();
        if(Menu::hasAccess("Scholarships", "edit"))
        {
            $scholarship=Scholarship::find($id);
            $scholarship_donations=Scholarship_Donation::where('scholarship_id',$id)->orderby('id','desc')->get();
            //$donors=User::where('user_level',1)->get(['id','email']);
            $donors=DB::SELECT("SELECT u.id,u.email,u.name
            FROM `scholarship_donors` sd
            inner join users u on(u.id=sd.`user_id`)
            WHERE sd.`student_id`='$scholarship->student_id'
            and sd.`deleted_at` is null
            and u.`deleted_at` is null");

            $currencies=Currency::orderBy('serial_no')->get(['id','currency_code','currency_name']);
            return View('admin.scholarship.donation_form',[
                'scholarship'=>$scholarship,
                'values'=>$scholarship_donations,
                'donors'=>$donors,
                'currencies'=>$currencies,
                ]);
        }else{
            return View('error');
        }
    }

    public function donation_delete(Request $request)
    {

        //echo $request->scholarship_donation_id;die();
        $scholarship_donation=Scholarship_Donation::find($request->scholarship_donation_id);

        $donation=$scholarship_donation->tk_amount;

        $scholarship=Scholarship::find($scholarship_donation->scholarship_id);
        
        $scholarship->donated_amount-=$donation;
        $scholarship->due+=$donation;
        $scholarship->save();

        $scholarship_donation->delete();
        return redirect()->back();
    }

    public function donation_save(Request $request)
    {
        if(Menu::hasAccess("Scholarships", "edit"))
        {
            $rules = array(
                'donate_date'=> 'required',
                'amount' => 'required',
                'currency_id' => 'required',
                'payment_method'=> 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $currency=Currency::find($request->currency_id);
            $v_donate_tk=$request->amount*$currency->tk_convert_amount;

            $scholarship_donation=new Scholarship_Donation;
            $scholarship_donation->scholarship_id=$request->scholarship_id;
            $scholarship_donation->user_id=$request->user_id;
            $scholarship_donation->amount=$request->amount;
            $scholarship_donation->currency_id=$request->currency_id;
            $scholarship_donation->donate_date=CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);

            $scholarship_donation->tk_convert_amount=$currency->tk_convert_amount;
            $scholarship_donation->tk_amount=$v_donate_tk;

            //$scholarship_donation->type=$request->type;
            $scholarship_donation->payment_method=$request->payment_method;
            $scholarship_donation->slip_no=trim($request->slip_no);
            $scholarship_donation->payment_description=trim($request->payment_description);
            
            $scholarship_donation->created_by=Auth::id();
            $scholarship_donation->created_ip_address=CommonHelper::getRealIpAddr();
            $scholarship_donation->save();

            //........update in scholarship start.........
            $scholarship=Scholarship::find($request->scholarship_id);
            //donate
            $scholarship->donated_amount=$scholarship->donated_amount+$v_donate_tk;
            $scholarship->due=$scholarship->due-$v_donate_tk;
            /*
            if($request->type==1)
            {
                //donate
                $scholarship->donated_amount=$scholarship->donated_amount+$v_donate_tk;
                $scholarship->due=$scholarship->due-$v_donate_tk;
            }
            else
            {
                //return
                $scholarship->donated_amount=$scholarship->donated_amount-$v_donate_tk;
                $scholarship->due=$scholarship->due+$v_donate_tk;
            }
            */
            $scholarship->last_donate_date=CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);
            $scholarship->save();
            //........update in scholarship end.........

            //...........Update user as donor start........
            $user=User::find($request->user_id);
            $user->is_donor=1;
            $user->save();
            //...........Update user as donor end........

            Session::flash('message',Lang::get('messages.Donated successfully'));

            //$this->donations($request->scholarship_id);
            return redirect(config('laraadmin.adminRoute') .'/scholarships/donations/'.$request->scholarship_id);
            //return redirect()->route(config('laraadmin.adminRoute') . '.scholarships.index');


        }else{
            return View('error');
        }
    }

    public function studentWiseDonorLoad(Request $request)
    {
        $student_id=$request->student_id;

        $donors=DB::SELECT("SELECT u.id,u.email,u.name
            FROM `scholarship_donors` sd
            inner join users u on(u.id=sd.`user_id`)
            WHERE sd.`student_id`='$student_id'
            and sd.`deleted_at` is null
            and u.`deleted_at` is null");
        if(!empty($donors))
        {
            $donors=$donors[0];
        }
        return Response::json($donors);
    }


}
