<?php

namespace App\Http\Requests\Refugee;

use App\Http\Requests\Request;

class ProjectStoryRequest extends Request
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
            'sr_project_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'video_link' => 'required_without:images|url',
            'no_of_image' => 'required_without:video_link',
            'images.*' => 'required_without:video_link|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
