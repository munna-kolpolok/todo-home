<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SliderRequest extends Request
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
            'up_title' => 'required | min: 10 | max : 100',
            'down_title' => 'required| min: 10 | max : 100',
            'message' => 'required| min: 10 | max : 500',
            'type' => 'required',
            'image' => 'image|mimes:jpeg,jpg|max:512|dimensions:width=1920,height=870'
        ];
    }
}
