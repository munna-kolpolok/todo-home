<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class Food_ProjectsRequest extends Request
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
            'name' => 'required',
            'bn_name' => 'required',
            'descrcription' => 'sometimes|max:750',
            'bn_descrcription' => 'sometimes|max:750',
            'image' => 'image|max:1024|mimes:jpeg,jpg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => Lang::get('messages.The Name field is required'),
            'bn_name.required' => Lang::get('messages.The bangla name field is required'),
            'descrcription.max' => Lang::get('messages.The maxmimum limit for bangla descrcription field is 750'),
            'bn_descrcription.max' => Lang::get('messages.The maxmimum limit for biography field is 750'),
            'image.mimes' => Lang::get('messages.The list image extension must be jpeg,jpg,png or gif'),
        ];
    }
}
