<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpSettingLoanSchedule extends FormRequest
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
            'corp_code'                 => 'required|alpha_num',
            'billing_date'              => 'required|numeric|min:1|max:27',
            'due_date'                  => 'required|numeric|min:1|max:30',
            'grace_period_1st'          => 'required|numeric|min:1|max:30|gt:due_date',
            'grace_period_2nd'          => 'nullable|numeric|min:1|max:30|gt:grace_period_1st',
            'fee_type'                  => 'required|alpha',
            'fee_rate'                  => 'required|numeric',
        ];
    }
}
