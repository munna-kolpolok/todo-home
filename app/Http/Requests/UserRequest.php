<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
        switch($this->method()) {
            case 'POST' :
                return [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6',
                    'user_level' => 'required',
                    'id_card' => 'sometimes|unique:users',
                ];
            case 'PUT' :
                return [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'sometimes|min:6',
                    'user_level' => 'required',
                ];
            default:break;
        }

    }
}
