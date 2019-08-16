<?php

namespace App\Http\Requests\Refugee;

use App\Http\Requests\Request;

class ProjectStoryTranslationRequest extends Request
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
            'sr_project_story_id' => 'required',
            'lng' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
    }
}
