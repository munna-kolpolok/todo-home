<?php

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Session;

use URL;
use Cookie;
use Auth;
use DB;
use Lang;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Ssl_Payment;
use App\Models\Paypal_Payment;
use App\Models\Donation;
/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index($no_days=30)
    {
        //$no_days=365;
        $search_date=Carbon::now()->subDays($no_days);
        $id=Auth::id();
        $user=User::find($id);

        // if($user->user_level>1)
        // {
            Session::put('user_level',$user->user_level);

            //............dashboard report start...........
            $donor_count=User::where('user_level',1)
                ->where('is_verified',1)
                ->where('is_donor',1)
                ->count();
            $student_count=Student::count();

            $all_ssl_payment=Ssl_Payment::where('tran_status','Success')
            ->whereDate('created_at','>=', Carbon::now()->subDays($no_days))
            ->sum('total_amount');   
            $all_paypal_payment=Paypal_Payment::where('state','approved')
            ->whereDate('created_at','>=', Carbon::now()->subDays($no_days))
            ->sum('tk_amount');
            $all_offline_payment=Donation::whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('tk_amount');


            


            $sr_tk_w_p_payment=Paypal_Payment::where('state','approved')->where('website_id',3)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('tk_amount');

            //.........payments start......
            $ssl_payments=DB::SELECT("SELECT w.id,w.name,FLOOR(sum(s.total_amount)) as ssl_total_amount
            FROM `websites` w
            left join ssl_payments s on(s.website_id=w.id)
            where s.tran_status='Success'
            and s.created_at>='$search_date'
            and w.deleted_at is null
            and s.deleted_at is null
            group by s.website_id
            order by w.id");

            $paypal_payments=DB::SELECT("SELECT w.id,w.name,FLOOR(sum(p.tk_amount)) as paypal_total_amount
            FROM `websites` w
            left join paypal_payments p on(p.website_id=w.id)
            where p.state='approved'
            and p.created_at>='$search_date'
            and w.deleted_at is null
            and p.deleted_at is null
            group by p.website_id
            order by w.id");

            $offline_payments=DB::SELECT("SELECT w.id,w.name,FLOOR(sum(d.tk_amount)) as offline_total_amount
                FROM `websites` w
                inner join inboxes i on(i.website_id=w.id)
                inner join donations d on(d.inbox_id=i.id)
                where w.deleted_at is null
                and d.created_at>='$search_date'
                and i.deleted_at is null
                and d.deleted_at is null
                group by i.website_id
                order by w.id");
            //.........payments end......

            //......bidyanondo payment start.....
            $bidyanodo_ssl_payment=Ssl_Payment::where('tran_status','Success')->where('website_id',1)
            ->whereDate('created_at','>=', Carbon::now()->subDays($no_days))
            ->sum('total_amount');   
            $bidyanodo_paypal_payment=Paypal_Payment::where('state','approved')->where('website_id',1)
            ->whereDate('created_at','>=', Carbon::now()->subDays($no_days))
            ->sum('tk_amount');
            $bidyanodo_offline_payment=DB::SELECT("SELECT FLOOR(sum(d.tk_amount)) as tk_amount
                FROM inboxes i 
                inner join donations d on(d.inbox_id=i.id)
                where d.created_at>='$search_date'
                and i.website_id='1'
                and i.deleted_at is null
                and d.deleted_at is null
                ")[0];
            $bidyanodo_offline_payment=$bidyanodo_offline_payment->tk_amount;
            //......bidyanondo payment end.....

            //......one taka ahar website payment start.....
            $one_tk_w_p_payment=Paypal_Payment::where('state','approved')->where('website_id',2)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('tk_amount');
            $one_tk_w_s_payment=Ssl_Payment::where('tran_status','Success')->where('website_id',2)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('total_amount'); 
            $one_tk_p_p_payment=Paypal_Payment::where('state','approved')->where('project_id',1)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('tk_amount');
            $one_tk_p_s_payment=Ssl_Payment::where('tran_status','Success')->where('project_id',1)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('total_amount');
            $one_offline_payment=DB::SELECT("SELECT FLOOR(sum(d.tk_amount)) as tk_amount
                FROM inboxes i 
                inner join donations d on(d.inbox_id=i.id)
                where d.created_at>='$search_date'
                and i.website_id='2'
                and i.deleted_at is null
                and d.deleted_at is null
                ")[0];
            $one_tk_w_o_payment=$one_offline_payment->tk_amount;

            $one_offline_payment_p=DB::SELECT("SELECT FLOOR(sum(d.tk_amount)) as tk_amount
                FROM inboxes i 
                inner join donations d on(d.inbox_id=i.id)
                inner join sectors s on(i.sector_id=s.id)
                where d.created_at>='$search_date'
                and s.project_id='1'
                and s.deleted_at is null
                and i.deleted_at is null
                and d.deleted_at is null
                ")[0];
            $one_tk_p_o_payment=$one_offline_payment_p->tk_amount;
            //......one taka ahar website payment end.....

            //......Gift me website payment start.....
            $gift_me_w_p_payment=Paypal_Payment::where('state','approved')->where('website_id',4)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('tk_amount');
            $gift_me_w_s_payment=Ssl_Payment::where('tran_status','Success')->where('website_id',4)->whereDate('created_at','>=', Carbon::now()->subDays($no_days))->sum('total_amount'); 
            //......Gift me website payment end.....
            
            //............dashboard report end...........
            
            return view('la.dashboard',compact('donor_count','student_count','no_days',

                'all_ssl_payment',
                'all_paypal_payment',
                'all_offline_payment',

                'paypal_payments',
                'ssl_payments',
                'offline_payments',

                'bidyanodo_paypal_payment',
                'bidyanodo_ssl_payment',
                'bidyanodo_offline_payment',
                'one_tk_w_p_payment',
                'one_tk_w_s_payment',
                'one_tk_w_o_payment',
                'one_tk_p_p_payment',
                'one_tk_p_s_payment',
                'one_tk_p_o_payment',
                'sr_tk_w_p_payment',
                'gift_me_w_p_payment',
                'gift_me_w_s_payment'
            ));
        // }
        // else
        // {
        //     return redirect("/donors");
        // }
    }

    public function module($id){
        Session::set('parent_menu_id', $id);
        //return view('la.dashboard');
        //$this->index($id);
        return redirect(config('laraadmin.adminRoute')."/dashboard");
    }

    public function language($language)
    {
        Cookie::queue('locale', $language);
        return redirect(url(URL::previous()));
    }
    public function session_info()
    {
        print_r(Session::all());die();
    }

}