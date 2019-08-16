<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SlideRequest extends Request
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
        switch($this->method()) {
            case 'POST' :
                return [
                    'caption_up' => 'required | min: 5 | max : 20',
                    'caption_down' => 'required | min : 5 | max : 25',
                    'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:width=1920,height=570',
                ];
            case 'PATCH' :
                return [
                    'caption_up' => 'required | min: 5 | max : 20',
                    'caption_down' => 'required | min : 5 | max : 25',
                    'image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:width=1920,height=570',
                ];
            default:break;
        }
    }

    //Customize error message
    public function messages()
    {
        return [
            'image.dimensions' => 'The front view width is 1920 and height is 570',
        ];
    }
}
