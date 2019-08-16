<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AharSiteSettingRequest extends Request
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
           /* 'product_banner_caption_up' => 'required | min : 5 | max : 50',
            'product_banner_caption_down' => 'sometimes | min : 4 | max : 50',
            'product_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:width=1920,height=239',
            'logo_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:width=120,height=27',
            'about_image' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000|dimensions:width=720,height=866',
            'about_text' => 'sometimes | max : 1200 | min : 500',
            'top_header_notice' => 'sometimes | max : 60 | min : 10',
            'email' => 'sometimes | email',
            'home_feature_1' => 'sometimes | min :5  | max : 25',
            'home_feature_01_description' => 'sometimes | min :10  | max : 60',
            'home_feature_2' => 'sometimes | min :5  | max : 25',
            'home_feature_02_description' => 'sometimes | min :10  | max : 60',
            'home_feature_3' => 'sometimes | min :5  | max : 25',
            'home_feature_03_description' => 'sometimes | min :10  | max : 60',
            'currency' => 'required',
            'per_dollar_currency' => 'required',*/

            'logo' => 'sometimes|image|mimes:jpeg,jpg,png',
            'favicon' => 'sometimes|image|mimes:jpeg,jpg,png',
            'section_icon' => 'sometimes|image|mimes:jpeg,jpg,png',
            'home_highlighted_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'volunteers_bg_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_us_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'contact_us_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'donor_profile_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'donation_clarification_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'reset_password_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'branch_info_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'forgot_password_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'sign_in_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'sign_up_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'bank_info_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'sponsor_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'package_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'faq_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'gallery_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'press_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'video_album_header' => 'sometimes|image|mimes:jpeg,jpg,png',
            'video_list_header'=> 'sometimes|image|mimes:jpeg,jpg,png',
        ];
    }

    //Customize error message
    public function messages()
    {
        return [
            'product_banner_image.dimensions' => 'The front view width is 1920 and height is 239',
            'logo_image.dimensions' => 'The front view width is 120 and height is 27',
            'about_image.dimensions' => 'The front view width is 720 and height is 866',
        ];
    }
}
