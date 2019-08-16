<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectImageRequest extends Request
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
            /*'project_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',
            'project_big_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',
            'student_poster_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',*/
        ];

    }

    public function messages()
    {
        return [
            /*'project_image.dimensions' => 'The Project image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'project_big_image.dimensions' => 'The project poster image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'project_background_image.dimensions' => 'The project top image width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',*/
        ];
    }
}
