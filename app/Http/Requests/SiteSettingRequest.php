<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SiteSettingRequest extends Request
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
            //'organization_name' => 'required',
            'logo' => 'sometimes|image|mimes:jpeg,jpg',
            'favicon' => 'sometimes|image|mimes:jpeg,jpg',
            'about_video_poster_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'sign_in_image' => 'sometimes|image|mimes:jpeg,jpg',
            'sign_up_image' => 'sometimes|image|mimes:jpeg,jpg',
            'contact_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'faq_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'payment_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'press_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'bank_info_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'gallery_background_image' => 'sometimes|image|mimes:jpeg,jpg',
            'video_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'volunteer_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'signup_donor_image' => 'sometimes|image|mimes:jpeg,jpg',
            'cover_project_image' => 'sometimes|image|mimes:jpeg,jpg,png',
            'scholarship_thumbnail_image' => 'sometimes|image|mimes:jpeg,jpg',
            'donate_poster_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_work_image' => 'sometimes|image|mimes:jpeg,jpg',
            'about_story_image' => 'sometimes|image|mimes:jpeg,jpg',
            'branch_info_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'donation_form_bg_image' => 'sometimes|image|mimes:jpeg,jpg',
            'volunteers_form_bg_image' => 'sometimes|image|mimes:jpeg,jpg',
            'help_us_image' => 'sometimes|image|mimes:jpeg,jpg',
            'home_volunteer_image' => 'sometimes|image|mimes:jpeg,jpg',
            'subscribe_image' => 'sometimes|image|mimes:jpeg,jpg',
            'campaign_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
            'campaign_details_banner_image' => 'sometimes|image|mimes:jpeg,jpg',
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
