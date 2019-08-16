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
use Mail;
use Carbon\Carbon;
use App\Helpers\CommonHelper;

use App\Models\Inbox;
use App\Models\Sector;
use App\Models\Payment_Method;
use App\Models\Donation;
use App\Models\Currency;
use App\Models\User;
use App\Models\Contact;
use App\Models\Student;
use App\Models\Scholarship;
use App\Models\Scholarship_Donation;
use App\Models\Ssl_Payment;
use App\Models\Paypal_Payment;
use App\Models\Setting;
use App\Models\Packet;
use App\Models\Service;
use App\Models\Website;
use App\Models\Inbox_Chat;

class InboxesController extends Controller
{
    public $show_action = true;

    public function __construct()
    {
        $this->menu_id = Menu::get('Inboxes');
    }

    public function index()
    {
        if (Menu::hasAccess($this->menu_id)) {
            //echo 'hello';die();
            $endDate = Carbon::today()->format('d/m/Y');
            $startDate = Carbon::today()->subDay(2)->format('d/m/Y');
            $websites = Website::get();
            $payment_methods = Payment_Method::get(['name']);
            return View('admin.inbox.index', [
                'websites' => $websites,
                'payment_methods' => $payment_methods,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } else {
            return View('error');
        }
    }

    public function create()
    {
        if (Menu::hasAccess($this->menu_id)) {
            /*
            $list_values = Inbox::where('is_verified',1)
            ->orderby('id','desc')
            ->get();
            */

            $list_values = DB::SELECT("select * from
            (
            SELECT i.id,i.`date`,i.`amount`,c.currency_name,u.email,i.status,1 as type,i.`donor_message` as comments,i.attachment,i.`sector_id`,'1' as donate_way,s.name as sector_name,pm.name as payment_name,i.user_id,i.scholarship_amount,w.name as website_name,w.id as website_id,u.email as not_user_email
            FROM `inboxes` i
            inner join websites w on(w.id=i.website_id)
            inner join currencies c on(c.id=i.currency_id)
            inner join sectors s on(s.id=i.sector_id)
            inner join payment_methods pm on(pm.id=i.payment_method_id)
            inner join users u on(u.id=i.user_id)
            where i.is_verified='1'
            and i.deleted_at is null
            and s.deleted_at is null
            and pm.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            union
            SELECT  p.`id`,p.payment_date as date,p.amount,'Dollar' as currency_name,u.email,'3' as status,'2' as type,o.comments,null as attachment,'1' as sector_id,p.`donate_way`,null as sector_name,'Paypal' as payment_name,p.user_id,p.scholarship_amount,w.name as website_name, w.id as website_id,p.payer_email as not_user_email
            FROM `paypal_payments` p
            inner join websites w on(w.id=p.website_id)
            inner join orders o on(o.id=p.order_id)
            left join users u on(u.id=p.user_id)
            where p.deleted_at is null
            and o.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            UNION
            SELECT  s.`id`,s.`tran_time` as date,s.`total_amount` as amount,'Taka' as currency_name,u.email,'3' as status,'3' as type,o.comments,null as attachment,'1' as sector_id,s.`donate_way`,null as sector_name,'SSL' as payment_name,s.user_id,s.scholarship_amount,w.name as website_name, w.id as website_id,s.cus_email as not_user_email
                FROM `ssl_payments` s
                inner join websites w on(w.id=s.website_id)
                inner join orders o on(o.id=s.order_id)
                left join users u on(u.id=s.user_id)
                where s.`tran_status`='Success'
                and s.deleted_at is null
                and o.deleted_at is null
                and u.deleted_at is null
                and w.deleted_at is null
            ) a               
            order by a.date desc ");
            
            return View('admin.inbox.index_old', [
                'show_actions' => $this->show_action,
                'values' => $list_values,
            ]);
        } else {
            return View('error');
        }
    }

    // public function create()
    // {
    //     if (Menu::hasAccess("Inboxes", "create")) {
    //         $students = Student::get(['id', 'name']);
    //         $donors = User::where('user_level', 1)->get(['id', 'email']);
    //         $years = CommonHelper::years_list();
    //         //print_r($years);die();
    //         return View('admin.scholarship.add_form', [
    //             'students' => $students,
    //             'donors' => $donors,
    //             'years' => $years,
    //         ]);
    //     } else {
    //         return View('error');
    //     }
    // }

    public function edit($id)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {
            $inbox = Inbox::find($id);
            $sectors = Sector::get(['id', 'name', 'bn_name']);
            $payment_methods = Payment_Method::get(['id', 'name', 'bn_name']);
            $currencies = Currency::get(['id', 'currency_code']);
            $donors = User::where('user_level', 1)->get(['id', 'email', 'name']);
            $packets = Packet::get(['id', 'name', 'bn_name']);
            return View('admin.inbox.edit_form', [
                'inbox' => $inbox,
                'payment_methods' => $payment_methods,
                'sectors' => $sectors,
                'currencies' => $currencies,
                'donors' => $donors,
                'packets' => $packets,
            ]);
        } else {
            return View('error');
        }
    }

    public function store(Requests\ChatSaveRequest $request)
    {
        if (Menu::hasAccess("Inboxes", "create")) {
            $v_insert = 0;

            //.........upload image if exist start.........
            $database_image_path = null;
            $user_id = Auth::id();
            $database_image_folder_path = 'uploads/inboxes/';
            if ($request->hasFile('comment_attachment')) {
                $v_insert = 1;
                $file_image = $request->file('comment_attachment');
                $image_name = $user_id . '-' . time() . '.' . $file_image->getClientOriginalExtension();
                $file_image->move($database_image_folder_path, $image_name);
                $database_image_path = $database_image_folder_path . $image_name;
            }
            //.........upload image if exist end.........
            if (!empty($request->comments)) {
                $v_insert = 1;
            }

            if ($v_insert > 0) {
                $inbox_chat = new Inbox_Chat;
                $inbox_chat->inbox_id = $request->inbox_id;
                $inbox_chat->agent_id = $user_id;
                if (empty($database_image_path)) {
                    $inbox_chat->comments = trim($request->comments);
                } else {
                    $inbox_chat->comments = $database_image_path;
                    $inbox_chat->is_file = 1;
                }
                $inbox_chat->is_admin = 1;

                $inbox_chat->created_ip_address = CommonHelper::getRealIpAddr();
                $inbox_chat->save();
                Session::flash('message', Lang::get('messages.Saved successfully'));
            } else {
                Session::flash('error', Lang::get('messages.Insert a comment or attach a file'));
            }


            //return Redirect::to('donors/post/list');
            return redirect()->back();

            //return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');
        } else {
            return View('error');
        }
    }

    public function update(Request $request, $id)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {
            $rules = array(
                'amount' => 'required',
                'currency_id' => 'required',
                'payment_method_id' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $inbox = Inbox::find($id);
            $inbox->user_id = $request->user_id;
            $inbox->sector_id = $request->sector_id;
            //$inbox->packet_id=$request->packet_id;
            $inbox->currency_id = $request->currency_id;
            $inbox->payment_method_id = $request->payment_method_id;
            $inbox->amount = $request->amount;

            $inbox->payer_account_no = $request->payer_account_no;
            $inbox->payee_account_no = $request->payee_account_no;

            $inbox->updated_by = Auth::id();
            $inbox->updated_ip_address = CommonHelper::getRealIpAddr();
            $inbox->save();

            Session::flash('message', Lang::get('messages.Updated successfully'));
            return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');
        } else {
            return View('error');
        }
    }

    public function destroy($id)
    {
        if (Menu::hasAccess("Inboxes", "delete")) {
            $inbox_chats = Inbox::find($id)->inboxChat;
            foreach ($inbox_chats as $key => $value) {
                Inbox_Chat::find($value->id)->delete();
            }
            Inbox::find($id)->delete();

            Session::flash('message', Lang::get('messages.Deleted successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');
        } else {
            return View('error');
        }
    }

    public function show_inbox($type, $id)
    {
        switch ($type) {
            case '1':
                # code...
                $inbox = Inbox::find($id);
                return View('admin.inbox.show', [
                    'inbox' => $inbox
                ]);
                break;
            case '2':
                # code...
                $inbox = Paypal_Payment::find($id);
                return View('admin.inbox.paypal_show', [
                    'inbox' => $inbox
                ]);
                break;
            case '3':
                # code...
                $inbox = Ssl_Payment::find($id);
                return View('admin.inbox.ssl_show', [
                    'inbox' => $inbox
                ]);
                break;

            default:
                # code...
                break;
        }


    }

    public function receipt($id)
    {
        $donation = Donation::where('inbox_id', $id)->first();
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'donation' => $donation
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.inbox.receipt', $data, $mergeData, $config);
        return $pdf->download('Receipt_' . $id . '.pdf');
    }


    public function status($status, $id)
    {
        //echo $id;die();
        if (Menu::hasAccess("Inboxes", "edit")) {
            $inbox = Inbox::find($id);
            $inbox->status = $status;
            $inbox->save();
            $currency = Currency::find($inbox->currency_id);

            if ($status == 2) {
                Session::flash('message', Lang::get('messages.Clarification updated successfully'));
            } elseif ($status == 3) {


                //.........donation save start.........
                $donation = new Donation;
                if ($inbox->user_id > 0) {
                    $donation->user_id = $inbox->user_id;
                }

                $donation->inbox_id = $inbox->id;
                $donation->currency_id = $inbox->currency_id;
                $donation->amount = $inbox->amount;
                $donation->tk_convert_amount = $currency->tk_convert_amount;
                $donation->tk_amount = $inbox->amount * $currency->tk_convert_amount;
                $donation->donate_date = date('Y-m-d H:i:s');
                $donation->donate_via = 1;
                $donation->payment_description = 'Payment from post';
                $donation->created_by = Auth::id();
                $donation->created_ip_address = CommonHelper::getRealIpAddr();
                $donation->save();
                //.........donation save end.........

                if ($donation->user_id > 0) {
                    //.............Mail send start..........
                    $user = $donation->user;
                    $inbox = $donation->inbox;
                    $inbox_chats = Inbox_Chat::where('inbox_id', $donation->inbox_id)->get();

                    //........PDF save start........
                    $pdf_file_name = $donation->user_id . '_' . $donation->inbox_id . '_' . time() . '.pdf';
                    $pdf_path = public_path('uploads/payment_receipt/offline/' . $pdf_file_name);

                    $config = [
                        'mode' => 'bn',
                        'default_font_size' => '12',
                        'default_font' => 'solaimanlipi',
                    ];
                    $data = [
                        'id' => $donation->inbox_id,
                        'inbox_chats' => $inbox_chats,
                        'type'=>1
                    ];
                    $mergeData = [];
                    $pdf = PDF::loadView('website.payments.payment_receipt_offline_email', $data, $mergeData, $config);
                    $pdf->save($pdf_path);
                    //........PDF save end........

                    $attach_file_path = asset('uploads/payment_receipt/offline/' . $pdf_file_name);

                    Mail::send('emails.payment_receipt', ['user' => $user, 'inbox' => $inbox, 'type' => 2], function ($m) use ($user, $attach_file_path) {
                        $setting = Setting::first();

                        $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Payment Receipt from Bidyanondo');

                        $m->attach($attach_file_path, array(
                                'as' => 'Payment Receipt.pdf',
                                'mime' => 'application/pdf')
                        );

                    });
                    //.............Mail send end............
                }

                Session::flash('message', Lang::get('messages.Approved successfully'));
            } elseif ($status == 4) {
                Session::flash('message', Lang::get('messages.Disapproved successfully'));
            }

            return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');

        } else {
            return View('error');
        }
    }

    public function show($id)
    {
        if (Menu::hasAccess($this->menu_id)) {

            $comments = Inbox::with('inboxChat')->find($id);
            //dd($comments);

            return View('admin.inbox.comments', [
                'comments' => $comments,
                'inbox_id' => $id
            ]);
        } else {
            return View('error');
        }
    }

    public function sponsor($type, $id, $user_id)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {

            if ($type == 1) {
                //.........Inbox start......
                $info = Inbox::find($id);
            } elseif ($type == 2) {
                //.........paypal start.........
                $info = Paypal_Payment::find($id);
            } elseif ($type == 3) {
                //.........ssl start.......
                $info = Ssl_Payment::find($id);
            }

            $students = DB::SELECT("SELECT s.id,s.name,s.id_card
            FROM `scholarship_donors` sd
            inner join students s on(s.id=sd.`student_id`)
            where sd.user_id='$user_id'
            and sd.`deleted_at` is null
            and s.`deleted_at` is null");
            $currencies = Currency::get(['id', 'currency_code', 'currency_name']);
            $donors = User::where('user_level', 1)->get(['id', 'email']);
            $years = CommonHelper::years_list();
            //print_r($years);die();
            return View('admin.scholarship.add_form_common', [
                'students' => $students,
                'donors' => $donors,
                'years' => $years,
                'currencies' => $currencies,
                'info' => $info,
                'type' => $type
            ]);

        } else {
            return View('error');
        }
    }

    public function c_scholarship_store(Request $request)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {
            $rules = array(
                'donate_date' => 'required',
                'currency_id' => 'required',
                'year' => 'required',
                'student_id' => 'required',
                'amount' => 'required',
                'payment_method' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            switch ($request->payment_method) {
                case '1':
                    # for inbox start...
                    $inbox = Inbox::find($request->id);
                    $due_scholarship = $inbox->amount - $inbox->scholarship_amount;
                    if ($request->amount > $due_scholarship) {
                        return redirect()->back()->withErrors('Scholarship amount cannot be greater than verification amount');
                    }
                    break;
                case '2':
                    # for inbox start...
                    $paypal_payment = Paypal_Payment::find($request->id);
                    $due_scholarship = $paypal_payment->amount - $paypal_payment->scholarship_amount;
                    if ($request->amount > $due_scholarship) {
                        return redirect()->back()->withErrors('Scholarship amount cannot be greater than verification amount');
                    }
                    break;
                case '3':
                    # for inbox start...
                    $ssl_payment = Ssl_Payment::find($request->id);
                    $due_scholarship = $ssl_payment->total_amount - $ssl_payment->scholarship_amount;
                    if ($request->amount > $due_scholarship) {
                        return redirect()->back()->withErrors('Scholarship amount cannot be greater than verification amount');
                    }
                    break;

                default:
                    # code...
                    break;
            }

            $scholarship_exist = Scholarship::where('student_id', $request->student_id)
                ->where('year', $request->year)
                ->count();
            $student = Student::find($request->student_id);
            $currency = Currency::find($request->currency_id);
            $v_donate_tk = $request->amount * $currency->tk_convert_amount;

            if ($scholarship_exist > 0) {
                $scholarship = Scholarship::where('student_id', $request->student_id)
                    ->where('year', $request->year)
                    ->first();
                $scholarshipId = $scholarship->id;
            } else {
                $start_date = $request->year . '-01-01';
                $end_date = $request->year . '-12-31';

                $scholarship = new Scholarship;
                $scholarship->student_id = $request->student_id;
                $scholarship->year = $request->year;
                $scholarship->duration = 12;
                $scholarship->start_date = $start_date;
                $scholarship->end_date = $end_date;
                $scholarship->scholarship_amount = $student->scholarship_amount;

                $scholarship->donated_amount = $v_donate_tk;
                $scholarship->due = $student->scholarship_amount - $v_donate_tk;

                $scholarship->last_donate_date = CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);
                $scholarship->created_by = Auth::id();
                $scholarship->created_ip_address = CommonHelper::getRealIpAddr();
                $scholarship->save();

                $scholarshipId = $scholarship->id;

            }

            //.........update students start..........
            $student = Student::find($request->student_id);
            $student->is_scholarship = 1;
            $student->save();
            //.........update students end..........

            //.........insert students donations start..........
            $scholarship_donation = new Scholarship_Donation;
            $scholarship_donation->scholarship_id = $scholarshipId;
            $scholarship_donation->user_id = $request->user_id;
            $scholarship_donation->amount = $request->amount;
            $scholarship_donation->currency_id = $request->currency_id;

            $scholarship_donation->tk_convert_amount = $currency->tk_convert_amount;
            $scholarship_donation->tk_amount = $v_donate_tk;

            $scholarship_donation->donate_date = CommonHelper::databseDateTimeFormatWithCurrentTime($request->donate_date);

            $scholarship_donation->type = 1;
            $scholarship_donation->payment_method = $request->payment_method;
            $scholarship_donation->slip_no = trim($request->slip_no);
            $scholarship_donation->payment_description = trim($request->payment_description);

            $scholarship_donation->created_by = Auth::id();
            $scholarship_donation->created_ip_address = CommonHelper::getRealIpAddr();

            if ($request->payment_method == 1) {
                $scholarship_donation->inbox_id = $inbox->id;
            } elseif ($request->payment_method == 2) {
                $scholarship_donation->paypal_payment_id = $paypal_payment->id;
            } elseif ($request->payment_method == 3) {
                $scholarship_donation->ssl_payment_id = $ssl_payment->id;
            }

            $scholarship_donation->save();
            //.........insert students donations end..........

            //...........Update user as donor start........
            $user = User::find($request->user_id);
            $user->is_donor = 1;
            $user->save();
            //...........Update user as donor end........

            switch ($request->payment_method) {
                case '1':
                    # for inbox start...
                    $inbox->scholarship_amount = $inbox->scholarship_amount + $request->amount;
                    $inbox->save();

                    $inbox = Inbox::find($request->id);

                    $due_scholarship = $inbox->amount - $inbox->scholarship_amount;
                    if ($due_scholarship == 0) {
                        $inbox->status = 3;
                        $inbox->save();

                        //.............Mail send start..........
                        $user = $inbox->user;

                        //........PDF save start........
                        $pdf_file_name = $inbox->user_id . '_' . $inbox->id . '_' . time() . '.pdf';
                        $pdf_path = public_path('uploads/payment_receipt/offline/' . $pdf_file_name);
                        // $scholarship_donations = Scholarship_Donation::where('inbox_id', $inbox->id)->first();
                        $config = [
                            'mode' => 'bn',
                            'default_font_size' => '12',
                            'default_font' => 'solaimanlipi',
                        ];
                        $data = [
                            'id' => $inbox->id
                        ];
                        $mergeData = [];
                        $pdf = PDF::loadView('website.payments.scholarship_payment_receipt', $data, $mergeData, $config);
                        $pdf->save($pdf_path);
                        //........PDF save end........

                        $attach_file_path = asset('uploads/payment_receipt/offline/' . $pdf_file_name);

                        Mail::send('emails.payment_receipt', ['user' => $user], function ($m) use ($user, $attach_file_path) {
                            $setting = Setting::first();

                            $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Payment Receipt from Bidyanondo');

                            $m->attach($attach_file_path, array(
                                    'as' => 'Payment Receipt.pdf',
                                    'mime' => 'application/pdf')
                            );

                        });
                        //.............Mail send end............


                    }

                    break;

                case '2':
                    # for paypal start...
                    $paypal_payment->scholarship_amount = $paypal_payment->scholarship_amount + $request->amount;
                    $paypal_payment->save();
                    break;

                case '3':
                    # for paypal start...
                    $ssl_payment->scholarship_amount = $ssl_payment->scholarship_amount + $request->amount;
                    $ssl_payment->save();
                    break;

                default:
                    # code...
                    break;
            }

            Session::flash('message', Lang::get('messages.Saved successfully'));

            return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');
        } else {
            return View('error');
        }
    }

    public function service($type, $id, $user_id)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {
            $user_id = substr($user_id, 2);
            $dyn_id = '';
            if ($type == 1) {
                $datas = Inbox::whereId($id)->first();
                $dyn_id = 'inbox_id';
            } elseif ($type == 2) {
                $datas = Paypal_Payment::whereId($id)->first();
                $dyn_id = 'paypal_payment_id';
            } elseif ($type == 3) {
                $datas = Ssl_Payment::whereId($id)->first();
                $dyn_id = 'ssl_payment_id';
            }
            $service = $datas->service;
            $service_data_all = Service::where($dyn_id, $id)->orderBy('created_at', 'desc')->get();
            if(count($service_data_all)>0)
            {
                $service_data =$service_data_all[0];
            }
            else
            {
                $service_data =null;
            }
            
            $branchs = Contact::get();
            return View('admin.inbox.service', [
                'type' => $type,
                'inbox_id' => $id,
                'service' => $service,
                'user_id' => $user_id,
                'branchs' => $branchs,
                'service_data' => $service_data,
                'service_data_all'=>$service_data_all,
            ]);

        } else {
            return View('error');
        }
    }


    public function service_store(Requests\ServiceStoreRequest $request)
    {
        if (Menu::hasAccess("Inboxes", "edit")) {
            $inbox_id =null;
            $paypal_payment_id = null;
            $ssl_payment_id = null;

            /*update inbox table for service status*/
            if ($request->type == 1) {
                $datas = Inbox::find($request->id);
                $inbox_id = $request->id;
            } elseif ($request->type == 2) {
                $datas = Paypal_Payment::find($request->id);
                $paypal_payment_id = $request->id;
            } elseif ($request->type == 3) {
                $datas = Ssl_Payment::find($request->id);
                $ssl_payment_id = $request->id;
            }
            $datas->service = $request->service;
            $datas->save();


            /*service table data insert*/
            $service_data = New Service();
            $service_data->date = CommonHelper::databseDateFormat($request->date);
            $service_data->user_id = $request->user_id;

            $service_data->inbox_id = $inbox_id;
            $service_data->paypal_payment_id = $paypal_payment_id;
            $service_data->ssl_payment_id = $ssl_payment_id;

            $service_data->venue = $request->venue;
            $service_data->branch_id = $request->contact_id;
            if($request->send_mail==1)
            {
                $service_data->recipient_id = $request->recipient_id;
            }
            
            $service_data->subject = $request->subject;
            $service_data->description = $request->description;
            $service_data->created_by = Auth::id();
            $service_data->created_ip_address = CommonHelper::getRealIpAddr();

            $service_data->save();
            Session::flash('message', Lang::get('messages.Saved successfully'));


            //.............Mail send Satart............

            $recipient_email = '';
            $donor_email_addr = '';
            $br_email_addr = '';
            $donor_and_br_email_addr = '';

            if ($request->send_mail == 1) {

                if ($request->recipient_id == 1) {
                    //.............Mail send start Only donor receive the mail............

                    $user= User::find($request->user_id);
                    Mail::send('emails.donor_email_service', ['user' => $user, 'body' => $request->description], function ($m) use ($user, $request) {
                        $setting = Setting::first();

                        $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject($request->subject);

                        foreach ($request->file('file') as $f) {
                            $m->attach($f->getRealPath(), [
                                'as' => $f->getClientOriginalName(),
                                'mime' => 'jpg'
                            ]);
                        }


                    });

                    //.............Mail send end............
                } else if ($request->recipient_id == 2) {
                    /*Only branch receive the mail*/
                    $branch_data = Contact::find($request->contact_id);
                   // $user= User::find($request->user_id);
                    Mail::send('emails.branch_email_service', ['branch_data'=>$branch_data, 'body' => $request->description], function ($m) use ($branch_data, $request) {
                        $setting = Setting::first();

                        $m->to( $branch_data->email, $branch_data->name)->from($setting->contact_email, $setting->organization_name)->subject($request->subject);

                        foreach ($request->file('file') as $f) {
                            $m->attach($f->getRealPath(), [
                                'as' => $f->getClientOriginalName(),
                                //'mime' => 'jpg'
                            ]);
                        }


                    });

                    //.............Mail send end............

                } else if ($request->recipient_id == 3) {
                    /*Both donor and branch receive the mail*/
                    $user= User::find($request->user_id);
                    Mail::send('emails.donor_email_service', ['user' => $user, 'body' => $request->description], function ($m) use ($user, $request) {
                        $setting = Setting::first();

                        $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject($request->subject);

                        foreach ($request->file('file') as $f) {
                            $m->attach($f->getRealPath(), [
                                'as' => $f->getClientOriginalName(),
                                //'mime' => 'jpg'
                            ]);
                        }


                    });
                    /*Branch email */
                    $branch_data = Contact::find($request->contact_id);
                    // $user= User::find($request->user_id);
                    Mail::send('emails.branch_email_service', ['branch_data'=>$branch_data, 'body' => $request->description], function ($m) use ($branch_data, $request) {
                        $setting = Setting::first();

                        $m->to( $branch_data->email, $branch_data->name)->from($setting->contact_email, $setting->organization_name)->subject($request->subject);

                        foreach ($request->file('file') as $f) {
                            $m->attach($f->getRealPath(), [
                                'as' => $f->getClientOriginalName(),
                                //'mime' => 'jpg'
                            ]);
                        }


                    });

                }


            }

            return redirect()->route(config('laraadmin.adminRoute') . '.inboxes.index');
        } else {
            return View('error');
        }

    }

    //...........ajax listing start.........
    public function getInboxes(Request $request)
    {
        //dd($request->all());
        $type = $request->type;
        $website = $request->website_id;
        $limit = $request->length;
        $email = $request->email;
        $comments = $request->comments;
        $payer_account_no = $request->payer_account_no;
        $payment_method_id = $request->payment_method_id;

        $status_id=$request->status_id;
        $payee_account_no=$request->payee_account_no;
        $sign_id=$request->sign_id;
        $amount=$request->amount;

        $startoffset = $request->start;
        $typeStr ='';
        if(!empty($type))
        {
           if($type==4)
           {
               $typeStr ="AND a.type > '1'";
           }
           else
           {
               $typeStr ="AND a.type = '$type'";
           }
        }

        if(empty($amount))
        {
            $amountStr="";
        }
        else
        {
            $amountStr="AND a.amount $sign_id '$amount'";
        }
        //echo $amountStr;die();
        $statusIdStr = empty($status_id) ? " " : "AND a.status = '$status_id'";
        $payeeAccountNoStr = empty($payee_account_no) ? " " : "AND a.payee_account_no LIKE '%$payee_account_no%'";


        $paymentMethodStr = empty($payment_method_id) ? " " : "AND a.payment_name LIKE '%$payment_method_id%'";
        $payerAccountNoStr = empty($payer_account_no) ? " " : "AND a.payer_account_no LIKE '%$payer_account_no%'";
        $commentsStr = empty($comments) ? " " : "AND a.comments LIKE '%$comments%'";
        $websiteStr = empty($website) ? " " : "AND a.website_id = '$website'";
        $emailStr = empty($email) ? " " : "AND a.not_user_email LIKE '%$email%'";
        $startDate = !empty($request->startDate) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->startDate))) : '';
        $endDate = !empty($request->endDate) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->endDate))) : '';
        $limit_string = "LIMIT $startoffset,$limit";
        $list_values = $this->inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr,$commentsStr,$payerAccountNoStr,$paymentMethodStr,$statusIdStr,$payeeAccountNoStr,$amountStr);
        $total = $this->inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr,$commentsStr,$payerAccountNoStr,$paymentMethodStr,$statusIdStr,$payeeAccountNoStr,$amountStr,true);

        $data = [];
        if (count($list_values) > 0) {
            foreach ($list_values as $key => $row) {
                $downloadUrl = url(config('laraadmin.adminRoute')).'/transactions/download/'.$row->type.'/'.$row->id;
                $amount = CommonHelper::decimalNumberFormat($row->amount) . ' ' . $row->currency_name or null;
                $nestedData['seralNo'] = ++$key;
                $nestedData['donor'] = str_limit($row->email,5);

                if(empty($row->email))
                {
                    $nestedData['Email'] = '<span class="label label-default" data-toggle="tooltip" title="Never sign in">'.$row->not_user_email.'</span>';
                }
                else
                {
                    $nestedData['Email'] = '<span class="label label-success" data-toggle="tooltip" title="Sign in">'.$row->not_user_email.'</span>';
                }
                
                $nestedData['amount'] = '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->type.'/'.$row->id).'">'.$amount.'</a>';
                $nestedData['date'] = CommonHelper::showDateTimeFormat($row->date);
                $nestedData['type'] = $row->type == 1 ? '<span class="label label-warning">Offline</span>' : '<span class="label label-success">Online</span>';
                $nestedData['Payment Method'] = $row->payment_name or null;
                $nestedData['Donor Account'] = $row->payer_account_no or null;
                $nestedData['website'] = $row->website_name or null;
                $nestedData['comments'] = str_limit($row->comments,10);

                $statusArr=[
                    1=>'<span class="label label-primary">Draft</span>',
                    2=>'<span class="label label-danger">Clarify</span>',
                    3=>'<span class="label label-success">Approved</span>',
                    4=>'<span class="label label-warning">Disapproved</span>'
                ];

                $nestedData['status'] =$statusArr[$row->status];
                
                $action_data="";
                if($row->type==1)
                {
                    if($row->status<3)
                    {
                        if(!empty($row->attachment))
                        {
                            $action_data.='<a href="'.url($row->attachment).'" class="btn btn-success btn-xs"
                                       data-toggle="tooltip" title="Attachment"
                                       target="_blank"><i class="fa fa-paperclip"></i></a>';
                            
                        }
                        if (Menu::hasAccess("Inboxes", "edit")) 
                        {
                            if($row->sector_id==1)
                            {
                                $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->type.'/'.$row->id.'/'.$row->user_id).'" class="btn btn-success btn-xs" data-toggle="tooltip"
                                       title="Sponsor"><i class="fa fa-graduation-cap" aria-hidden="true"></i></a>'; 
                            }
                            else
                            {
                                $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/status/3/'.$row->id).'" class="btn btn-primary btn-xs confirm" data-toggle="tooltip"
                                   title="Approve"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';

                                $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/status/4/'.$row->id).'" class="btn btn-danger btn-xs dis_confirm" data-toggle="tooltip"
                                       title="Disapprove"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>';
                            }

                            $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" data-toggle="tooltip"
                                   title="Edit"><i class="fa fa-pencil"></i></a>';

                            if($row->status==2)
                            {
                                $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/status/1/'.$row->id).'" class="btn btn-primary btn-xs confirm_clarify" data-toggle="tooltip" title="No Need Clarification"><i class="fa fa-certificate" aria-hidden="true"></i></a>';
                            }
                            else
                            {
                                $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/status/2/'.$row->id).'" class="btn btn-danger btn-xs confirm_clarify" data-toggle="tooltip"
                                       title="Need Clarification"><i class="fa fa-ban" aria-hidden="true"></i></a>';

                            }

                        }

                        if (Menu::hasAccess("Inboxes", "delete")) {
                            $action_data .= Form::open(['route' => [config('laraadmin.adminRoute') . '.inboxes.destroy', $row->id], 'method' => 'delete', 'style' => 'display:inline']);
                            $action_data .= ' <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm(\'Are you sure to delete this?\')"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>';
                            $action_data .= Form::close();

                        }
                    }
                    else
                    {
                        if($row->status==3)
                        {
                            $service_count=Service::where('inbox_id', $row->id)->count();
                            $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/service/'.$row->type.'/'.$row->id.'/'.'d_'.$row->user_id).'" class="btn btn-default btn-xs" style="background-color: #ECF0F5;" data-toggle="tooltip" title="Event"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="badge badge-light">'.$service_count.'</span></a>';
                        }
                        if($row->scholarship_amount>0)
                        {
                            $action_data .= '<a href="'.url('donation_scholarship_receipt/'.$row->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Receipt"><i class="fa fa-download"></i></a>';
                        }
                        else
                        {
                            $action_data .= '<a href="'.url('donation_receipt/'.$row->type.'/'.$row->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Receipt"><i class="fa fa-download"></i></a>';
                        }
                    }

                    $inbox_chat = Inbox_Chat::where('inbox_id', $row->id)->latest()->first();
                    $inbox_chat_count = Inbox_Chat::where('inbox_id', $row->id)->count();
                    if(isset($inbox_chat->is_admin) && $inbox_chat->is_admin==0)
                    {
                       $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->id).'" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comments"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="badge badge-light" style="color:red;">'.$inbox_chat_count.'
                        <i class="fa fa-bell" aria-hidden="true" style="color:red"></i></span></a>'; 
                    }
                    else
                    {
                        $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->id).'" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Comments"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="badge badge-light">'.$inbox_chat_count .'</span></a>'; 
                    }
                    
                }
                else
                {
                    if($row->type==2)
                    {
                        $service_count=Service::where('paypal_payment_id', $row->id)->count();
                    }
                    else
                    {
                        $service_count=Service::where('ssl_payment_id', $row->id)->count();
                    }

                    $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/service/'.$row->type.'/'.$row->id.'/'.'d_'.$row->user_id).'"
                               class="btn btn-default btn-xs" style="background-color: #ECF0F5;" data-toggle="tooltip" title="Event"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="badge badge-light">'.$service_count.'</span></a>';
                    if($row->donate_way==1 && $row->user_id>0 && !empty($row->comments))
                    {
                        $action_data .= '<a href="'.url(config('laraadmin.adminRoute') .'/inboxes/'.$row->type.'/'.$row->id.'/'.$row->user_id).'"
                               class="btn btn-success btn-xs" data-toggle="tooltip"
                                   title="Sponsor"><i class="fa fa-users" aria-hidden="true"></i></a>';
                    }

                    $action_data .= '<a href="'.url('donation_receipt/'.$row->type.'/'.$row->id.'/'.$row->website_id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Receipt"><i class="fa fa-download"></i></a>';
                }

                $nestedData['action'] = $action_data;
                
                $data[] = $nestedData;

            }
        }
        $json_data = array(
            "draw" => intval($request->draw),
            "recordsTotal" => count($total),
            "recordsFiltered" => count($total),
            "data" => $data
        );

        echo json_encode($json_data);
    }
    public static function inboxesData($startDate, $endDate, $typeStr, $websiteStr, $limit_string, $emailStr,$commentsStr,$payerAccountNoStr,$paymentMethodStr,$statusIdStr,$payeeAccountNoStr,$amountStr,$total = false)
    {
        if ($total) {
            $limit_string = "";
        }
        $list_values = DB::SELECT("select * from
            (
            SELECT i.id,i.`date`,i.`amount`,c.currency_name,u.email,i.status,1 as type,i.`donor_message` as comments,i.attachment,i.`sector_id`,'1' as donate_way,s.name as sector_name,pm.name as payment_name,i.user_id,i.scholarship_amount,w.name as website_name, w.id as website_id,u.email as not_user_email,i.payer_account_no,i.payee_account_no
            FROM `inboxes` i
            inner join websites w on(w.id=i.website_id)
            inner join currencies c on(c.id=i.currency_id)
            inner join sectors s on(s.id=i.sector_id)
            inner join users u on(u.id=i.user_id)
            inner join payment_methods pm on(pm.id=i.payment_method_id)
            where i.is_verified='1'
            and i.deleted_at is null
            and s.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            and pm.deleted_at is null
            union
            SELECT  p.`id`,p.payment_date as date,p.amount,'Dollar' as currency_name,u.email,'3' as status,'2' as type,o.comments,null as attachment,'1' as sector_id,p.`donate_way`,null as sector_name,'Paypal' as payment_name,p.user_id,p.scholarship_amount,w.name as website_name, w.id as website_id,p.payer_email as not_user_email,p.payer_email as payer_account_no,p.payee_email as payee_account_no
            FROM `paypal_payments` p
            inner join websites w on(w.id=p.website_id)
            inner join orders o on(o.id=p.order_id)
            left join users u on(u.id=p.user_id)
            where p.deleted_at is null
            and o.deleted_at is null
            and u.deleted_at is null
            and w.deleted_at is null
            UNION
            SELECT  s.`id`,s.`tran_time` as date,s.`total_amount` as amount,'Taka' as currency_name,u.email,'3' as status,'3' as type,o.comments,null as attachment,'1' as sector_id,s.`donate_way`,null as sector_name,'SSL' as payment_name,s.user_id,s.scholarship_amount,w.name as website_name, w.id as website_id,s.cus_email as not_user_email,s.card_no as payer_account_no,'SSL' as payee_account_no
                FROM `ssl_payments` s
                inner join websites w on(w.id=s.website_id)
                inner join orders o on(o.id=s.order_id)
                left join users u on(u.id=s.user_id)
                where s.`tran_status`='Success'
                and s.deleted_at is null
                and o.deleted_at is null
                and u.deleted_at is null
                and w.deleted_at is null
            ) a  
            WHERE (DATE(a.date) BETWEEN '$startDate' AND '$endDate') 
            $typeStr 
            $websiteStr 
            $emailStr
            $commentsStr
            $payerAccountNoStr
            $paymentMethodStr
            $statusIdStr
            $payeeAccountNoStr
            $amountStr
            order by a.date desc 
            $limit_string");

        return $list_values;
    }
    //...........ajax listing end.........


}
