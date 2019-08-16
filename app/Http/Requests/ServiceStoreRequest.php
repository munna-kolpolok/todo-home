<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class ServiceStoreRequest extends Request
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
            'file.*' => 'sometimes|mimes:jpg,jpeg,png,bmp,pdf,txt,doc,docx,xls,xlxs,csv|max:2048'
        ];
    }

    public function messages()
    {
       return [
        'file.*.mimes' => 'Only jpg,jpeg,png,bmp,pdf,txt,doc,docx,xls,xlxs,csv are allowed',
        'file.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
          
       ];
    }
}
