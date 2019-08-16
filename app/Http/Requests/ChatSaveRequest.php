<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class ChatSaveRequest extends Request
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
            'inbox_id' => 'required',
            'comment_attachment' => 'sometimes|max:1024|mimes:jpg,jpeg,png,pdf',
        ];
    }

    public function messages()
    {
       return [
           'inbox_id.required' => Lang::get('messages.The is is required.'),
           'comment_attachment.max' => Lang::get('messages.Maximum file size is 1 MB.'),
           'comment_attachment.mimes' => Lang::get('messages.File must be doc,docx,pdf,txt,jpg,jpeg,png,xls,xlxs,csv format'),
       ];
    }
}
