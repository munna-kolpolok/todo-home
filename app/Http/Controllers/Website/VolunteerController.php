<?php

namespace App\Http\Controllers\Website;

use App\Helpers\CommonHelper;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Volunteer;
use App\Models\Gender;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Lang;
use Image;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $volunteers = Volunteer::latest()->take(8)->get();
        // $setting = Setting::first();
        // return view('website.volunteers.index', compact('setting', 'volunteers'));

        $contacts = Contact::where('is_volunteer','1')->orderBy('name')->get(['id', 'name','bn_name']);

        $genders = Gender::get(['id', 'gender_name','gender_bn_name']);
        return view('website.volunteers.create', compact('contacts','genders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registration()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\VolunteersRequest $request)
    {
        ////dd($request->all());
        $data = $request->except('g-recaptcha-response', 'profile_image','pasport_image','dob','start_date','end_date','passport_no','nationality','contact_id');
        $data['dob'] = !is_null($request->dob) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->dob))) : '';
        $data['start_date'] = !is_null($request->start_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date))) : '';
        $data['end_date'] = !is_null($request->end_date) ? date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date))) : '';
        if($request->volunteer==2){
            /*Check volunteer Type international*/
            $data['passport_no'] =  $request->passport_no;
            $data['nationality'] =  $request->nationality;

        }else{
            $data['nationality'] =  $request->nationality;
            $data['contact_id'] =  $request->contact_id;
        }
        $data['website_id'] = 1;
        $data['created_ip_address'] = CommonHelper::getRealIpAddr();
        $volunteer = Volunteer::create($data);
        //.........upload image if exist start.........
        $database_image_path = null;
        $volunteer_id = $volunteer->id;
        $path = public_path() . '/uploads/volunteers/' . $volunteer_id;
        $database_image_folder_path = '/uploads/volunteers/' . $volunteer_id;

        if (!File::exists($path)) {
            $volunteer_upload_directory = File::makeDirectory($path, 0777, true, true);

            if ($volunteer_upload_directory == true) {
                if ($request->hasFile('profile_image')) {
                    $volunteer_profile_image = $request->file('profile_image');
                    $profile_image_name = '/profile_image.' . $volunteer_profile_image->getClientOriginalExtension();
                    $volunteer_profile_path_image = $path . $profile_image_name;

                    Image::make($volunteer_profile_image->getRealPath())->resize(160, 160)->save($volunteer_profile_path_image);
                    $database_profile_image_path = $database_image_folder_path . $profile_image_name;
                    $volunteer->profile_image = $database_profile_image_path;
                    $volunteer->save();
                }
                if ($request->hasFile('pasport_image')) {
                    $volunteer_pasport_image = $request->file('pasport_image');
                    $pp_image_name = '/pasport_image.' . $volunteer_pasport_image->getClientOriginalExtension();
                    $volunteer_path_pp_image = $path . $pp_image_name;

                    Image::make($volunteer_pasport_image->getRealPath())->resize(345, 352)->save($volunteer_path_pp_image);

                    $database_image_path = $database_image_folder_path . $pp_image_name;
                    $volunteer->pasport_image = $database_image_path;
                    $volunteer->save();
                }
            }
        }

        /*--------Mail Sending Start*/
        Mail::send('emails.volunteers_reg_email', ['volunteer' => $volunteer], function ($m) use ($volunteer) {
            $setting = Setting::first();

            $m->to($volunteer->email, $volunteer->first_name.' '.$volunteer->last_name)->from($setting->contact_email, $setting->organization_name)->subject('Volunteer Registration Mail from Bidyanondo!');


        });
        /*-----// Mail sending ---------*/
        //.........upload image if exist end.........
        Session::flash('message', Lang::get('messages.Thank You').$volunteer->name.', '. Lang::get('messages.You are successfully registerd! our team will contact with you.'));
        //return redirect()->back();
        return redirect('/volunteer/registration');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $volunteer = Volunteer::find($id);
        $setting = Setting::first();
        if(isset($volunteer->id))
        {
            $volunteers = Volunteer::whereNotIn('id', [$volunteer->id])
                ->orderby('id','desc')
                ->skip(0)->take(7)
                ->get(['id','name','profile_image']);
        }
        else {
            $volunteers = null;
        }

        return view('website.volunteers.show', compact('setting', 'volunteer', 'volunteers'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
