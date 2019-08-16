<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudentImageRequest extends Request
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
            'student_image' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=360,max_width=2000,min_height=300,max_height=2000',
        ];




    }

    public function messages()
    {
        return [
            'student_image.dimensions' => 'The student image minimum width is 360 and maximum width is 2000.Minimum height is 300 and maximum height is 2000'
        ];
    }
}
