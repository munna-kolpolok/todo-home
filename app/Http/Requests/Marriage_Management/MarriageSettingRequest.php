<?php

namespace App\Http\Requests\Marriage_Management;

use App\Http\Requests\Request;

class MarriageSettingRequest extends Request
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
            'organization_name' => 'required',
            'contact_no' => 'required',
            'contact_email' => 'required|email',
            'logo' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'contact_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'faq_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'payment_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'contact_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'faq_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_big_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_small_up_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_small_down_image' => 'sometimes|image|mimes:jpeg,jpg',
            'apply_form_bg_image' => 'sometimes|image|mimes:jpeg,jpg',
            'contact_email_image' => 'sometimes|image|mimes:jpeg,jpg',
            'contact_slider_image' => 'sometimes|image|mimes:jpeg,jpg',
        ];
    }
}
