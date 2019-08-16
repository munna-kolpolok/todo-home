<?php

namespace App\Http\Requests\Marriage_Management;

use App\Http\Requests\Request;
use Lang;
class WeddingUpdateRequest extends Request
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
            'groom_name'=> 'required',
            'bn_groom_name'=> 'required',
            'bride_name'=> 'required',
            'bn_bride_name'=> 'required',
            'groom_email' => 'required|email',
            'bride_email' => 'required|email',
            'marriage_venue'=> 'required',
            'bn_marriage_venue'=> 'required',
            'message'=> 'required',
            'bn_message' => 'required',
            'contact_no' => 'required',
            'profile'=> 'required',
            'marriage_date'=> 'required',
            'from'=> 'required',
            'to'=> 'required',
            'groom_image' => 'sometimes|mimes:jpg,jpeg',
            'bride_image' => 'sometimes|mimes:jpg,jpeg',
            'card_image' => 'sometimes|mimes:jpg,jpeg',
        ];
    }

    public function messages()
    {
       return [
           'groom_image.max' => Lang::get('messages.Maximum file size is 1 MB.'),
           'groom_image.mimes' => Lang::get('messages.File must be jpg,jpeg format'),
           'bride_image.max' => Lang::get('messages.Maximum file size is 1 MB.'),
           'bride_image.mimes' => Lang::get('messages.File must be jpg,jpeg format'),
           'card_image.max' => Lang::get('messages.Maximum file size is 1 MB.'),
           'card_image.mimes' => Lang::get('messages.File must be jpg,jpeg format'),
       ];
    }
}
