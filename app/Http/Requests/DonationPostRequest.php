<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class DonationPostRequest extends Request
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
            'date' => 'required',
            'sector_id' => 'required',
            'currency_id' => 'required',
            'payment_method_id' => 'required',
            'amount' => 'required',
            'attachment' => 'sometimes|max:1024|mimes:jpg,jpeg,png,pdf',
        ];
    }

    public function messages()
    {
        return [
            'attachment.max' => Lang::get('messages.Maximum file size is 1 MB.'),
            'attachment.mimes' => Lang::get('messages.File must be jpg,jpeg,png,pdf,txt format'),
        ];
    }
}
