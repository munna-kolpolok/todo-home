<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Collective\Html\FormFacade as Form;
use Session;

use URL;
use Cookie;
use Auth;
use DB;
use Lang;
use App\Helpers\CommonHelper;
use App\Models\Site_Setting;
use App\Models\Product;
use App\Models\Order;
use App\Models\Order_Detail;


/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //echo 'orders here';die();
        // $product_ids=$request->product_id;
        // $quantity=$request->quantity;

        //.............Pagination added end........
        // return View('website.product.index', [
        //     'products' => $products,
        //     'site_setting' => $site_setting,
        // ]);
    }

    public function store(Request $request)
    {
       $product_ids=$request->product_id_order;

       if(count($product_ids)>0)
       {
           $quantity_orders=$request->quantity_order;
           $per_product_price=$request->per_product_price;
           $size_orders=$request->size_orders;
           $color_orders=$request->color_orders;

           $order=new Order;
           $order->order_no=$request->shipping_name.'-'.$request->shipping_mobile_no.'-'.date('Y-m-d H:i:s');
           $order->order_date=date('Y-m-d H:i:s');
           $order->customer_id=1;
           $order->delivery_charge=$request->delivery_charge;
           $order->total_price=$request->grand_total_price;
           $order->payable_amount=$request->payable_amount;
           $order->due=$request->payable_amount;

           
           $order->shipping_name=$request->shipping_name;
           $order->shipping_mobile_no=$request->shipping_mobile_no;
           $order->shipping_division=$request->shipping_division;
           $order->shipping_upazila=$request->shipping_upazila;
           $order->shipping_location=$request->shipping_location;

           $order->created_ip_address=CommonHelper::getRealIpAddr();

           $order->save();

            $orderId= $order->id;
            $i=0;
            foreach ($product_ids as $value)
            {
                $order_detail=new Order_Detail;
                $order_detail->order_id=$orderId;
                $order_detail->product_id=$value;
                $order_detail->quantity=$quantity_orders[$i];
                $order_detail->price=$per_product_price[$i];

                $order_detail->size_id=$size_orders[$i];
                $order_detail->color_id=$color_orders[$i];

                $order_detail->save();

                $i++;

            }

            return redirect('order/'.$orderId);
       }
       else
       {
            return redirect('/');
       }
    }
    public function show($id)
    {
        $site_setting=Site_Setting::all()->first();
        $order=Order::find($id);
        return View('website.product.confirm_order', [
            'orderId' => $id,
            'site_setting' => $site_setting,
            'order' => $order
        ]);
    }

    public function order_confirmation(Request $request)
    {
        $order_id=$request->order_id;
        $order=Order::find($order_id);
        $order->payment_type=$request->payment_type;
        $order->status=2;
        $order->save();

        Session::put('product_ids', []);
        Session::put('quantity', []);
        Session::put('color_id', []);
        Session::put('size_id', []); 

        Session::flash('success', Lang::get('messages.Your order is placed succesfully')); 
        return redirect('order/success/'.$order_id);

        
    }
    
    public function order_success($id)
    {
        $site_setting=Site_Setting::all()->first();
        return View('website.product.order_success', [
            'site_setting' => $site_setting,
        ]);
    }

}