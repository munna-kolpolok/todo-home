<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PressUpdateRequest extends Request
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
            'press_category_id' => 'required|int',
            'description' => 'required',
            'bn_description' => 'required',
            'press_link' => 'required|url',
            'is_video' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,jpg'
        ];
    }
}
