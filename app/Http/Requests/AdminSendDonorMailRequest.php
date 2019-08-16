<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminSendDonorMailRequest extends Request
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
            'recipient_option' => 'required',
            'template_id' => 'required_if:mail_option,1',
            'subject' => 'required_if:mail_option,2',
            'body' => 'required_if:mail_option,2',
        ];
    }

    public function messages()
    {
        return [
            'subject.required_if' => 'The subject field is required when mail option is Manual.',
            'body.required_if' => 'The body field is required when mail option is Manual.',
            'template_id.required_if' => 'The Mail template field is required when mail option is System.'
        ];
    }
}
