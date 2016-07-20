<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TimesheetRequest extends Request
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
            'description' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'required|regex:/\d{2}:\d{2}/',
            'end_time' => 'required|regex:/\d{2}:\d{2}/'
        ];
    }
}
