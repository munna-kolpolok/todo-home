<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SrProjectsRequest extends Request
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
            'target' => 'required |integer',
            'video_link' => 'required',
            'is_show' => 'required',
            'is_menu' => 'required',
            'is_home' => 'required',
            'project_image' => 'image|mimes:jpeg,jpg,png|max:10000',

            'name' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',

        ];
    }
}
