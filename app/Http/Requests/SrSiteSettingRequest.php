<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SrSiteSettingRequest extends Request
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

            'logo' => 'sometimes|image|mimes:jpeg,jpg,png',
            'email_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'contact_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'gallery_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'video_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'transaction_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'faq_banner_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'donate_background_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'counter_background_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'video_background_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_slider_1' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_slider_2' => 'sometimes|image|mimes:jpeg,jpg,png',
            'about_slider_3' => 'sometimes|image|mimes:jpeg,jpg,png',
            'mission_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'mission_content_image_1' => 'sometimes|image|mimes:jpeg,jpg,png',
            'mission_content_image_2' => 'sometimes|image|mimes:jpeg,jpg,png',
            'mission_content_image_3' => 'sometimes|image|mimes:jpeg,jpg,png',
            'mission_content_image_4' => 'sometimes|image|mimes:jpeg,jpg,png',
            'vision_image' => 'sometimes|image|mimes:jpeg,jpg,png',

        ];
    }

    //Customize error message
    public function messages()
    {
        return [
            //'logo_image.dimensions' => 'The front view width is 120 and height is 27',
        ];
    }
}
