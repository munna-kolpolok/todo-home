<?php

namespace App\Http\Requests\Refugee;

use App\Http\Requests\Request;

class ProjectStoryUpdateRequest extends Request
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
            'video_link' => 'required_without:images|url',
            'images' => 'required_without:video_link|array|min:1',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
