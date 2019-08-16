<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductImageRequest extends Request
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
            'project_image' => 'sometimes|image|mimes:jpeg,jpg|max:250',
            'project_big_image' => 'sometimes|image|mimes:jpeg,jpg|max:250',
            //'image_7' => 'same:image_5',
        ];

        


    }

    public function messages()
    {
        return [

        ];
    }
}
