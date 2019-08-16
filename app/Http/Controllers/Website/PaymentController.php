<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Auth;
use Lang;
use Mail;
use PDF;
use App\Helpers\CommonHelper;
use App\Models\Order;
use App\Models\Paypal_Payment;

use App\Models\Student;
use App\Models\Scholarship;
use App\Models\Scholarship_Donation;
use App\Models\Scholarship_Donor;
use App\Models\Currency;
use App\Models\User;
use App\Models\Contact;
use App\Models\Setting;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

    }
    public function index()
    {
        return view('paywithpaypal');
    }
    public function payWithpaypal(Request $request)
    {
        //echo $request->get('amount_in');die();
        if($request->custom_amount>0)
        {
            $total_amount=trim($request->custom_amount);
        }
        else
        {
            $total_amount=trim($request->amount);
        }
        //echo $total_amount;die();
        if($total_amount<=0)
        {
            Session::flash('donation_msg', Lang::get('messages.Donation Failed'));
            Session::flash('error',Lang::get('messages.Transaction is Falied'));
            return Redirect::to('payment_success'); 
        }


        //......donate way start......
        // if(empty($request->user_id))
        // {
        //     $user_id=0;
        // }
        // else
        // {
        //     $user_id=$request->user_id;
            
        // }
        
        $user_id=0;
        if(!empty($request->user_id))
        {
            $user_no=User::where('id',$request->user_id)->count();
            if($user_no>0)
            {
                $user_id=$request->user_id;
            }
        }


        //echo $user_id;die();
        $donate_way=$request->donate_way;
        
        switch ($donate_way) {
            case '1':
                # code...General
                $p_s_n=0;
                $item_name='General';
                break;
            case '2':
                # code...project
                $project_id=$request->project_id;
                $p_s_n=$project_id;
                $item_name='project_'.$project_id;
                break;
            case '3':
                # code...scholarship
                $student_id=$request->student_id;
                $p_s_n=$student_id;
                $item_name='scholarship_'.$student_id;
                break;    
            
            default:
                # code...
                break;
        }
        //......donate way end......

        //......Order start......
        $order=new Order;
        if($user_id>0)
        {
            $order->user_id=$user_id;
            $order->created_by=$user_id;
        }
        $order->comments=trim($request->comments);
        $order->amount=$total_amount;
        $order->created_ip_address=CommonHelper::getRealIpAddr();
        $order->save();
        $order_id=$order->id;
        //......Order end......

        //$amount=$request->get('amount_in');


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName($item_name) /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($total_amount); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Payment via paypal');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status/'.$donate_way.'/'.$user_id.'/'.$order_id.'/'.$p_s_n)) /** Specify return URL **/
            ->setCancelUrl(URL::to('status/'.$donate_way.'/'.$user_id.'/'.$order_id.'/'.$p_s_n));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (\Config::get('app.debug')) {

                Session::flash('error', Lang::get('messages.Connection timeout'));
                return Redirect::to('payment_success');

            } else {

                Session::flash('error', Lang::get('messages.Some error occur, sorry for inconvenient'));
                return Redirect::to('payment_success');

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::flash('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }
        Session::flash('error', Lang::get('messages.Unknown error occurred'));
        return Redirect::to('payment_success');

    }

    public function getPaymentStatus($id,$user_id,$order_id,$p_s_n)
    {
        //echo $id;die();
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            Session::flash('error', Lang::get('messages.Payment failed'));
            return Redirect::to('payment_success');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        //echo $result->id;die();
        $v_cur_date_time=date('Y-m-d H:i:s');
        

        if ($result->getState() == 'approved') {

            $currency=Currency::where('currency_code','USD')->first();
            $amount_usd=$result->transactions[0]->amount->total;
            $v_donate_tk=$amount_usd*$currency->tk_convert_amount;

            //......payment data insert start.....
            $paypal_payment=new Paypal_Payment;
            if($id==2)
            {
                //.......for project....
                $paypal_payment->project_id=$p_s_n;
            }
            elseif($id==3)
            {
                //.......for scholarship....
                $paypal_payment->student_id=$p_s_n;

                
            }
            $paypal_payment->donate_way=$id;
            if($user_id>0)
            {
                $paypal_payment->user_id=$user_id;
            }
            $paypal_payment->order_id=$order_id;
            $paypal_payment->payment_date=$v_cur_date_time;
            $paypal_payment->amount=$result->transactions[0]->amount->total;
            $paypal_payment->currency=$result->transactions[0]->amount->currency;

            $paypal_payment->tk_convert_amount=$currency->tk_convert_amount;
            $paypal_payment->tk_amount=$v_donate_tk;


            $paypal_payment->transaction_fee=$result->transactions[0]->related_resources[0]->sale->transaction_fee->value;
            
            $paypal_payment->payment_id=$result->id;

            $paypal_payment->payer_payment_method=$result->payer->payment_method;
            $paypal_payment->payer_status=$result->payer->status;
            $paypal_payment->payer_email=$result->payer->payer_info->email;
            $paypal_payment->payer_first_name=$result->payer->payer_info->first_name;
            $paypal_payment->payer_last_name=$result->payer->payer_info->last_name;
            $paypal_payment->payer_id=$result->payer->payer_info->payer_id;
            $paypal_payment->payer_country_code=$result->payer->payer_info->country_code;

            $paypal_payment->payee_email=$result->transactions[0]->payee->email;
            $paypal_payment->payee_merchant_id=$result->transactions[0]->payee->merchant_id;

            $paypal_payment->state=$result->getState();
            $paypal_payment->created_ip_address=CommonHelper::getRealIpAddr();
            $paypal_payment->save();
            //......payment data insert end.....

            if($id==3)
            {
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
                    //$scholarship->donor_id=$request->donor_id;
                    //$scholarship->scholarship_date=CommonHelper::databseDateFormat($request->scholarship_date);
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
                
                $scholarship_donation->amount=$amount_usd;
                $scholarship_donation->currency_id=$currency->currency_id;
                $scholarship_donation->tk_convert_amount=$currency->tk_convert_amount;
                $scholarship_donation->tk_amount=$v_donate_tk;

                $scholarship_donation->donate_date=$v_cur_date_time;

                $scholarship_donation->type=1; //1=paid,2=return 
                $scholarship_donation->payment_method=2;
                $scholarship_donation->payment_description='Paypal payment. Transaction fee-'.$result->transactions[0]->related_resources[0]->sale->transaction_fee->value;
                if($user_id>0)
                {
                    $scholarship_donation->user_id=$user_id;
                    $scholarship_donation->created_by=$user_id;
                }
                $scholarship_donation->paypal_payment_id=$paypal_payment->id;
                $scholarship_donation->created_ip_address=CommonHelper::getRealIpAddr();
                $scholarship_donation->save();

                //........update in scholarship start.........
                $scholarship=Scholarship::find($scholarship->id);
                $scholarship->donated_amount=$scholarship->donated_amount+$v_donate_tk;
                $scholarship->due=$scholarship->due-$v_donate_tk;
                $scholarship->last_donate_date=$v_cur_date_time;
                $scholarship->save();
                //........update in scholarship end.........

                $student=Student::find($p_s_n);
                $student->is_scholarship=1;
                $student->save();
                //........transaction in scholarship end........
            }

            //...........Update user as donor start........
            if($user_id>0)
            {
                $user=User::find($user_id);
                $user->is_donor=1;
                $user->save();

                //.............Mail send start..........
                    
                //........PDF save start........
                $pdf_file_name=$paypal_payment->user_id.'_'.$paypal_payment->id.'_'.time().'.pdf';
                $pdf_path=public_path('uploads/payment_receipt/paypal/'.$pdf_file_name);
                
                $config=[
                  'mode'=>'bn',
                  'default_font_size' => '12',
                  'default_font' => 'solaimanlipi',
                ];
                $data = [
                    'payment' => $paypal_payment,
                    'paypal_id' => $paypal_payment->id,
                    'ssl_id'=>null,
                    'type'=>2
                ];
                $mergeData = [];
                $pdf = PDF::loadView('website.payments.payment_receipt', $data, $mergeData, $config);
                $pdf->save($pdf_path);
                //........PDF save end........

                $attach_file_path=asset('uploads/payment_receipt/paypal/'.$pdf_file_name);

                Mail::send('emails.payment_receipt', ['user' => $user, 'paypal_payment' => $paypal_payment,'type'=>2], function ($m) use ($user,$attach_file_path) {
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

            Session::flash('donation_msg', Lang::get('messages.Donation Success'));
            Session::flash('paypal_id', $paypal_payment->id);
            Session::flash('message', Lang::get('messages.Payment is successfully complete'));
            return Redirect::to('payment_success');

        }

        Session::flash('error', Lang::get('messages.Payment failed'));
        return Redirect::to('payment_success');

    }

}
