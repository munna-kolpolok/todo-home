<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class ResetPasswordRequest extends Request
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
            'old_password' => 'required',
            'password' => 'required|confirmed|regex:/^[0-9]{6,}$/',
            'g-recaptcha-response' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.'),
            'password.confirmed' => Lang::get('messages.Password and re-type password must be same.'),
            'password.regex'=> Lang::get('messages.Password length is minimum 6 and only number is allowed'),
            'password.required' => Lang::get('messages.Password should be required'),
        ];
    }
}
