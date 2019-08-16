<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectRequest extends Request
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

            'name' => 'required',
            'bn_name' => 'required',
            /*'bn_name' => 'required',*/
            'project_image' => 'sometimes|image|mimes:jpeg,jpg|max:250',
            'project_big_image' => 'sometimes|image|mimes:jpeg,jpg|max:250',
            //'project_background_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',
        ];
    }

    //Customize error message
   /* public function messages()
    {
        return [
            'project_image.dimensions' => 'The project image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'project_big_image.dimensions' => 'The project poster image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'project_background_image.dimensions' => 'The project top image width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
        ];
    }*/
}
