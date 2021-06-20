<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContractRequest extends FormRequest
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
            'contract_name'               => 'required',
            'contract_item'               => 'required',
            'amount'                      => 'required',
            'product'                     => 'required',
            'recipient'                   => 'required',
            'period'                      => 'required',
            'fee_percent'                 => 'required',
            'interest_rate_percent'       => 'required',
            'fee_amount'                  => 'required',
            'mountly_install_amount'      => 'required',
            'total_amount'                => 'required',
            'contract_start_date'         => 'required',
            'first_payment_date'          => 'required',
            'address'                     => 'required',
            'Province'                    => 'required',
            'District'                    => 'required',
            'Sub_District'                => 'required',
            'Zipcode'                     => 'required',
            'Country'                     => 'required'
        ];
    }

    public function messages()
    {
        return [
            // 'contract_no.required'     => 'The contract_no field is required.',
        ];
    }
}
