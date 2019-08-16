<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class DonationRequest extends Request
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
            'date'=> 'required',
            'donor_email' => 'required|email',
            'sector_id'=> 'required',
            'currency_id' => 'required',
            'payment_method_id' => 'required',

            'amount'=> 'required',
            'attachment' => 'sometimes|max:1024|mimes:jpg,jpeg,png,pdf',
            'g-recaptcha-response' => 'required'
        ];
    }

    public function messages()
    {
       return [
           'g-recaptcha-response.required' => Lang::get('messages.Captcha required or invalid captcha.'),
           'attachment.max' => Lang::get('messages.Maximum file size is 1 MB.'),
           'attachment.mimes' => Lang::get('messages.File must be doc,docx,pdf,txt,jpg,jpeg,png,xls,xlxs,csv format'),
       ];
    }
}
