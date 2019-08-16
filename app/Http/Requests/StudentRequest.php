<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudentRequest extends Request
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
            'id_card' => 'required|max:150|unique:students,id,'.\request()->segment(3),
            'name' => 'required',
            'bn_name' => 'required',
            'dob' => 'required',
            'gender_id' => 'required',
            'is_father' => 'required',
            'is_mother' => 'required',
            'scholarship_amount' => 'required',
            /*'student_image' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',
            'student_smile_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',
            'student_poster_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=320,max_width=2000,min_height=690,max_height=2000',*/
        ];
    }

    //Customize error message
  /*  public function messages()
    {
        return [
            'student_image.dimensions' => 'The Student image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'student_smile_image.dimensions' => 'The Student smile image minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'student_poster_image.dimensions' => 'The student poster image width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
        ];
    }*/
}
