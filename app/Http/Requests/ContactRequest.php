<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class ContactRequest extends Request
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
            'message' => 'required|max:750',
            'subject' => 'required|max:250',
            'email' => 'required|email|max:250',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.')
        ];
    }
}
