<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends Request
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
            'customerDetail.name' => 'required',
            'customerDetail.address' => 'required',
            'customerDetail.postal_code' => 'required',
            'customerDetail.city' => 'required',
            'customerDetail.chamber_of_commerce' => 'required',
            'customerDetail.vat_number' => 'required',
            'customerDetail.contact_person' => 'required',
            'customerDetail.email_address' => 'required|email',
            'customerDetail.phone_number' => 'required',
            'only_incoming' => 'in:0,1',
            'customerDetail.effective_date' => 'required|date'
        ];
    }
}
