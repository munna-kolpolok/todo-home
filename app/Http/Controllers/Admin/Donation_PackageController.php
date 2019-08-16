<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonHelper;
use App\Models\Food_Project;
use App\Models\Food_Item;
use App\Models\Donation_Package;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
Use Illuminate\Support\Facades\Session;

use App\Models\User;


class Donation_PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Menu::hasAccess("Donation_Packages")) {
            $donation_packs = Donation_Package::orderby('donate_date','desc')->get();
            return View('admin.donation_packages.index', [
                'values'=>$donation_packs,
            ]);
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Menu::hasAccess("Donation_Packages", "create"))
        {
            die();
            return View('admin.donation_packages.create',compact(''));
        }
        else
        {
            return View('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\Donation_PackagesRequest $request)
    {
        die();

        Session::flash('message',Lang::get('messages.Saved successfully'));
        return redirect()->route(config('laraadmin.adminRoute') . '.donation_packages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Menu::hasAccess("Donation_Packages", "view")) {
            $user=User::find($id);

            $payment_lists=DB::SELECT("
                Select * from
                (
                SELECT pp.`payment_date`,pp.amount,pp.`tk_amount`,o.donate_plan,o.no_unit,'Paypal' as payment,'Dollar (USD)' as currency_name
                FROM `paypal_payments` pp
                inner join orders o on(o.id=pp.`order_id`) 
                WHERE pp.`user_id`=$id
                and pp.state='approved'
                and o.donate_plan>0
                and pp.`deleted_at` is null
                and o.`deleted_at` is null

                union 

                SELECT sp.tran_time as `payment_date`,sp.total_amount as amount,sp.total_amount as `tk_amount`,o.donate_plan,o.no_unit,'SSL' as payment,'Taka (BDT)' as currency_name
                    FROM `ssl_payments` sp
                    inner join orders o on(o.id=sp.`order_id`) 
                    WHERE sp.`user_id`=$id
                    and sp.tran_status='Success'
                    and o.donate_plan>0
                    and sp.`deleted_at` is null
                    and o.`deleted_at` is null
                ) a
                order by a.payment_date desc

                ");
            return View('admin.donation_packages.show', compact('payment_lists','user'));
        } else {
            return View('error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Menu::hasAccess('Donation_Packages','edit')) {
            die();
            return view('admin.donation_packages.edit', compact('donation_packages'));
        } else {
            return View('error');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests $request,$id)
    {
        //dd($request->all()); die;


        if (Menu::hasAccess('Donation_Packages','edit')) {
            die("donation_update");
            Session::flash('seccess_msg',Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.donation_packages.index');

        } else {
            return View('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Menu::hasAccess("Donation_Packages", "delete")) {
            die();
            Session::flash('seccess_msg',Lang::get('messages.Deleted successfully'));
            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.donation_packages.index');
        } else {
            return View('error');
        }
    }
}
