<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SrSlidersRequest extends Request
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
       // dd(request()->all());
        return [
            'image' => 'image|mimes:jpeg,jpg,png|max:10000',
            'title' => 'required',
            'sub_title' => 'required',
            'description_up' => 'required',
            'description_down' => 'required',

        ];
    }
}
