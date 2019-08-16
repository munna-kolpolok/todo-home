<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class DonationAmountRequest extends Request
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
            'amount' => 'required|numeric|min:1',
            'bn_description' => 'required'
        ];
    }


}
