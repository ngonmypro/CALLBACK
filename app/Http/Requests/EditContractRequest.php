<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditContractRequest extends FormRequest
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
            'contract_name'               => 'nullable',
            'contract_item'               => 'nullable',
            'amount'                      => 'nullable|numeric|min:1',
            'period'                      => 'nullable|numeric|min:1,max:99',
            'monthly_installment_amount'  => 'nullable|numeric',
            'total_amount'                => 'nullable|numeric',
            'delivery_date'               => 'nullable|date_format:Y-m-d H:i',
            'description'                 => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
