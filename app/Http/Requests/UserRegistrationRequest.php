<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class UserRegistrationRequest extends Request
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
        return [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|regex:/^[0-9]{6,}$/',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.'),
            'email.unique' => Lang::get('messages.You are already registered.'),
            'password.required' => Lang::get('messages.Password should be required'),
            'password.regex'=> Lang::get('messages.Password length is minimum 6 and only number is allowed')
        ];
    }
}
