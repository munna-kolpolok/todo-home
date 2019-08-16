<?php

namespace App\Http\Controllers\Website;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Mail;

class SocialAuthController extends Controller
{
    //Dynamic social service
    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service)
    {
        $socialUser = Socialite::with($service)->user();
        $socialUserEmail = $socialUser->email;
        //find user
        $user = \App\User::where('email', $socialUserEmail)->first();
        if (!empty($user)) {
            //matching existing user
            if ($user->is_verified == 0) {
                $user->is_verified = 1;
                $user->verify_token = null;
                $user->save();
            }

        } else {
            //create user
            $v_password=mt_rand(100000, 999999);
            $data['name'] = !empty($socialUser->name) ? $socialUser->name : $socialUserEmail;
            $data['email'] = $socialUserEmail;
            $data['id_card'] = time() . '-' . rand(1, 100);
            $data['password'] = bcrypt($v_password);
            $data['user_level'] = 1;
            $data['is_verified'] = 1;
            $user = User::create($data);
            
            Mail::send('emails.social_signup_password_notify', ['email' => $user->email, 'password' =>  $v_password], function ($m) use ($user) {
                $setting = Setting::first();
                $m->to($user->email, $user->name)->from($setting->contact_email, $setting->organization_name)->subject('Registration complete from Bidyanondo!');
            });
        }

        if(\Auth::loginUsingId($user->id)){
            return Redirect::to('/donors');
        }
    }
}
