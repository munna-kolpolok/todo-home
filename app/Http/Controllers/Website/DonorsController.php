<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\DonorProfileUpdateRequest;
use App\Models\Blood_Group;
use App\Models\Currency;
use App\Models\Scholarship_Donation;
use App\Models\Student;
use App\Models\Student_Detail;
use App\Models\User_Profile;
use Illuminate\Http\Request;
use Collective\Html\FormFacade as Form;
use Session;
use Redirect;
use URL;
use Cookie;
use Auth;
use DB;
use Lang;
use Validator;
use File;
use Image;
use PDF;
use App\Helpers\CommonHelper;

use App\Models\User;
use App\Models\Setting;
use App\Models\Sector;
use App\Models\Payment_Method;
use App\Models\Inbox;
use App\Models\Inbox_Chat;
use App\Models\Donation;
use App\Models\Paypal_Payment;
use App\Models\Ssl_Payment;
use App\Models\Account;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DonorsController extends Controller
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
        $user_id = Auth::id();
        $sectors = Sector::where('website_id', '1')->where('is_show', '1')->orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        $payment_methods = Payment_Method::orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        //$setting=Setting::all()->first();
        $currency_lists = Currency::orderBy('serial_no', 'asc')->get(['id', 'currency_name', 'currency_code']);
        //$inboxes = Inbox::orderBy('id', 'desc')->get();
        $accounts = Account::where('website_id', '1')->get(['id', 'name', 'bn_name', 'type']);

        $inboxes = DB::SELECT("select * from
            (
            SELECT i.id,i.`date`,i.`amount`,c.currency_name,u.email,i.status,1 as type,i.`donor_message` as comments,i.attachment,i.`sector_id`,'1' as donate_way,s.name as sector_name,pm.name as payment_name,i.user_id,i.scholarship_amount
            FROM `inboxes` i
            inner join currencies c on(c.id=i.currency_id)
            inner join sectors s on(s.id=i.sector_id)
            inner join payment_methods pm on(pm.id=i.payment_method_id)
            left join users u on(u.id=i.user_id)
            where i.is_verified='1'
            and i.website_id='1'
            and s.deleted_at is null
            and pm.deleted_at is null
            and i.deleted_at is null
            and c.deleted_at is null
            and u.deleted_at is null
            union
            SELECT  p.`id`,p.payment_date as date,p.amount,'Dollar' as currency_name,u.email,'3' as status,'2' as type,o.comments,null as attachment,'1' as sector_id,p.`donate_way`,null as sector_name,'Paypal' as payment_name,p.user_id,p.scholarship_amount
            FROM `paypal_payments` p
            inner join orders o on(o.id=p.order_id)
            left join users u on(u.id=p.user_id)
            where p.deleted_at is null
            and p.state='approved'
            and p.website_id='1'
            and o.deleted_at is null
            and u.deleted_at is null

            UNION
            SELECT  s.`id`,s.`tran_time` as date,s.`total_amount` as amount,'Taka' as currency_name,u.email,'3' as status,'3' as type,o.comments,null as attachment,'1' as sector_id,s.`donate_way`,null as sector_name,'SSL' as payment_name,s.user_id,s.scholarship_amount
                FROM `ssl_payments` s
                inner join orders o on(o.id=s.order_id)
                left join users u on(u.id=s.user_id)
                where s.`tran_status`='Success'
                and s.website_id='1'
                and s.deleted_at is null
                and o.deleted_at is null
                and u.deleted_at is null
            ) a
            where a.user_id='$user_id'
            order by a.date desc ");

        /*if(request()->cookie('locale')=='bn'){*/
        return View('website.donors.reports.payment_clarification_report', [
            'inboxes' => $inboxes,
            'sectors' => $sectors,
            'payment_methods' => $payment_methods,
            'currency_lists' => $currency_lists,
            'accounts' => $accounts
        ]);
        /* }else{
             return View('website.donors.reports.payment_clarification_report', [
                 'inboxes' => $inboxes,
                 'sectors' => $sectors,
                 'payment_methods' => $payment_methods,
                 'currency_lists' => $currency_lists,
                 'accounts'=>$accounts
             ]);
         }*/

    }

    /*
    public function index(Request $request)
    {


        $user_id = Auth::id();
        $current_year = date('Y');
        $scholarship_students = DB::select("SELECT count(*) as student
        FROM `scholarship_donations` sd
        inner join scholarships s on(s.id=sd.`scholarship_id`)
        inner join students st on(st.id=s.student_id)
        WHERE sd.`user_id`='$user_id'
        and s.year='$current_year'
        and sd.`deleted_at` is null
        and s.`deleted_at` is null
        and st.`deleted_at` is null
        group by st.id");

        //dd($scholarship_students);
        if (empty($scholarship_students)) {
            $scholarship_students = null;
        } else {
            $scholarship_students = $scholarship_students[0];
        }

        //........USD start................
        $paypal_payment_sum_usd = Paypal_Payment::where('user_id', $user_id)
            ->where('state', 'approved')
            ->whereYear('payment_date', '=', $current_year)
            ->whereNull('student_id')
            ->sum('amount');

        $scholarship_donation_sum_usd = Scholarship_Donation::where('user_id', $user_id)
            ->where('currency_id', 1)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');

        $donation_sum_usd = Donation::where('user_id', $user_id)
            ->where('currency_id', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');

        //........USD end................

        //........Taka start................
        $ssl_payment_sum_bdt = Ssl_Payment::where('user_id', $user_id)
            ->where('tran_status', 'Success')
            ->whereYear('tran_time', '=', $current_year)
            ->whereNull('student_id')
            ->sum('total_amount');

        $scholarship_donation_sum_bdt = Scholarship_Donation::where('user_id', $user_id)
            ->where('currency_id', 2)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');

        $donation_sum_bdt = Donation::where('user_id', $user_id)
            ->where('currency_id', 2)
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');
        //........Taka end................


        //........Other currency start................
        $scholarship_donation_sum_oc = Scholarship_Donation::where('user_id', $user_id)
            ->whereNotIn('currency_id', [1, 2])
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');

        $donation_sum_oc = Donation::where('user_id', $user_id)
            ->whereNotIn('currency_id', [1, 2])
            ->whereYear('donate_date', '=', $current_year)
            ->sum('amount');
        //........Other currency end................

        return View('website.donors.profile', [
            'current_year' => $current_year,
            'scholarship_students' => $scholarship_students,
            'paypal_payment_sum_usd' => $paypal_payment_sum_usd,
            'scholarship_donation_sum_usd' => $scholarship_donation_sum_usd,
            'donation_sum_usd' => $donation_sum_usd,

            'ssl_payment_sum_bdt' => $ssl_payment_sum_bdt,
            'scholarship_donation_sum_bdt' => $scholarship_donation_sum_bdt,
            'donation_sum_bdt' => $donation_sum_bdt,

            'scholarship_donation_sum_oc' => $scholarship_donation_sum_oc,
            'donation_sum_oc' => $donation_sum_oc,

        ]);

    }
    */

    public function store(Requests\DonationPostRequest $request)
    {
        //print_r($request->file('attachment'));die();
        //.........upload image if exist start.........
        $database_image_path = null;
        $user_id = Auth::id();
        $database_image_folder_path = 'uploads/inboxes/';
        if ($request->hasFile('attachment')) {
            $file_image = $request->file('attachment');
            $image_name = $user_id . '-' . time() . '.' . $file_image->getClientOriginalExtension();
            $file_image->move($database_image_folder_path, $image_name);
            $database_image_path = $database_image_folder_path . $image_name;
        }
        //.........upload image if exist end.........

        $currency = Currency::find($request->currency_id);

        $inbox = new Inbox;
        $inbox->user_id = Auth::id();
        $inbox->date = CommonHelper::databseDateTimeFormatWithCurrentTime($request->date);
        $inbox->sector_id = $request->sector_id;
        $inbox->payment_method_id = $request->payment_method_id;
        $inbox->currency_id = $request->currency_id;
        $inbox->amount = $request->amount;

        $inbox->tk_convert_amount = $currency->tk_convert_amount;
        $inbox->tk_amount = $request->amount * $currency->tk_convert_amount;

        $inbox->payer_account_no = $request->payer_account_no;
        $inbox->payee_account_no = $request->payee_account_no;

        $inbox->donor_message = trim($request->donor_message);

        $inbox->attachment = $database_image_path;
        $inbox->is_verified = 1;
        $inbox->created_by = Auth::id();
        $inbox->created_ip_address = CommonHelper::getRealIpAddr();
        $inbox->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return Redirect::to('/donors');
        /*
        if ($request->redirect_status == 1 ) {
            return Redirect::to('/donors');
        } else {
            return Redirect::to('donors/post/list');
        }
        */
    }

    public function profileEdit()
    {
        $user = User::with(['profile' => function ($profile) {
            $profile->with('blogGroup');
        }])->find(Auth::id());
        $bloodGroups = Blood_Group::all();
        //dd($user);
        return view('website.donors.profile.profile', compact('user', 'bloodGroups'));
    }

    public function updateDonor($userId, DonorProfileUpdateRequest $request)
    {
        $user = User::find($userId);
        $user->name = $request->name;
        $user->save();
        //upload images
        if ($request->hasFile('image')) {
            $path = public_path() . '/uploads/users/';
            $database_image_folder_path = '/uploads/users/';
            if (File::exists($path)) {
                //check existing image and unlink
               if (!empty($user->profile)) {
                   $existing_image = public_path().$user->profile->image;
                   if (file_exists($existing_image)) {
                       //first unlink the image
                       @unlink($existing_image);
                   }
               }
                $user_image = $request->file('image');
                $image_name = $user->id . '-' . time() . '.' . $user_image->getClientOriginalExtension();
                $user_path_image = $path . $image_name;
                Image::make($user_image->getRealPath())->resize(360, 310)->save($user_path_image);
                $database_image_path = $database_image_folder_path . $image_name;
                $data['image'] = $database_image_path;
            }

        }
        $data['blood_group_id']= $request->blood_group_id;
        $data['contact_no'] = $request->contact_no;
        $data['address'] = $request->address;
        $data['interest'] = $request->interest;
        $data['occupation'] = $request->occupation;
        if (!empty($user->profile)) {
            $user->profile()->update($data);
        } else {
            $data['user_id'] = $user->id;
            User_Profile::create($data);
        }
        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->back();
    }

    public function save_inbox_chat(Requests\ChatSaveRequest $request)
    {
        $v_insert = 0;
        /*     $rules = array(
                 'inbox_id' => 'required',
                 'comment_attachment' => 'sometimes|max:1024',
             );

             $validator = Validator::make($request->all(), $rules);
             if ($validator->fails()) {
                 return redirect()->back()->withErrors($validator)->withInput();
             }*/

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
            $inbox_chat->customer_id = $user_id;
            if (empty($database_image_path)) {
                $inbox_chat->comments = trim($request->comments);
            } else {
                $inbox_chat->comments = $database_image_path;
                $inbox_chat->is_file = 1;
            }
            $inbox_chat->is_admin = 0;

            $inbox_chat->created_ip_address = CommonHelper::getRealIpAddr();
            $inbox_chat->save();
            Session::flash('message', Lang::get('messages.Send successfully'));
        } else {
            Session::flash('error', Lang::get('messages.Insert a comment or attach a file'));
        }

        return redirect()->back();

        //return Redirect::to('donors/post/list');
    }

    public function show($id)
    {
        $inbox = Inbox::find($id);
        if ($inbox->user_id != Auth::id()) {
            return redirect('/');
        }
        $sectors = Sector::where('website_id', '1')->where('is_show', '1')->orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        $payment_methods = Payment_Method::orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        $currency_lists = Currency::orderBy('serial_no', 'asc')->get(['id', 'currency_name', 'currency_code']);
        $accounts = Account::where('website_id', '1')->get(['id', 'name', 'bn_name', 'type']);
        return view('website.donors.reports.show', compact('inbox', 'sectors', 'payment_methods', 'currency_lists', 'accounts'));
    }

    public function getInboxValue(Request $request)
    {
        $inbox = Inbox::find($request->id);
        $inbox['date'] = CommonHelper::showDateFormat($inbox->date);
        $inbox['amount'] = CommonHelper::decimalNumberFormat($inbox->amount);
        return $inbox;
    }

    public function update(Requests\DonationPostRequest $request, $id)
    {
        $currency = Currency::find($request->currency_id);
        $inbox = Inbox::find($id);
        $database_image_path = null;
        $user_id = Auth::id();
        $database_image_folder_path = 'uploads/inboxes/';
        if ($request->hasFile('attachment')) {
            //existing file unlink
            $existing_path = public_path() . '/' . $inbox->attachment;
            if (file_exists($existing_path)) {
                //first unlink the image
                @unlink($existing_path);
            }

            $file_image = $request->file('attachment');
            $image_name = $user_id . '-' . time() . '.' . $file_image->getClientOriginalExtension();
            $file_image->move($database_image_folder_path, $image_name);
            $database_image_path = $database_image_folder_path . $image_name;
            $inbox->attachment = $database_image_path;
        }
        //.........upload image if exist end.........

        $inbox->user_id = Auth::id();
        $inbox->date = CommonHelper::databseDateTimeFormatWithCurrentTime($request->date);
        $inbox->sector_id = $request->sector_id;
        $inbox->payment_method_id = $request->payment_method_id;
        $inbox->currency_id = $request->currency_id;
        $inbox->amount = $request->amount;

        $inbox->tk_convert_amount = $currency->tk_convert_amount;
        $inbox->tk_amount = $request->amount * $currency->tk_convert_amount;

        $inbox->payer_account_no = ($request->payment_method_id <= 3 || $request->payment_method_id == 8) ? null : $request->payer_account_no;
        $inbox->payee_account_no = $request->payment_method_id > 3 ? $request->payee_account_no : null;

        $inbox->donor_message = trim($request->donor_message);

        $inbox->is_verified = 1;
        $inbox->created_by = Auth::id();
        $inbox->created_ip_address = CommonHelper::getRealIpAddr();
        $inbox->save();

        Session::flash('message', Lang::get('messages.Updated successfully'));
        return redirect()->back();
        /*if ($request->redirect_status == 1 ) {
            return Redirect::to('/donors');
        } else {
            return Redirect::to('donors/post/list');
        }*/
    }

    public function destroy($id)
    {
        // Inbox::find($id)->delete();

        // Session::flash('message',Lang::get('messages.Deleted successfully'));

        // return redirect()->route('donors.index');
    }

    public function delete_post($report, $id)
    {
        $inbox_chats = Inbox::find($id)->inboxChat;
        foreach ($inbox_chats as $key => $value) {
            Inbox_Chat::find($value->id)->delete();
        }
        Inbox::find($id)->delete();

        Session::flash('message', Lang::get('messages.Deleted successfully'));

        if ($report > 0) {
            return Redirect::to('donors');
        } else {
            return Redirect::to('donors/post/list');
        }

    }


    public function donorPost($sector_filter = '0', $status_filter = '0', $latest_filter = '5', $inbox_id = 0)
    {
        $user_id = Auth::id();

        // $inboxes=Inbox::where('user_id',Auth::id())
        //     ->skip(0)->take(5)->orderBy('id','desc')->with('inboxChat')->get();
        //$date = \Carbon\Carbon::today()->subDays($duration_filter);
        if ($inbox_id > 0) {
            $inboxes = Inbox::where('id', $inbox_id)
                ->with('inboxChat')
                ->get();
        } else {
            if ($sector_filter > 0) {
                if ($status_filter > 0) {
                    $inboxes = Inbox::where('user_id', $user_id)
                        ->where('sector_id', $sector_filter)
                        ->where('status', $status_filter)
                        ->skip(0)->take($latest_filter)
                        ->orderBy('id', 'desc')
                        ->with('inboxChat')
                        ->get();
                } else {
                    $inboxes = Inbox::where('user_id', $user_id)
                        ->where('sector_id', $sector_filter)
                        ->skip(0)->take($latest_filter)
                        ->orderBy('id', 'desc')
                        ->with('inboxChat')
                        ->get();
                }

            } else {
                if ($status_filter > 0) {
                    $inboxes = Inbox::where('user_id', $user_id)
                        ->where('status', $status_filter)
                        ->skip(0)->take($latest_filter)
                        ->orderBy('id', 'desc')
                        ->with('inboxChat')
                        ->get();
                } else {
                    $inboxes = Inbox::where('user_id', $user_id)
                        ->skip(0)->take($latest_filter)
                        ->orderBy('id', 'desc')
                        ->with('inboxChat')
                        ->get();
                }

            }
        }


        $sectors = Sector::where('website_id', '1')->where('is_show', '1')->orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        $payment_methods = Payment_Method::get(['id', 'name', 'bn_name']);
        //$setting=Setting::all()->first();
        $currency_lists = Currency::get(['id', 'currency_name', 'currency_code']);


        //dd($inboxes);
        return View('website.donors.post', [
            // 'setting' => $setting,
            'sectors' => $sectors,
            'payment_methods' => $payment_methods,
            'currency_lists' => $currency_lists,
            'inboxes' => $inboxes,

            'sector_filter' => $sector_filter,
            'status_filter' => $status_filter,
            'latest_filter' => $latest_filter
        ]);
    }

    public function scholarship()
    {
        // $students = Student::where(['is_website'=> 1, 'is_scholarship'=> 2])
        //     ->orderby('id','desc')
        //     ->skip(0)->take(3)
        //     ->get();

        $user_id = Auth::id();
        $current_year = date('Y');
        /* scholarsip wise main logic it is
        $students = DB::select("SELECT st.id,st.name, st.biography,st.bn_biography,st.bn_name,st.student_image,st.student_smile_image,sd.`scholarship_id`,sd.`user_id`
        FROM `scholarship_donations` sd
        inner join scholarships s on(s.id=sd.`scholarship_id`)
        inner join students st on(st.id=s.student_id)
        WHERE sd.`user_id`='$user_id'
        and s.year='$current_year'
        and sd.`deleted_at` is null
        and s.`deleted_at` is null
        and st.`deleted_at` is null
        group by st.id");
        */

        /* donor e tag korle student donor ke shw koro for data entry  start*/
        $students = DB::select("SELECT st.id,st.name, st.biography,st.bn_biography,st.bn_name,st.student_image,sdo.`user_id`,
            case
                WHEN sd.`scholarship_id`>0 then sd.`scholarship_id`
                else '0'
            end as scholarship_id
            FROM `scholarship_donors` sdo
            inner join students st on(st.id=sdo.student_id)
            left join scholarship_donations sd on(sd.`user_id`=sdo.`user_id`)
            left join scholarships s on(s.id=sd.`scholarship_id`)
        
        WHERE sdo.`user_id`='$user_id'
        and sdo.`deleted_at` is null
        and sd.`deleted_at` is null
        and s.`deleted_at` is null
        and st.`deleted_at` is null
        group by st.id");
        /* donor e tag korle student donor ke shw koro for data entry end*/


        $sponsors = Student::where(['is_website' => 1, 'is_scholarship' => 2])
            ->orderby('id', 'desc')
            ->skip(0)->take(12)
            ->get();

        return view('website.donors.scholarship', compact('students', 'sponsors'));
    }

    public function scholarshipDetails($id, $scholarship_id)
    {
        /*if(request()->cookie('locale')=='bn'){
            $student = Student::with('details')->find($id);
            $donation_details = Scholarship_Donation::where('scholarship_id', $scholarship_id)->with('scholarship')->get();
            return view('website.donors.scholarship_details_bn', compact('student', 'donation_details'));
        }else{
            $student = Student::with('details')->find($id);
            $donation_details = Scholarship_Donation::where('scholarship_id', $scholarship_id)->with('scholarship')->get();
            return view('website.donors.scholarship_details', compact('student', 'donation_details'));
        }*/
        $student = Student::with('details')->find($id);
        $donation_details = Scholarship_Donation::where('scholarship_id', $scholarship_id)->with('scholarship')->get();
        return view('website.donors.scholarship_details', compact('student', 'donation_details'));

    }

    public function inbox_clarification(Request $request)
    {
        $rules = array(
            'inbox_id' => 'required',
            'donor_clarification' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inbox = Inbox::find($request->inbox_id);
        $inbox->donor_clarification = trim($request->donor_clarification);
        $inbox->save();

        Session::flash('message', Lang::get('messages.Saved successfully'));

        return redirect()->route('donors.index');

    }

    public function receipt($id)
    {
        $donation = Donation::where('inbox_id', $id)->first();
        $inbox_chats = Inbox_Chat::where('inbox_id', $id)->get();
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'donation' => $donation,
            'inbox_chats' => $inbox_chats
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.inbox.receipt', $data, $mergeData, $config);
        //print_r($pdf);die();
        //return $pdf->stream('Receipt_'.$id.'.pdf');
        return $pdf->download('Receipt_' . $id . '.pdf');
        //return $pdf->save(storage_path('uploads/some-filename.pdf'));
        //return $pdf->save(public_path('uploads/some-filename2.pdf'));
    }

    public function paypal_receipt($id)
    {
        $paypal_payment = Paypal_Payment::find($id);
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'paypal_payment' => $paypal_payment
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.payment.paypal_receipt', $data, $mergeData, $config);
        return $pdf->download('Receipt_' . $id . '.pdf');
    }

    public function ssl_receipt($id)
    {
        $ssl_payment = Ssl_Payment::find($id);
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'ssl_payment' => $ssl_payment
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.payment.ssl_receipt', $data, $mergeData, $config);
        return $pdf->download('Receipt_' . $id . '.pdf');
    }

    public function scholarship_receipt($id)
    {
        $scholarship_donations = Scholarship_Donation::where('inbox_id', $id)->get();
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'scholarship_donations' => $scholarship_donations
        ];
        $mergeData = [];
        $pdf = PDF::loadView('admin.payment.scholarship_receipt', $data, $mergeData, $config);
        return $pdf->download('Receipt_' . $id . '.pdf');
    }


    //.............Report start............
    public function paypal_payments($current_year)
    {
        $user_id = Auth::id();
        //echo $year;die();
        // $paypal_payments=Paypal_Payment::where('user_id',$user_id)
        // ->where('state','approved')
        // ->whereYear('payment_date','=',$year)
        // ->whereNull('student_id')
        // ->get();

        $paypal_payment_sum_usd = Paypal_Payment::where('user_id', $user_id)
            ->where('state', 'approved')
            ->whereYear('payment_date', '=', $current_year)
            ->whereNull('student_id')
            ->get();

        $scholarship_donation_sum_usd = Scholarship_Donation::where('user_id', $user_id)
            ->where('currency_id', 1)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        $donation_sum_usd = Donation::where('user_id', $user_id)
            ->where('currency_id', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        return View('website.donors.reports.paypal_payment_report', [
            'current_year' => $current_year,
            'paypals' => $paypal_payment_sum_usd,
            'scholarships' => $scholarship_donation_sum_usd,
            'donations' => $donation_sum_usd,

        ]);
    }

    public function ssl_payments($current_year)
    {
        $user_id = Auth::id();

        $ssl_payment_sum_bdt = Ssl_Payment::where('user_id', $user_id)
            ->where('tran_status', 'Success')
            ->whereYear('tran_time', '=', $current_year)
            ->whereNull('student_id')
            ->get();

        $scholarship_donation_sum_bdt = Scholarship_Donation::where('user_id', $user_id)
            ->where('currency_id', 2)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        $donation_sum_bdt = Donation::where('user_id', $user_id)
            ->where('currency_id', 2)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        return View('website.donors.reports.ssl_payment_report', [
            'current_year' => $current_year,
            'ssls' => $ssl_payment_sum_bdt,
            'scholarships' => $scholarship_donation_sum_bdt,
            'donations' => $donation_sum_bdt,
        ]);
    }

    public function other_currency($current_year)
    {
        $user_id = Auth::id();
        $scholarship_donation_sum_oc = Scholarship_Donation::where('user_id', $user_id)
            ->whereNotIn('currency_id', [1, 2])
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        $donation_sum_oc = Donation::where('user_id', $user_id)
            ->whereNotIn('currency_id', [1, 2])
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        return View('website.donors.reports.other_currency_report', [
            'current_year' => $current_year,
            'scholarships' => $scholarship_donation_sum_oc,
            'donations' => $donation_sum_oc,
        ]);
    }

    public function scholarship_donations($current_year)
    {
        $user_id = Auth::id();
        $scholarship_donation_sum = Scholarship_Donation::where('user_id', $user_id)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();
        return View('website.donors.reports.scholarship_donations_report', [
            'current_year' => $current_year,
            'scholarships' => $scholarship_donation_sum,
        ]);
    }

    public function all_donations($current_year)
    {
        $user_id = Auth::id();

        $paypal_payment_sum_usd = Paypal_Payment::where('user_id', $user_id)
            ->where('state', 'approved')
            ->whereYear('payment_date', '=', $current_year)
            ->whereNull('student_id')
            ->get();

        $ssl_payment_sum_bdt = Ssl_Payment::where('user_id', $user_id)
            ->where('tran_status', 'Success')
            ->whereYear('tran_time', '=', $current_year)
            ->whereNull('student_id')
            ->get();

        $scholarship_donation_sum_usd = Scholarship_Donation::where('user_id', $user_id)
            ->where('type', 1)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        $donation_sum_usd = Donation::where('user_id', $user_id)
            ->whereYear('donate_date', '=', $current_year)
            ->get();

        return View('website.donors.reports.all_donation_report', [
            'current_year' => $current_year,
            'paypals' => $paypal_payment_sum_usd,
            'ssls' => $paypal_payment_sum_usd,
            'scholarships' => $scholarship_donation_sum_usd,
            'donations' => $donation_sum_usd,

        ]);
    }

    /*
    public function payment_clarification_report()
    {
        $sectors = Sector::get(['id', 'name', 'bn_name']);
        $payment_methods = Payment_Method::get(['id', 'name', 'bn_name']);
        //$setting=Setting::all()->first();
        $currency_lists = Currency::get(['id', 'currency_name', 'currency_code']);
        $inboxes = Inbox::orderBy('id', 'desc')->get();
        return View('website.donors.reports.payment_clarification_report', [
            'inboxes' => $inboxes,
            'sectors' => $sectors,
            'payment_methods' => $payment_methods,
            'currency_lists' => $currency_lists
        ]);
    }
    */


    //.............Report end............


}