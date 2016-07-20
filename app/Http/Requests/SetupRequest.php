<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SetupRequest extends Request
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
            'name' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'phone_number' => 'required',
            'email_address' => 'required|email',
            'website' => 'required|url',
            'chamber_of_commerce' => 'required',
            'vat_number' => 'required',
            'bank_account_number' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ];
    }
}
