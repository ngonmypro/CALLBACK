<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualRepaymentBillRequest extends FormRequest
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

    // ([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))
    //'bank_info[name_th]'            => 'required|min:2|max:100|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',

    public function rules()
    {
        return [
            'customer_code'            => 'required',
            'reference_code'           => 'required',
            'transaction_date'         => 'required|date_format:d/m/Y',
            'transaction_time'         => 'required|date_format:H:i',
            'from_name'                => 'required',
            // 'amount'                   => 'required|numeric',
            'transaction_id'           => 'required',
            'from_bank'                => 'nullable',
            'account_no'               => 'nullable|numeric',
            'ref_1'                    => 'nullable',
            'ref_2'                    => 'nullable',
            'ref_3'                    => 'nullable',
            'remarks'                  => 'nullable',
            'payment_channel'          => 'required|max:50',
            'file'                     => 'nullable|file',
        ];
    }
}
