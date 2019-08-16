<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VolunteerStoreUpdateRequest extends Request
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
            'email' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'biography' => 'sometimes|max:750',
            'block_image' => 'image|mimes:jpeg,jpg,png,gif',
        ];
    }

    public function messages()
    {
        return [
            'block_image.mimes' => 'The image extension must be jpeg,jpg,png or gif ',
        ];
    }
}
