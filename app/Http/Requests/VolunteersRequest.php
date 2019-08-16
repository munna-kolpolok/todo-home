<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class VolunteersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd(request()->all());
        $rules= [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:volunteers',
            'gender_id' => 'required',
            'contact_no' => 'required',
            'profile_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
        if(request()->volunteer==2){
            $rules= [
                'email' => 'required|email|unique:volunteers',
                'nationality' => 'required',
                'interest' => 'required',
                'address' => 'required',
                'emergency_contact_details' => 'required|sometimes|max:750',
                'biography' => 'required|sometimes|max:750',
                'start_date' => 'required',
                'end_date' => 'required',
                'passport_no' => 'required|unique:volunteers',
                'pasport_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required' => Lang::get('messages.The First Name field is required'),
            'last_name.required' => Lang::get('messages.The Last Name field is required'),
            'email.required' => Lang::get('messages.The email field is required'),
            'contact_no.required' => Lang::get('messages.The contact no field is required'),
            'address.required' => Lang::get('messages.The address field is required'),
            'biography.max' => Lang::get('messages.The maxmimum limit for biography field is 750'),
            'profile_image.required' => Lang::get('messages.The profile image field is required'),
            'profile_image.max' => Lang::get('messages.The maxmimum field size is 1024'),
            'profile_image.mimes' => Lang::get('messages.The list image extension must be jpeg,jpg,png or gif'),
            'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.')
        ];
    }
}
