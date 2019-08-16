<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ssl_Payment;
use Dwij\Laraadmin\Models\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SslController extends Controller
{
    public function index()
    {
        if (Menu::hasAccess('ssl_payments')) {
            $payment_lists = Ssl_Payment::where('tran_status','Success')
            ->orderBy('id', 'desc')->get();
            return View('admin.payment.ssl',['payment_lists'=>$payment_lists]);
        } else {
            return View('error');
        }
    }

    public function show($id)
    {
        if (Menu::hasAccess('ssl_payments')) {
            $paypal = Ssl_Payment::find($id);
            return View('admin.payment.ssl_show',['paypal'=>$paypal]);
        } else {
            return View('error');
        }

    } 
}
