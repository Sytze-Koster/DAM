<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingsCompanyRequest extends Request
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
            'invoice_template' => 'required',
            'effective_date' => 'required|regex:/\d{2}-\d{2}-\d{4}\s\d{2}:\d{2}/'
        ];
    }
}
