<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PressRequest extends Request
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

           /* 'press_category_id' => 'required',
            'bn_description' => 'required',
            'press_link' => 'required|url',
            'is_video' => 'required',
            'image' => 'sometimes|mimes:jpeg,jpg',*/

            'press_category_id' => 'required|array|min:1',
            'press_category_id.*' => 'required|int',
            'description.*' => 'required',
            'description' => 'required|array|min:1',
            'bn_description' => 'required|array|min:1',
            'bn_description.*' => 'required',
            'press_link' => 'required|array|min:1',
            'press_link.*' => 'required|url',
            'is_video' => 'required|array|min:1',
            'is_video.*' => 'required',
            'image' => 'required|array|min:1',
            'image.*' => 'required|image|mimes:jpeg,jpg'

        ];
    }
}
