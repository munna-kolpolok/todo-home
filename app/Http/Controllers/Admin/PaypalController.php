<?php

namespace App\Http\Controllers\Admin;

use App\Models\Paypal_Payment;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    public function index()
    {

        if (Menu::hasAccess('paypal_payments')) {
            $payment_lists = Paypal_Payment::orderBy('id', 'desc')->get();
            return View('admin.payment.paypal',['payment_lists'=>$payment_lists]);
        } else {
            return View('error');
        }

    }
    public function show($id)
    {
        if (Menu::hasAccess('paypal_payments')) {
            $paypal = Paypal_Payment::find($id);
            return View('admin.payment.paypal_show',['paypal'=>$paypal]);
        } else {
            return View('error');
        }

    } 
}
