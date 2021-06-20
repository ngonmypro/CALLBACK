<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpSettingBankAcc extends FormRequest
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
            'corp_code'                 =>  'required_if:setting_enable,ON|alpha_num',
            'setting_enable'            =>  'alpha|max:3',
            'bank_name'                 =>  'required_if:setting_enable,ON|min:1|max:100',
            'acc_no'                    =>  'required_if:setting_enable,ON|digits_between:10,20',
            'acc_name'                  =>  'required_if:setting_enable,ON|min:1|max:100',
            'acc_type'                  =>  'required_if:setting_enable,ON|min:1|max:50',
            'day_of_month'              =>  'required_if:setting_enable,ON|date_format:d',
            'time'                      =>  'required_if:setting_enable,ON|date_format:H:i',
        ];
    }
}
