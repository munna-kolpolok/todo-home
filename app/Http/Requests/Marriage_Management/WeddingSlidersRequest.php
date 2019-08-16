<?php

namespace App\Http\Requests\Marriage_Management;

use App\Http\Requests\Request;

class WeddingSlidersRequest extends Request
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
        $rules = [
            'title' => 'required',
            'bn_title' => 'required',
            'subtitle' => 'required|min:10|max:100',
            'bn_subtitle' => 'required|min:10|max:100',
            'description_up' => 'required|min:50|max:400',
            'bn_description_up' => 'required|min:50|max:400',
            'description_down' => 'required|min:50|max:400',
            'bn_description_down' => 'required|min:50|max:400',
            'button_label' => 'required|max:25',
            'bn_button_label' => 'required|max:25',
            'button_link' => 'required|url',
            'button_color' => 'required',
            'is_show' => 'required',
        ];
        if ($this->method() == 'POST') {
            $rules['image'] = 'required|image|mimes:jpeg,jpg|max:10000|dimensions:width=1220,height=844';
        } else {
            $rules['image'] = 'sometimes|image|mimes:jpeg,jpg|max:10000|dimensions:width=1220,height=844';
        }
        return $rules;
    }
}
