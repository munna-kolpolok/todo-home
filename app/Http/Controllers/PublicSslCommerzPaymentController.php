<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Lang;
use Auth;
use Mail;
use PDF;
use Validator;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers;
session_start();

use App\Helpers\CommonHelper;
use App\Models\Ssl_Payment;
use App\Models\Order;
use App\Models\Student;
use App\Models\Scholarship;
use App\Models\Scholarship_Donation;
use App\Models\Currency;
use App\Models\User;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Scholarship_Donor;

class PublicSslCommerzPaymentController extends Controller
{

    public function index(Request $request) 
    {
            //echo asset('uploads/payment_receipt/Receipt_1.pdf');
            //echo 'munna';die();
            # Here you have to receive all the order data to initate the payment.
            if($request->custom_amount)
            {
                $amount=trim($request->custom_amount);
            }
            else
            {
                $amount=trim($request->amount);
            }

            //..........Validation add start..........
            $rules = array(
                'cus_name'=> 'required|min:3|max:255',
                'cus_email'=> 'required|email|max:255',
                'cus_phone'=> 'required|numeric|min:10',

            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
                Session::flash('error',Lang::get('messages.Transaction is Falied'));
                return Redirect::to('payment_success');
            }
            //..........Validation add end..........

            
            if($amount<=0)
            {
                Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
                Session::flash('error',Lang::get('messages.Transaction is Falied'));
                return Redirect::to('payment_success'); 
            }
            
            $user_id=0;
            if(!empty($request->user_id))
            {
                $user_no=User::where('id',$request->user_id)->count();
                if($user_no>0)
                {
                    $user_id=$request->user_id;
                }
            }

            //......Order start......
            $order=new Order;
            if($user_id>0)
            {
                $order->user_id=$user_id;
                $order->created_by=$user_id;
            }
            $order->comments=trim($request->comments);
            $order->amount=$amount;
            $order->created_ip_address=CommonHelper::getRealIpAddr();
            $order->save();
            $order_id=$order->id;
            //......Order end......
            
            $ssl_payment=new Ssl_Payment;
            $ssl_payment->donate_way=$request->donate_way;
            $ssl_payment->order_id=$order_id;
            if($user_id>0)
            {
                $ssl_payment->user_id=$user_id;
            }
            
            if($request->donate_way==2)
            {
                $ssl_payment->project_id=$request->project_id;
            }
            else if($request->donate_way==3)
            {
                $ssl_payment->student_id=$request->student_id;
            }
            $ssl_payment->total_amount=$amount;
            $ssl_payment->currency= "BDT";
            $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
            $ssl_payment->cus_name=$request->cus_name;
            $ssl_payment->cus_email=$request->cus_email;
            $ssl_payment->cus_phone=$request->cus_phone;
            
            $ssl_payment->save();

            $ssl_payment_id=$ssl_payment->id;

            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "order_id","tran_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

            $post_data = array();
            $post_data['total_amount'] = $amount; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = $ssl_payment_id; // tran_id must be unique

            #Start to save these value  in session to pick in success page.
            $_SESSION['payment_values']['tran_id']=$ssl_payment_id;
            #End to save these value  in session to pick in success page.


            $server_name=$request->root()."/";
            $post_data['success_url'] = $server_name . "success";
            $post_data['fail_url'] = $server_name . "fail";
            $post_data['cancel_url'] = $server_name . "cancel";

            //echo $post_data['success_url'];die();

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $request->cus_name;
            $post_data['cus_email'] = $request->cus_email;
            $post_data['cus_add1'] = '';
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "";
            $post_data['cus_phone'] = $request->cus_phone;
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = '';
            $post_data['ship_add1 '] = '';
            $post_data['ship_add2'] = "";
            $post_data['ship_city'] = "";
            $post_data['ship_state'] = "";
            $post_data['ship_postcode'] = "";
            $post_data['ship_country'] = "";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";


            
            #Before  going to initiate the payment order status need to update as Pending.
            // $update_product = DB::table('ssl_payments')
            //                         ->where('id', $post_data['tran_id'])
            //                         ->update(['tran_status' => 'Pending','currency' => $post_data['currency']]);

            $ssl_payment=Ssl_Payment::find($post_data['tran_id']);
            $ssl_payment->tran_status='Pending';
            $ssl_payment->save();

            $sslc = new SSLCommerz();
            //print_r($sslc);die();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->initiate($post_data, false);

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }

    }

    public function success(Request $request) 
    {
        echo "Transaction is Successful";

        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $_SESSION['payment_values']['tran_id'];
        #End to received these value from session. which was saved in index function.

        #Check order status in order tabel against the transaction id or order id.
        // $ssl_payment = DB::table('orders')
        //                     ->where('order_id', $tran_id)
        //                     ->select('order_id', 'tran_status','currency','grand_total')->first();
        $ssl_payment=Ssl_Payment::find($tran_id);
        $v_donate_tk=$ssl_payment->total_amount;
        if(empty($ssl_payment->user_id))
        {
            $user_id=0;
        }
        else
        {
            $user_id=$ssl_payment->user_id;
        }

        if($ssl_payment->tran_status=='Pending')
        {

            $validation = $sslc->orderValidate($tran_id, $ssl_payment->total_amount, $ssl_payment->currency, $request->all());
            if($validation == TRUE) 
            {
                
                $currency=Currency::where('currency_code','BDT')->first();
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Success or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */ 
                // $update_product = DB::table('orders')
                //             ->where('order_id', $tran_id)
                //             ->update(['tran_status' => 'Success']);

                $ssl_payment->tran_time=$request->tran_date;
                $ssl_payment->store_id=$request->store_id;
                $ssl_payment->store_amount=$request->store_amount;
                $ssl_payment->val_id=$request->val_id;
                $ssl_payment->verify_sign=$request->verify_sign;
                $ssl_payment->verify_key=$request->verify_key;
                $ssl_payment->bank_tran_id=$request->bank_tran_id;
                $ssl_payment->card_no=$request->card_no;
                $ssl_payment->card_brand=$request->card_brand;
                $ssl_payment->card_type=$request->card_type;
                $ssl_payment->card_issuer=$request->card_issuer;
                $ssl_payment->card_issuer_country=$request->card_issuer_country;
                $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
                $ssl_payment->tran_status='Success';
                $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
                $ssl_payment->save();

                //........scholarship transaction start................
                if($ssl_payment->student_id>0)
                {
                    //.......for scholarship....
                    $p_s_n=$ssl_payment->student_id;
                    $v_cur_date_time=date('Y-m-d H:i:s');
                    

                    //........transaction in scholarship start........
                    if($user_id>0)
                    {
                        $scholarship_donor=Scholarship_Donor::where('student_id',$p_s_n)
                        ->where('user_id',$user_id)->first();
                        if(empty($scholarship_donor))
                        {
                            $scholarship_donor=new Scholarship_Donor;
                            $scholarship_donor->student_id=$p_s_n;
                            $scholarship_donor->user_id=$user_id;
                            $scholarship_donor->save();
                        }

                    }


                    $scholarship=Scholarship::where('student_id',$p_s_n)
                    ->where('year',date('Y'))->first();
                    if(empty($scholarship))
                    {
                        //.......insert scholarship......
                        $start_date=date('Y').'-01-01';
                        $end_date=date('Y').'-12-31';
                        $student=Student::find($p_s_n);

                        $scholarship=new Scholarship;
                        $scholarship->student_id=$p_s_n;
                        $scholarship->year=date('Y');
                        $scholarship->duration=12;
                        $scholarship->start_date=$start_date;
                        $scholarship->end_date=$end_date;
                        $scholarship->scholarship_amount=$student->scholarship_amount;

                        $scholarship->donated_amount=$v_donate_tk;
                        $scholarship->due=$student->scholarship_amount-$v_donate_tk;

                        $scholarship->last_donate_date=$v_cur_date_time;
                        if($user_id>0)
                        {
                            $scholarship->created_by=$user_id;
                        }
                        
                        $scholarship->created_ip_address=CommonHelper::getRealIpAddr();
                        $scholarship->save();

                    }

                    $scholarship_donation=new Scholarship_Donation;
                    $scholarship_donation->scholarship_id=$scholarship->id;
                    
                    $scholarship_donation->amount=$v_donate_tk;
                    $scholarship_donation->currency_id=$currency->currency_id;
                    $scholarship_donation->tk_convert_amount=$currency->tk_convert_amount;
                    $scholarship_donation->tk_amount=$v_donate_tk;

                    $scholarship_donation->donate_date=$v_cur_date_time;
                    $scholarship_donation->type=1;
                    $scholarship_donation->payment_method=3;
                    $scholarship_donation->payment_description='SSLCommerz payment';
                    if($user_id>0)
                    {
                        $scholarship_donation->user_id=$user_id;
                        $scholarship_donation->created_by=$user_id;
                    }
                    $scholarship_donation->ssl_payment_id=$ssl_payment->id;
                    $scholarship_donation->created_ip_address=CommonHelper::getRealIpAddr();
                    $scholarship_donation->save();

                    //........update in scholarship start.........
                    $scholarship=Scholarship::find($scholarship->id);
                    $scholarship->last_donate_date=$v_cur_date_time;
                    $scholarship->save();
                    //........update in scholarship end.........

                    $student=Student::find($p_s_n);
                    $student->is_scholarship=1;
                    $student->save();
                    //........transaction in scholarship end........
                }
                //........scholarship transaction end................

                //...........Update user as donor start........
                if($user_id>0)
                {
                    $user=User::find($user_id);
                    $user->is_donor=1;
                    $user->save();

                    //.............Mail send start..........
                    
                    //........PDF save start........
                    $pdf_file_name=$ssl_payment->user_id.'_'.$ssl_payment->id.'_'.time().'.pdf';
                    $pdf_path=public_path('uploads/payment_receipt/ssl/'.$pdf_file_name);
                    
                    $config=[
                      'mode'=>'bn',
                      'default_font_size' => '12',
                      'default_font' => 'solaimanlipi',
                    ];
                    $data = [
                        'payment' => $ssl_payment,
                        'ssl_id' => $ssl_payment->id,
                        'paypal_id'=>null,
                        'type'=>3
                    ];
                    $mergeData = [];
                    $pdf = PDF::loadView('website.payments.payment_receipt', $data, $mergeData, $config);
                    $pdf->save($pdf_path);
                    //........PDF save end........

                    $attach_file_path=asset('uploads/payment_receipt/ssl/'.$pdf_file_name);

                    Mail::send('emails.payment_receipt', ['user' => $user, 'ssl_payment' => $ssl_payment,'type'=>3], function ($m) use ($user,$attach_file_path) {
                        $setting = Setting::first();

                        $m->to($user->email, $user->name)->from($setting->contact_email,$setting->organization_name)->subject('Payment Receipt from Bidyanondo');

                        $m->attach($attach_file_path, array(
                            'as' => 'Payment Receipt.pdf',
                            'mime' => 'application/pdf')
                        );

                    });
                    //.............Mail send end............
                }
                //...........Update user as donor end........
                Session::flash('ssl_id',$ssl_payment->id);
                Session::flash('donation_msg', Lang::get('messages.Donation Success'));
                Session::flash('message', Lang::get('messages.Payment is successfully complete'));
                return Redirect::to('payment_success');

                // return Redirect::back()->with('message', Lang::get('messages.Payment is successfully complete'));
                //echo "<br >Transaction is successfully Complete";
            }
            else
            {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */ 
                // $update_product = DB::table('orders')
                //             ->where('order_id', $tran_id)
                //             ->update(['tran_status' => 'Failed']);
                $ssl_payment->tran_time=$request->tran_date;
                $ssl_payment->store_id=$request->store_id;
                $ssl_payment->store_amount=$request->store_amount;
                $ssl_payment->val_id=$request->val_id;
                $ssl_payment->verify_sign=$request->verify_sign;
                $ssl_payment->verify_key=$request->verify_key;
                $ssl_payment->bank_tran_id=$request->bank_tran_id;
                $ssl_payment->card_no=$request->card_no;
                $ssl_payment->card_brand=$request->card_brand;
                $ssl_payment->card_type=$request->card_type;
                $ssl_payment->card_issuer=$request->card_issuer;
                $ssl_payment->card_issuer_country=$request->card_issuer_country;
                $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
                $ssl_payment->tran_status='Failed';
                $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
                $ssl_payment->save();
                //echo "validation Fail";
                
                Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
                Session::flash('error', Lang::get('messages.Validation Fail'));
                return Redirect::to('payment_success');
            }    
        }
        else if($ssl_payment->tran_status=='Success' || $ssl_payment->tran_status=='Complete')
        {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
             Session::flash('donation_msg', Lang::get('messages.Donation Success'));
            Session::flash('message', Lang::get('messages.Payment is successfully complete'));
            return Redirect::to('payment_success');
            //echo "Transaction is successfully Complete";
        }
        else
        {
             #That means something wrong happened. You can redirect customer to your product page.
            //echo "Invalid Transaction";
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
            Session::flash('error', Lang::get('messages.Invalid Transaction'));
            return Redirect::to('payment_success');
        }    
         


    }
    public function fail(Request $request) 
    {
         $tran_id = $_SESSION['payment_values']['tran_id'];
         // $ssl_payment = DB::table('orders')
         //                    ->where('order_id', $tran_id)
         //                    ->select('order_id', 'tran_status','currency','grand_total')->first();
        $ssl_payment=Ssl_Payment::find($tran_id);

        if($ssl_payment->tran_status=='Pending')
        {
            // $update_product = DB::table('orders')
            //                 ->where('order_id', $tran_id)
            //                 ->update(['tran_status' => 'Failed']);

            $ssl_payment->tran_time=$request->tran_date;
            $ssl_payment->store_id=$request->store_id;
            $ssl_payment->store_amount=$request->store_amount;
            $ssl_payment->val_id=$request->val_id;
            $ssl_payment->verify_sign=$request->verify_sign;
            $ssl_payment->verify_key=$request->verify_key;
            $ssl_payment->bank_tran_id=$request->bank_tran_id;
            $ssl_payment->card_no=$request->card_no;
            $ssl_payment->card_brand=$request->card_brand;
            $ssl_payment->card_type=$request->card_type;
            $ssl_payment->card_issuer=$request->card_issuer;
            $ssl_payment->card_issuer_country=$request->card_issuer_country;
            $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
            $ssl_payment->tran_status='Failed';
            $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
            $ssl_payment->save();
            //echo "Transaction is Falied";  
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
            Session::flash('error',Lang::get('messages.Transaction is Falied'));
            return Redirect::to('payment_success');              
        }
         else if($ssl_payment->tran_status=='Success' || $ssl_payment->tran_status=='Complete')
        {
            //echo "Transaction is already Successful";
            Session::flash('donation_msg', Lang::get('messages.Donation Success'));
            Session::flash('message', Lang::get('messages.Transaction is already Successful'));
            return Redirect::to('payment_success'); 
        }  
        else
        {
            //echo "Transaction is Invalid";
            Session::flash('donation_msg', Lang::get('messages.Donation Failed')); 
            Session::flash('error', Lang::get('messages.Transaction is Invalid'));
            return Redirect::to('payment_success'); 
        }        
                            
    }

     public function cancel(Request $request) 
    {
        $tran_id = $_SESSION['payment_values']['tran_id'];

        // $ssl_payment = DB::table('orders')
        //                     ->where('order_id', $tran_id)
        //                     ->select('order_id', 'tran_status','currency','grand_total')->first();
        $ssl_payment=Ssl_Payment::find($tran_id);

        if($ssl_payment->tran_status=='Pending')
        {
            // $update_product = DB::table('orders')
            //                 ->where('order_id', $tran_id)
            //                 ->update(['tran_status' => 'Canceled']);

            $ssl_payment->tran_time=$request->tran_date;
            $ssl_payment->store_id=$request->store_id;
            $ssl_payment->store_amount=$request->store_amount;
            $ssl_payment->val_id=$request->val_id;
            $ssl_payment->verify_sign=$request->verify_sign;
            $ssl_payment->verify_key=$request->verify_key;
            $ssl_payment->bank_tran_id=$request->bank_tran_id;
            $ssl_payment->card_no=$request->card_no;
            $ssl_payment->card_brand=$request->card_brand;
            $ssl_payment->card_type=$request->card_type;
            $ssl_payment->card_issuer=$request->card_issuer;
            $ssl_payment->card_issuer_country=$request->card_issuer_country;
            $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
            $ssl_payment->tran_status='Canceled';
            $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
            $ssl_payment->save();
            //echo "Transaction is Cancel";
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));   
            Session::flash('error', Lang::get('messages.Transaction is Cancel'));
            return Redirect::to('payment_success');              
        }
         else if($ssl_payment->tran_status=='Success' || $ssl_payment->tran_status=='Complete')
        {
            //echo "Transaction is already Successful";
            Session::flash('donation_msg', Lang::get('messages.Donation Success'));
            Session::flash('message', Lang::get('messages.Transaction is already Successful'));
            return Redirect::to('payment_success'); 
        }  
        else
        {
            //echo "Transaction is Invalid"; 
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
            Session::flash('error', Lang::get('messages.Transaction is Invalid'));
            return Redirect::to('payment_success');
        }                 

        
    }
     public function ipn(Request $request) 
    {
        #Received all the payement information from the gateway  
      if($request->input('tran_id')) #Check transation id is posted or not.
      {

          $tran_id = $request->input('tran_id');

        #Check order status in order tabel against the transaction id or order id.
         // $ssl_payment = DB::table('orders')
         //                    ->where('order_id', $tran_id)
         //                    ->select('order_id', 'tran_status','currency','grand_total')->first();
          $ssl_payment=Ssl_Payment::find($tran_id);

                if($ssl_payment->tran_status =='Pending')
                {
                    $sslc = new SSLCommerz();
                    $validation = $sslc->orderValidate($tran_id, $ssl_payment->grand_total, $ssl_payment->currency, $request->all());
                    if($validation == TRUE) 
                    {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Success or Complete.
                        Here you can also sent sms or email for successfull transaction to customer
                        */ 
                        // $update_product = DB::table('orders')
                        //             ->where('order_id', $tran_id)
                        //             ->update(['tran_status' => 'Success']);

                        $ssl_payment->tran_time=$request->tran_date;
                        $ssl_payment->store_id=$request->store_id;
                        $ssl_payment->store_amount=$request->store_amount;
                        $ssl_payment->val_id=$request->val_id;
                        $ssl_payment->verify_sign=$request->verify_sign;
                        $ssl_payment->verify_key=$request->verify_key;
                        $ssl_payment->bank_tran_id=$request->bank_tran_id;
                        $ssl_payment->card_no=$request->card_no;
                        $ssl_payment->card_brand=$request->card_brand;
                        $ssl_payment->card_type=$request->card_type;
                        $ssl_payment->card_issuer=$request->card_issuer;
                        $ssl_payment->card_issuer_country=$request->card_issuer_country;
                        $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
                        $ssl_payment->tran_status='Success';
                        $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
                        $ssl_payment->save();            
                                    
                        //echo "Transaction is successfully Complete";
                        Session::flash('donation_msg', Lang::get('messages.Donation Success'));
                        Session::flash('message', Lang::get('messages.Transaction is successfully Complete'));
                        return Redirect::to('payment_success'); 
                    }
                    else
                    {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */ 
                        // $update_product = DB::table('orders')
                        //             ->where('order_id', $tran_id)
                        //             ->update(['tran_status' => 'Failed']);
                        $ssl_payment->tran_time=$request->tran_date;
                        $ssl_payment->store_id=$request->store_id;
                        $ssl_payment->store_amount=$request->store_amount;
                        $ssl_payment->val_id=$request->val_id;
                        $ssl_payment->verify_sign=$request->verify_sign;
                        $ssl_payment->verify_key=$request->verify_key;
                        $ssl_payment->bank_tran_id=$request->bank_tran_id;
                        $ssl_payment->card_no=$request->card_no;
                        $ssl_payment->card_brand=$request->card_brand;
                        $ssl_payment->card_type=$request->card_type;
                        $ssl_payment->card_issuer=$request->card_issuer;
                        $ssl_payment->card_issuer_country=$request->card_issuer_country;
                        $ssl_payment->card_issuer_country_code=$request->card_issuer_country_code;
                        $ssl_payment->tran_status='Failed';
                        $ssl_payment->created_ip_address=CommonHelper::getRealIpAddr();
                        $ssl_payment->save(); 
                                    
                        //echo "validation Fail";
                        Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
                        Session::flash('error', Lang::get('messages.validation Fail'));
                        return Redirect::to('payment_success');
                    } 
                     
                }
                else if($ssl_payment->tran_status == 'Success' || $ssl_payment->tran_status =='Complete')
                {
                    
                  #That means Order status already updated. No need to udate database.
                     
                    //echo "Transaction is already successfully Complete";
                    Session::flash('donation_msg', Lang::get('messages.Donation Success'));
                    Session::flash('message', Lang::get('messages.Transaction is already successfully Complete'));
                }
                else
                {
                   #That means something wrong happened. You can redirect customer to your product page.
                     
                    //echo "Invalid Transaction";
                    Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
                    Session::flash('error', Lang::get('messages.Invalid Transaction'));
                    return Redirect::to('payment_success');
                }  
        }
        else
        {
            //echo "Inavalid Data";
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
            Session::flash('error', Lang::get('messages.Inavalid Data'));
            return Redirect::to('payment_success');
        }      
    }

}
