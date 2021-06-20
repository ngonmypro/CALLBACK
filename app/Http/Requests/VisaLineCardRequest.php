<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisaLineCardRequest extends FormRequest
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
            'line_id'           => 'required',
            'recipient_code'    => 'required',
            'card_type'         => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'currency'          => 'required',
            'credit_limit'      => 'required'
        ];
    }
}
