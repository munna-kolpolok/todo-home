<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends Request
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
            
            'product_date' => 'required',
            'group_id' => 'required|integer',
            'category_id' => 'integer',
            'product_name' => 'required|string',
            'unit_id' => 'required|integer',
            'price' => 'required',
            'image_1' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=720,max_width=2000,min_height=960,max_height=2000',
            'image_2' => 'sometimes|image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=720,max_width=2000,min_height=960,max_height=2000',
            'image_3' => 'sometimes|image|mimes:jpeg,jpg,png,gif|required|max:10000|dimensions:min_width=720,max_width=2000,min_height=960,max_height=2000',
        ];
    }

    //Customize error message
    public function messages()
    {
        return [
            'image_1.dimensions' => 'The front view minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'image_2.dimensions' => 'The back view minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
            'image_3.dimensions' => 'The side view minimum width is 720 and maximum width is 2000.Minimum height is 960 and maximum height is 2000',
        ];
    }

}
