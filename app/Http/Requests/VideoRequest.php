<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VideoRequest extends Request
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
            'video_category_id' => 'required|array|min:1',
            'video_category_id.*' => 'required|int',
            'video_link' => 'required|array|min:1',
            'video_link.*' => 'required|url',
            'image' => 'required|array|min:1',
            'image.*' => 'required|image|mimes:jpeg,jpg'
        ];
    }
}
