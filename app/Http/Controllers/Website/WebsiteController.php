<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\Campaign;
use App\Models\Campaign_Images;
use App\Models\Contact_message;
use App\Models\Currency;
use App\Models\Donation_Amount;
use App\Models\Inbox;
use App\Models\Latest_News;
use App\Models\Payment_Method;
use App\Models\Press;
use App\Models\Press_Category;
use App\Models\Project_Image;
use App\Models\Sector;
use App\Models\Video;
use App\Models\Video_Category;
use Carbon\Carbon;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;
use Collective\Html\FormFacade as Form;
use Session;
use Validator;
use URL;
use Cookie;
use Auth;
use DB;
use Lang;
use Mail;
use Response;
use Hash;
use PDF;
use Redirect;
use App\Helpers\CommonHelper;

use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Models\Project;
use App\Models\FAQ;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Gallery;
use App\Models\Gallery_Category;
use App\Models\Account;
use App\Models\Ssl_Payment;
use App\Models\Paypal_Payment;
use App\Models\Subscriber;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class WebsiteController extends Controller
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
     * only using for uploads directory name change purpose
     * @param $model
     * @param $field_name
     */

   /* public function updateDatabase($model, $field_name)
    {
        $models = 'App\Models\\' . ucfirst($model);
        $values = $models::get();
        //dd($values);
        if (count($values)) {
            foreach ($values as $value) {
                $image_path = $value->{$field_name};
                $new_path = str_replace('uimages', 'uploads', $image_path);
                $value->{$field_name} = $new_path;
                $value->save();
            }
            echo "Update successfully";
        } else {
            echo "Data not found";
        }
    }*/


    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('is_show', 1)
            ->where('is_home', 1)
            ->where('is_project', 1)
            ->orderby('serial_no')
            ->get();
        $sliders = Slider::where('website_id', '1')
            ->where('status', '1')
            ->orderby('serial_no')
            ->get();
        $latestNewses = Latest_News::where('website_id', 1)
            ->where('status', '1')
            ->orderby('serial_no')
            ->get();
        $campaigns = Campaign::withCount('images')
            ->where(['website_id' => 1, 'is_show' => 1, 'is_home' => 1])
            ->orderby('serial_no')
            ->get()
            ->take(3);
        if (request()->cookie('locale') == 'bn') {
            return view('website.bn_home', compact('projects', 'sliders', 'latestNewses', 'campaigns'));
        } else {
            return view('website.home', compact('projects', 'sliders', 'latestNewses', 'campaigns'));
        }

    }

    public function signin()
    {
        Auth::logout();
        return view('website.signin');
    }

    public function signup()
    {
        return view('website.signup');
    }

    public function forgetPassword()
    {
        return view('website.forget_password');
    }

    public function checkEmail(Requests\ForgotPasswordRequest $request)
    {
        //dd($request->all());
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            $validator = ['0' => Lang::get('messages.You are not registered. Please sign up')];
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $verify_token = str_random(40);
            $v_password = mt_rand(100000, 999999);

            $user->password = bcrypt($v_password);
            $user->verify_token = $verify_token;
            $user->is_verified = 0;
            $user->save();

            Mail::send('emails.forget_password_email', ['user' => $user, 'password' => $v_password], function ($m) use ($user) {
                $setting = Setting::first();
                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Forget Password Mail Verfication from Bidyanondo!');
            });

            Auth::logout();

            Session::flash('message', Lang::get('messages.New password is sent to your email. Please verify your email.'));
            return redirect('/signin');

        }


    }

    public function resetPassword()
    {
        return view('website.reset_password');
    }

    public function changePassword(Requests\ResetPasswordRequest $request)
    {
        $oldPassword = $request->old_password;
        $newPassword = $request->password;
        if ($newPassword == $oldPassword) {
            return redirect()->back()->withErrors(['password' => Lang::get('messages.New password and old password are same')]);
        }

        $user = User::find(Auth::id());

        $password_match = Hash::check($oldPassword, $user->password);

        if ($password_match == '1') {
            $password = bcrypt($newPassword);
            $user->password = $password;
            $user->save();

            Mail::send('emails.reset_password_email', ['user' => $user, 'password' => $newPassword], function ($m) use ($user) {
                $setting = Setting::first();

                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Password Change Mail from Bidyanondo!');


            });

            //return view('website.home');
            Session::flash('message', Lang::get('messages.Your password changed successfully. Please check your email for details'));

            Auth::logout();
            return redirect('/signin');
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Wrong old password']);
        }

    }

    public function all_projects()
    {
        $projects = Project::where('is_show', 1)->where('is_project', 1)->orderby('serial_no')->get();
        return view('website.projects.projects', compact('projects'));
    }

    public function projects($id)
    {
        $project = Project::find($id);
        $donation_amounts = Donation_Amount::where(['project_id' => $project->id, 'general_donation' => 0])->get();
        $projectImages = Project_Image::whereProjectId($project->id)->orderBy('serial_no')->paginate(4);
        //if ($project->is_project == 1) {
        if (\request()->ajax()) {
            $view = view('website.projects.data', compact('projectImages'))->render();
            return response()->json(['html' => $view]);
        }
        if (request()->cookie('locale') == 'bn') {
            return view('website.projects.single_project_bn', compact('project', 'donation_amounts', 'projectImages'));
        } else {
            return view('website.projects.single_project', compact('project', 'donation_amounts', 'projectImages'));
        }
        /*} else {
            $projects = Project::where('is_show', 1)->where('is_project', 1)->where('parent', $id)->get();
            return view('website.projects.projects', compact('projects','donation_amounts'));
        }*/

    }

    public function projects_name($name)
    {
        $name = str_replace('-', ' ', $name);
        $project = Project::where('name', $name)->first();
        $donation_amounts = Donation_Amount::where(['project_id' => $project->id, 'general_donation' => 0])->get();
        $projectImages = Project_Image::whereProjectId($project->id)->orderBy('serial_no')->paginate(4);

        if (\request()->ajax()) {
            $view = view('website.projects.data', compact('projectImages'))->render();
            return response()->json(['html' => $view]);
        }

        if (request()->cookie('locale') == 'bn') {
            return view('website.projects.single_project_bn', compact('project', 'donation_amounts', 'projectImages'));
        } else {
            return view('website.projects.single_project', compact('project', 'donation_amounts', 'projectImages'));
        }

    }

    public function scholarship()
    {
        $students = Student::where(['is_website' => 1, 'is_scholarship' => 2])
            ->orderby('id', 'desc')
            ->skip(0)->take(12)
            ->get();
        return view('website.scholarship.scholarship', compact('students'));
    }


    public function scholarshipDetails($id)
    {
        $student = Student::find($id);
        $students = Student::where(['is_website' => 1, 'is_scholarship' => 2])
            ->whereNotIn('id', [$student->id])
            ->orderby('id', 'desc')
            ->skip(0)->take(7)
            ->get(['id', 'name', 'student_image']);
        $settings = Setting::first();
        $setting = $settings;
        return view('website.scholarship.details', compact('student', 'settings', 'students', 'setting'));
    }

    //..............User registration start.............
    public function user_register(Requests\UserRegistrationRequest $request)
    {
        if ($request->password != $request->re_password) {
            $validator = ['0' => Lang::get('messages.Password and re-type password must be same.')];
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id_card = time() . '-' . rand(1, 100);
        //print_r($request);die();
        $user = User::create([
            'name' => $request->name,
            'id_card' => $id_card,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_level' => "1",
            'type' => "Employee",
            'verify_token' => str_random(40)
        ]);

        //Mail::to($user->email)->send(new VerifyMail($user));
        $user = User::findOrFail($user->id);
        //print_r($user);die();

        Mail::send('emails.verify_email', ['user' => $user, 'password' => $request->password], function ($m) use ($user) {

            $setting = Setting::first();

            $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Sign Up Mail Verfication from Bidyanondo!');
        });

        //return view('website.home');
        Session::flash('message', Lang::get('messages.Registered successfully! An email is sent to your mail for verification. Please verify it for Sign In.'));
        return redirect('/signup');
    }

    public function email_verification($id, $verify_token)
    {
        $user = User::where(['id' => $id, 'verify_token' => $verify_token])->first();
        if (!empty($user)) {
            $user->is_verified = 1;
            $user->verify_token = null;
            $user->save();
        }
        Session::flash('message', Lang::get('messages.Your email is verified successfully. Please Sign In'));
        return redirect('/signin');
    }

    //..............User registration end.............

    public function scholarshipAmount(Request $request)
    {
        $currency_bdt = Currency::where('currency_code', 'BDT')->first();
        $currency_usd = Currency::where('currency_code', 'USD')->first();
        $usd_min_donate_amount=$currency_usd->min_donate_amount;
        $usd_max_donate_amount=$currency_usd->max_donate_amount;

        $bdt_min_donate_amount=$currency_bdt->min_donate_amount;
        $bdt_max_donate_amount=$currency_bdt->max_donate_amount;

        $student_id = $request->id;
        //$convert_usd = Setting::first()->tk_to_usd;
        $usd_value = $currency_usd->tk_convert_amount;
        $student = Student::find($student_id);
        $bd_amount = $student->scholarship_amount;
        $in_amount = ceil($student->scholarship_amount / $usd_value);
        //$amount['lang'] = request()->cookie('locale') == 'bn' ? 'bn' : 'en';

        

        //international payment option
        $first_month_amount_in = ceil($in_amount / 12);
        //$second_month_amount_in = ceil(($in_amount * 2) / 12);
        $third_month_amount_in = ceil(($in_amount * 3) / 12);
        //$fifth_month_amount_in = ceil(($in_amount * 5) / 12);
        $sixth_month_amount_in = ceil(($in_amount * 6) / 12);
        $ninth_month_amount_in = ceil(($in_amount * 9) / 12);
        //$tenth_month_amount_in = ceil(($in_amount * 10) / 12);
        $twelve_month_amount_in = ceil(($in_amount * 12) / 12);

        //BD payment option
        $first_month_amount_bd = ceil($bd_amount / 12);
        //$second_month_amount_bd = ceil(($bd_amount * 2) / 12);
        $third_month_amount_bd = ceil(($bd_amount * 3) / 12);
        //$fifth_month_amount_bd = ceil(($bd_amount * 5) / 12);
        $sixth_month_amount_bd = ceil(($bd_amount * 6) / 12);
        $ninth_month_amount_bd = ceil(($bd_amount * 9) / 12);
        //$tenth_month_amount_bd = ceil(($bd_amount * 10) / 12);
        $twelve_month_amount_bd = ceil(($bd_amount * 12) / 12);

        if(request()->cookie('locale') == 'bn')
        {
            $first_month_amount_in_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($first_month_amount_in));
            $third_month_amount_in_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($third_month_amount_in));
            $sixth_month_amount_in_show = CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($sixth_month_amount_in));
            $ninth_month_amount_in_show = CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($ninth_month_amount_in));
            $twelve_month_amount_in_show = CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($twelve_month_amount_in));

            $first_month_amount_bd_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($first_month_amount_bd));
            $third_month_amount_bd_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($third_month_amount_bd));
            $sixth_month_amount_bd_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($sixth_month_amount_bd));
            $ninth_month_amount_bd_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($ninth_month_amount_bd));
            $twelve_month_amount_bd_show=CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($twelve_month_amount_bd));
        }
        else
        {
            $first_month_amount_in_show=CommonHelper::bd_money_format_wod($first_month_amount_in);
            $third_month_amount_in_show=CommonHelper::bd_money_format_wod($third_month_amount_in);
            $sixth_month_amount_in_show = CommonHelper::bd_money_format_wod($sixth_month_amount_in);
            $ninth_month_amount_in_show = CommonHelper::bd_money_format_wod($ninth_month_amount_in);
            $twelve_month_amount_in_show = CommonHelper::bd_money_format_wod($twelve_month_amount_in);

            $first_month_amount_bd_show=CommonHelper::bd_money_format_wod($first_month_amount_bd);
            $third_month_amount_bd_show=CommonHelper::bd_money_format_wod($third_month_amount_bd);
            $sixth_month_amount_bd_show=CommonHelper::bd_money_format_wod($sixth_month_amount_bd);
            $ninth_month_amount_bd_show=CommonHelper::bd_money_format_wod($ninth_month_amount_bd);
            $twelve_month_amount_bd_show=CommonHelper::bd_money_format_wod($twelve_month_amount_bd);
            
        }
        

        $international_content =
                    '<div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="first_month_in" value="'.$first_month_amount_in.'" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> '.$first_month_amount_in_show .' ('.Lang::get('messages.Expense of one kid for one month').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="third_month_in" value="'.$third_month_amount_in.'" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> '.$third_month_amount_in_show .' ('.Lang::get('messages.Expense of one kid for three months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="six_month_in" value="'.$sixth_month_amount_in.'" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> '.$sixth_month_amount_in_show .' ('.Lang::get('messages.Expense of one kid for six months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" id="nine_month_in" value="'.$ninth_month_amount_in.'" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> '.$ninth_month_amount_in_show .' ('.Lang::get('messages.Expense of one kid for nine months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" id="twelve_month_in" value="'.$twelve_month_amount_in.'" class="usd_radio_scholarship"  onclick="usd_scholarship_load()"><span class="in-currency">USD</span> '.$twelve_month_amount_in_show .' ('.Lang::get('messages.Expense of one kid for one year').')</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input name="amount" id="custom_usd_r_scholarship" value="'.$usd_min_donate_amount.'"
                               type="radio" onclick="custom_usd_scholarship_load('.$usd_min_donate_amount.')" />
                               <input class="custom_amount" id="custom_usd_scholarship" type="number" name="custom_amount" placeholder="'.Lang::get('messages.Custom Amount').'" min="'.$usd_min_donate_amount.'" max="'.$usd_max_donate_amount.'" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                       </div>
                    </div>';

        $bd_content =
                    '<div class="row">
                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" value="'.$first_month_amount_bd.'" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> '.$first_month_amount_bd_show .' ('.Lang::get('messages.Expense of one kid for one month').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" value="'.$third_month_amount_bd.'" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> '.$third_month_amount_bd_show .' ('.Lang::get('messages.Expense of one kid for three months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" value="'.$sixth_month_amount_bd.'" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> '.$sixth_month_amount_bd_show .' ('.Lang::get('messages.Expense of one kid for six months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" name="amount" value="'.$ninth_month_amount_bd.'" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> '.$ninth_month_amount_bd_show .' ('.Lang::get('messages.Expense of one kid for nine months').')</label>
                       </div>

                       <div class="col-md-6">
                          <label class="radio-inline">
                              <input type="radio" checked name="amount" value="'.$twelve_month_amount_bd.'" class="bdt_radio_scholarship"  onclick="bdt_scholarship_load()"><span class="bd-currency">৳</span> '.$twelve_month_amount_bd_show .' ('.Lang::get('messages.Expense of one kid for one year').')</label>
                       </div>
                       <div class="col-md-6">
                          <label class="radio-inline" style="display: block">
                               <input name="amount" id="custom_bdt_r_scholarship" value="'.$bdt_min_donate_amount.'"
                               type="radio" onclick="custom_bdt_scholarship_load('.$bdt_min_donate_amount.')" />
                               <input class="custom_amount" id="custom_bdt_scholarship" type="number" name="custom_amount" placeholder="'.Lang::get('messages.Custom Amount').'" min="'.$bdt_min_donate_amount.'" max="'.$bdt_max_donate_amount.'" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                       </div>
                    </div>';

        //return $international_content;
        $v_result=array(
            'international_content'=>$international_content,
            'bd_content'=>$bd_content
        );
        return Response::json($v_result);
    }

    public function projectAmount(Request $request)
    {
        $currency_bdt = Currency::where('currency_code', 'BDT')->first();
        $currency_usd = Currency::where('currency_code', 'USD')->first();
        $project_amounts = Donation_Amount::where(['project_id' => $request->id,'general_donation' => 0])->get();
        $payment_options = '';
        $amount_options = '';
        $custom_options = '';
        $placeholder = Lang::get('messages.Custom Amount');
        if ($request->currency === 'BDT') {
            $on_click='class="bdt_radio_project"  onclick="bdt_project_load()"';
            $currency_icon = '৳';
            $custom_options = '<div class="col-md-6">
                            <label class="radio-inline" style="display: block">
                                <input name="amount" id="custom_bdt_r_project" value="'.$currency_bdt->min_donate_amount.'" type="radio" onclick="custom_bdt_project_load('.$currency_bdt->min_donate_amount.')" />
                                <input type="number" id="custom_bdt_project"
                                       name="custom_amount"
                                       min="'.$currency_bdt->min_donate_amount.'"
                                       max="'.$currency_bdt->max_donate_amount.'"
                                       class="custom_amount"
                                       placeholder="'.$placeholder.'" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                            </label>
                        </div>';

        } else {
            $on_click='class="usd_radio_project"  onclick="usd_project_load()"';
            $currency_icon = 'USD';
            $custom_options = '<div class="col-md-6">
                            <label class="radio-inline" style="display: block">
                                <input name="amount" id="custom_usd_r_project" value="'.$currency_usd->min_donate_amount.'" type="radio" onclick="custom_usd_project_load('.$currency_usd->min_donate_amount.')" />
                                <input type="number" id="custom_usd_project"
                                       name="custom_amount"
                                       min="'.$currency_usd->min_donate_amount.'"
                                       max="'.$currency_usd->max_donate_amount.'"
                                       class="custom_amount"
                                       placeholder="'.$placeholder.'" onkeyup="custom_amount_check(this)" onchange="custom_amount_check(this)">
                            </label>
                        </div>';
        }

        if (request()->cookie('locale') == 'bn') {
            /*Bangla lang*/
            if($request->currency=='BDT')
            {
                foreach ($project_amounts as $project_amount) {
                    $amount_options .= '<div class="col-md-' . $project_amount->column . '">
                                        <label class="radio-inline">
                                        <input name="amount" checked  value="' . $project_amount->amount . '" type="radio" '.$on_click.' /><span class="bd-currency">
                                        ' . $currency_icon . '
                                        </span>
                                        ' . CommonHelper::en2bnNumber(CommonHelper::bd_money_format_wod($project_amount->amount)) . ' (' . $project_amount->bn_description . ' )
                                        </label>
                                    </div>';
                }
            }
            else
            {
                foreach ($project_amounts as $project_amount) {
                    $amount_options .= '<div class="col-md-' . $project_amount->column . '">
                                        <label class="radio-inline">
                                        <input name="amount" checked  value="' . ceil($project_amount->amount/$currency_usd->tk_convert_amount) . '" type="radio" '.$on_click.' /><span class="bd-currency">
                                        ' . $currency_icon . '
                                        </span>
                                        ' . CommonHelper::en2bnNumber(number_format(ceil($project_amount->amount/$currency_usd->tk_convert_amount))) . ' (' . $project_amount->bn_description . ' )
                                        </label>
                                    </div>';
                }
            }
        } else {
            /*English Lang*/
            if($request->currency=='BDT')
            {
                foreach ($project_amounts as $project_amount) {
                $amount_options .= '<div class="col-md-' . $project_amount->column . '">
                                        <label class="radio-inline">
                                        <input name="amount" checked  value="' . $project_amount->amount . '" type="radio" '.$on_click.' /><span class="in-currency">
                                        ' . $currency_icon . '
                                        </span>
                                        ' . CommonHelper::bd_money_format_wod($project_amount->amount) . ' (' . $project_amount->description . ' )
                                        </label>
                                    </div>';
                }
            }
            else
            {
                foreach ($project_amounts as $project_amount) {
                $amount_options .= '<div class="col-md-' . $project_amount->column . '">
                                        <label class="radio-inline">
                                        <input name="amount" checked  value="' . ceil($project_amount->amount/$currency_usd->tk_convert_amount) . '" type="radio" '.$on_click.' /><span class="in-currency">
                                        ' . $currency_icon . '
                                        </span>
                                        ' . number_format(ceil($project_amount->amount/$currency_usd->tk_convert_amount)) . ' (' . $project_amount->description . ' )
                                        </label>
                                    </div>';
                }
            }
            
        }
        $payment_options = $amount_options . $custom_options;
        //return $payment_options;
        return Response::json($payment_options);
    }

    public function campaign()
    {
        $campaigns = Campaign::withCount('images')
            ->where(['website_id' => 1, 'is_show' => 1])
            ->orderby('serial_no')
            ->paginate(9);
        if (\request()->ajax()) {
            $view = view('website.about.campaign_data', compact('campaigns'))->render();
            return response()->json(['html' => $view]);
        }
        return view('website.about.campaign', compact('campaigns'));
    }

    public function campaignDetails($id)
    {
        $data = [];
        $campaign = Campaign::withCount('images')
            ->where(['website_id' => 1, 'is_show' => 1])
            ->find($id);
        $campaignImages = Campaign_Images::whereCampaignId($campaign->id)->orderBy('serial_no')->paginate(12);
        if (\request()->ajax()) {
            $view = view('website.about.data', compact('campaignImages'))->render();
            return response()->json(['html' => $view]);
        }

        if (\request()->cookie('locale') == 'bn') {
            $data['date'] = CommonHelper::en2bnNumber(CommonHelper::humanRedableDate($campaign->date)) or null;
            $data['title'] = $campaign->bn_title or null;
            $data['description'] = $campaign->bn_description;
            $data['total_photos'] = CommonHelper::en2bnNumber($campaign->images_count ) or null;
        } else {
            $data['date'] = CommonHelper::humanRedableDate($campaign->date);
            $data['title'] = $campaign->title or null;
            $data['description'] = $campaign->description;
            $data['total_photos'] = $campaign->images_count or null;
        }

        return view('website.about.campaign_details',compact('campaign','campaignImages','data'));
    }

    public function about()
    {
        if (request()->cookie('locale') == 'bn') {
            return view('website.about.about_us_bn');
        } else {
            return view('website.about.about_us');
        }

    }

    public function contact()
    {
        //$contacts = Contact::where('is_show', 1)->get();
        return view('website.about.contact');
    }

    public function branch()
    {
        $branches = Contact::all();
        return view('website.about.branch', compact('branches'));
    }

    public function contactStore(Requests\ContactRequest $request)
    {
        $data = $request->except('g-recaptcha-response');
        $data['created_ip_address'] = CommonHelper::getRealIpAddr();

        //send verification mail to user
        //---------------------------------------------------------
        /* Mail::send('emails.contact_request', ['data' => $data], function ($message) use ($data) {
             $contact = Contact::first();
             $message->to($data['email'])->from($contact->email_1, 'Bidiyanodo ' . $contact->name)->subject($data['subject']);
         });*/

        Contact_message::create($data);
        Session::flash('message', Lang::get('messages.Send successfully'));
        return redirect()->back();
    }

    public function faq()
    {
        $faqs = FAQ::whereNotNull('answer')->where('website_id', '1')->get();
        return view('website.about.faq', compact('faqs'));
    }

    public function faqStore(Requests\FaqStoreRequest $request)
    {
        $data['question'] = $request->question;
        FAQ::create($data);
        Session::flash('message', Lang::get('messages.Send successfully'));
        return redirect()->back();
    }

    public function gallery()
    {
        $gallery_categories = Gallery_Category::has('galleries')->where('website_id', '1')->orderBy('serial_no')->get();
        $galleries = Gallery::whereHas('gallery_category', function ($query) {
            $query->where('website_id', '1');
        })->orderBy('id', 'desc')->get(['id', 'gallery_category_id', 'gallery_image', 'gallery_big_image']);
        return view('website.about.gallery', compact('galleries', 'gallery_categories'));
    }

    public function videoGallery()
    {
        $videos_lists = Video_Category::has('videos')->where('website_id', '1')->orderBy('serial_no', 'asc')->get();
        return view('website.about.video', compact('videos_lists'));
    }

    public function videoCategory($id)
    {
        $category_name = '';
        if (request()->cookie('locale') == 'bn') {
            $category_name = Video_Category::where(['id' => $id, 'website_id' => '1'])->first()->bn_name;
        } else {
            $category_name = Video_Category::where(['id' => $id, 'website_id' => '1'])->first()->name;
        }


        $videos = Video::whereHas('video_category', function ($query) use ($id) {
            $query->where(['id' => $id, 'website_id' => '1']);
        })->get();
        return view('website.about.video_list', compact('videos', 'category_name'));
    }

    public function press($id = null)
    {
        $press_category_title = '';
        $press_categories = Press_Category::where('website_id', '1')->orderBy('serial_no')->get()->take(4);
        $categories_id = $press_categories->pluck('id');
        if (!empty($id)) {
            $presses = Press::whereHas('press_category', function ($category) use ($id) {
                $category->where(['id' => $id, 'website_id' => '1']);
            })
                ->orderby('serial_no')
                ->get();
            if (request()->cookie('locale') == 'bn') {
                $press_category_title = Press_Category::where(['id' => $id, 'website_id' => '1'])->first()->bn_name;
            } else {
                $press_category_title = Press_Category::where(['id' => $id, 'website_id' => '1'])->first()->name;
            }

        } else {
            $presses = Press::whereHas('press_category', function ($category) use ($id, $categories_id) {
                $category->where('website_id', '1')->whereIn('id', $categories_id);
            })
                ->orderby('serial_no')
                ->get();
        }
        return view('website.about.press', compact('press_categories', 'presses', 'press_category_title'));
    }

    public function donation()
    {
        $sectors = Sector::where('website_id', '1')->where('is_show', '1')->orderBy('serial_no', 'asc')->get(['id', 'name', 'bn_name']);
        $payment_methods = Payment_Method::orderby('serial_no')
            ->get(['id', 'name', 'bn_name']);
        $currency_lists = Currency::orderBy('serial_no', 'asc')->get(['id', 'currency_name', 'currency_code']);

        $accounts = Account::where('website_id', '1')->get(['id', 'name', 'bn_name', 'type']);

        return view('website.about.donation', compact('sectors', 'payment_methods', 'currency_lists', 'accounts'));
    }

    public function donateStore(Requests\DonationRequest $request)
    {
        $currency = Currency::find($request->currency_id);
        if ($request->amount < $currency->min_donate_amount) {
            Session::flash('message', Lang::get('messages.Minimum Donate amount is ') . $currency->min_donate_amount . ' ' . $currency->currency_name . ' (' . $currency->currency_code . ')');
            return redirect()->back();
        }


        $v_mail_sent = 0;
        $data = $request->except('g-recaptcha-response', 'date');


        $data['tk_convert_amount'] = $currency->tk_convert_amount;
        $data['tk_amount'] = $currency->tk_convert_amount * $request->amount;

        $data['created_ip_address'] = CommonHelper::getRealIpAddr();
        $data['date'] = CommonHelper::databseDateTimeFormatWithCurrentTime($request->date);
        //$user_id = Auth::id();
        $user = User::where('email', $request->donor_email)
            ->where('is_verified', 1)
            ->first();
        if (isset($user->id)) {
            $user_id = $user->id;
        } else {
            $user_id = 0;
        }

        if ($user_id > 0) {
            $data['is_verified'] = 1;
            $data['user_id'] = $user_id;
        } else {
            $user = User::where('email', $request->donor_email)->first();
            $verify_token = str_random(40);
            if (empty($user)) {
                //......new user.....
                $v_mail_sent = 1;


                $data['verify_token'] = $verify_token;
                $data['is_verified'] = 0;

                $v_password = mt_rand(100000, 999999);
                $id_card = time() . '-' . rand(1, 100);

                $user = new User;
                $user->email = $request->donor_email;
                $user->name = $request->donor_name;
                $user->id_card = $id_card;
                $user->verify_token = $verify_token;
                $user->password = bcrypt($v_password);
                $user->user_level = "1";
                $user->type = "Employee";
                $user->save();
            } else {
                if ($user->is_verified == 1) {
                    //......previous user verified user.....
                    $data['is_verified'] = 1;
                    //$data['user_id'] = $user->id;
                } elseif ($user->is_verified == 0) {
                    //......previous not verified user.....
                    $v_mail_sent = 1;

                    $v_password = mt_rand(100000, 999999);

                    $user->password = bcrypt($v_password);
                    $user->save();

                    $data['verify_token'] = $verify_token;
                    $data['is_verified'] = 0;

                }
            }
            $data['user_id'] = $user->id;

        }
        $inbox = Inbox::create($data);


        //.........upload image if exist start.........
        $database_image_path = null;
        $user_id = $inbox->id;
        $database_image_folder_path = 'uploads/inboxes/';
        if ($request->hasFile('attachment')) {
            $file_image = $request->file('attachment');
            $image_name = $user_id . '-' . time() . '.' . $file_image->getClientOriginalExtension();
            $file_image->move($database_image_folder_path, $image_name);
            $database_image_path = $database_image_folder_path . $image_name;
        }

        $inbox->attachment = $database_image_path;
        $inbox->save();
        //.........upload image if exist end.........


        if ($v_mail_sent == 1) {
            //........send verification mail to user start.......

            Mail::send('emails.donation_verify', ['user' => $user, 'password' => $v_password, 'verify_token' => $verify_token], function ($m) use ($user) {
                $setting = Setting::first();
                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Sign Up Mail Verfication from Bidyanondo!');
            });

            Session::flash('message', Lang::get('messages.Successfully saved! An email is send to your email. Verify your email.'));
            //........send verification mail to user end.......

        } else {
            Session::flash('message', Lang::get('messages.Send successfully'));
        }


        return redirect()->back();

    }

    public function donateVerify($user_id, $token)
    {
        $verifyUser = Inbox::where(['verify_token' => $token, 'is_verified' => 0])->first();
        if (isset($verifyUser)) {
            $verifyUser->verify_token = null;
            $verifyUser->is_verified = 1;
            $verifyUser->save();

            $user = User::where(['id' => $user_id, 'is_verified' => 0])->first();
            $user->verify_token = null;
            $user->is_verified = 1;
            $user->save();

        }

        Session::flash('message', Lang::get('messages.Your email is verified successfully. Please Sign In'));
        return redirect('/signin');

    }

    public function donationInfo()
    {
        return view('website.about.donation_info');
    }


    public function inbox_form_submit_check(Request $request)
    {
        $v_result = array('check' => 1);
        //echo "string";die();
        $amount = $request->amount;

        $currency = Currency::find($request->currency_id);

        if ($amount < $currency->min_donate_amount) {
            $v_result = array('check' => 2,
                'min_donate_amount' => $currency->min_donate_amount,
                'currency_name' => $currency->currency_name,
                'currency_code' => $currency->currency_code,
                'msg' => Lang::get('messages.Minimum donation amount is ')
            );
        }

        return Response::json($v_result);
        //return $v_result;

    }

    public function payment_success()
    {

        $projects = Project::where('is_show', 1)
            ->where('is_home', 1)
            ->where('is_project', 1)
            ->orderby('serial_no')
            ->skip(0)->take(6)->get();
        $students = Student::where(['is_website' => 1, 'is_scholarship' => 2])
            ->orderby('id', 'desc')
            ->skip(0)->take(12)
            ->get();
        $ssl_id = Session::get('ssl_id');
        $paypal_id = Session::get('paypal_id');
        //$ssl_id='231';
        if ($ssl_id > 0) {
            $payment = Ssl_Payment::find($ssl_id);
        }

        if ($paypal_id > 0) {
            $payment = Paypal_Payment::find($paypal_id);
        }

        return view('website.payment_success', compact('payment', 'ssl_id', 'paypal_id', 'projects', 'students'));

    }

    public function ssl_donation_confirmation(Request $request)
    {
        //dd($request->all());
        if ($request->custom_amount) {
            $total_amount = trim($request->custom_amount);
        } else {
            $total_amount = trim($request->amount);
        }

        $user_id = $request->user_id;
        $comments = $request->comments;
        $project_id = $request->project_id;
        $student_id = $request->student_id;
        $donate_way = $request->donate_way;

        return view('website.ssl_donation_confirmation', compact('total_amount', 'user_id', 'comments', 'project_id', 'student_id', 'donate_way'));
    }

    public function donation_receipt($type, $id, $website_id = 1)
    {
        if ($type == 1) {
            $payment = DB::SELECT("SELECT d.id,d.`donate_date`,d.`amount`,c.currency_name,i.donor_message,s.name as sector_name,s.bn_name as bn_sector_name,p.name as project_name,p.bn_name as bn_project_name,u.name as donor_name,u.email 
                FROM `donations` d
                inner join inboxes i on(i.id=d.inbox_id)
                left join sectors s on(s.id=i.sector_id)
                left join projects p on(p.id=s.project_id)
                left join currencies c on(c.id=d.currency_id)
                left join users u on(u.id=d.user_id)
                WHERE d.`inbox_id`='$id'
                and d.`deleted_at` is null
                and i.`deleted_at` is null")[0];
        } else if ($type == 2) {
            $payment = Paypal_Payment::find($id);
        } else if ($type == 3) {
            $payment = Ssl_Payment::find($id);
        }

        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'payment' => $payment,
            'type' => $type
        ];
        $mergeData = [];

        if ($website_id == '2') {
            $pdf = PDF::loadView('website.payments.payment_receipt_one_tk', $data, $mergeData, $config);
        } else {
            $pdf = PDF::loadView('website.payments.payment_receipt', $data, $mergeData, $config);
        }

        //return $pdf->stream('Receipt_' . $id . '.pdf');
        return $pdf->download('Receipt_' . $id . '.pdf');

    }

    public function donation_scholarship_receipt($id)
    {
        $config = [
            'mode' => 'bn',
            'default_font_size' => '12',
            'default_font' => 'solaimanlipi',
        ];
        $data = [
            'id' => $id,
            'inbox_id' => 1
        ];
        $mergeData = [];
        $pdf = PDF::loadView('website.payments.scholarship_payment_receipt', $data, $mergeData, $config);
        //return $pdf->stream('Receipt_' . $id . '.pdf');
        return $pdf->download('Receipt_' . $id . '.pdf');

    }

    //..............Subscriber start.............
    public function subscriber_store(Requests\SubscriberRequest $request)
    {
        $email=$request->email;

        $subscriber=Subscriber::where('email',$email)->first();
        if(empty($subscriber))
        {
            $subscriber = Subscriber::create([
                'email' => $email,
                'verify_token' => str_random(40)
            ]);
        }
        else
        {
            if($subscriber->is_verified==1)
            {
                $v_result = array(
                    'status' => '1',
                    'message'=>Lang::get('messages.Successfully Subscribed')
                );
                return Response::json($v_result);
            }

        }

        $user=User::where('email',$email)->where('is_verified','1')->first();
        $subscriber = Subscriber::findOrFail($subscriber->id);
        if(!empty($user))
        {
            $subscriber->is_verified=1;
            $subscriber->verify_token=null;
            $subscriber->save();
            $v_result = array(
                'status' => '1',
                'message'=>Lang::get('messages.Successfully Subscribed')
            );
            return Response::json($v_result);

        }

        Mail::send('emails.verify_subscriber', ['subscriber' => $subscriber], function ($m) use ($subscriber) {

            $setting = Setting::first();

            $m->to($subscriber->email)->from($setting->contact_email, $setting->organization_name)->subject(Lang::get('Subscriber Mail Verfication from Bidyanondo'));
        });

        $com=explode("@",$email);
        $v_url='https://www.'.$com[1];
        //echo $v_url;die();
        $v_result = array(
            'status' => '1',
            'url'=>$v_url,
            'message'=>'<a href='.$v_url.' target="_blank">'.Lang::get('messages.Click here to varify your email').'</a>'
        );
        return Response::json($v_result);
    }

    public function subscriber_e_v($id, $verify_token)
    {
        $subscriber = Subscriber::where(['id' => $id, 'verify_token' => $verify_token])->first();
        if (!empty($subscriber)) {
            $subscriber->is_verified = 1;
            $subscriber->verify_token = null;
            $subscriber->save();
        }
        Session::flash('subscribed', 1);
        return redirect('/');
    }
    //..............Subscriber End.............

    public function clear_route()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        \Artisan::call('route:clear');
        return redirect('/signin');
        /*
        \Artisan::call('route:cache');
        \Artisan::call('optimize');
        \Artisan::call('config:cache');
        */
    }


}