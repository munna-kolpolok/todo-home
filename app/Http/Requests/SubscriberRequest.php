<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class SubscriberRequest extends Request
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
            'email' => 'required|email|max:250'
        ];
    }

    public function messages()
    {
        return [
            
            'email.required' => Lang::get('messages.email address is required'),
        ];
    }
}
