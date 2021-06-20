<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpCustomerFeeRequest extends FormRequest
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
            'corp_code'           => 'required|alpha_num',
            'payment_channel.*'   => 'required|distinct',
            'type.*'              => 'required',
            'value.*'             => 'required|numeric'
        ];
    }
}
