<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class ForgotPasswordRequest extends Request
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
            'email' => 'required | email',
            'g-recaptcha-response' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.')
        ];
    }
}
