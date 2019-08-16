<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CampaignRequest extends Request
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
        $rules =  [
            'title' => 'required',
            'website_id' => 'required',
            'is_home' => 'required',
            'is_show' => 'required',
        ];
        if (\request()->method() == 'PATCH') {
            $rules['cover_image'] = 'sometimes|image|mimes:jpeg,jpg|max:2000';
        } else {
            $rules['cover_image'] = 'required|image|mimes:jpeg,jpg|max:2000';
        }
        return $rules;
    }
}
