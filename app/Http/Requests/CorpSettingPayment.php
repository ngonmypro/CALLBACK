<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpSettingPayment extends FormRequest
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
            'tmb_qr_sub_biller'                     => 'alphanum|max:4',
            'tmb_qr_fee_rate'                       => 'nullable|numeric|min:0',

            'tmb_credit_mid'                        => 'alphanum|max:4',
            'tmb_credit_api_user_id'                => 'max:20',
            'tmb_credit_api_password'               => 'max:20',
            'tmb_credit_fee_rate'                   => 'nullable|numeric|min:0',

            'scb_qr_biller'                         => 'required_if:scb_qr_enable,on|alphanum|max:20',
            'scb_qr_ref3'                           => 'required_if:scb_qr_enable,on|alphanum|max:20',
            'scb_qr_merchant_name'                  => 'required_if:scb_qr_enable,on|alphanum|max:20',
            'scb_qr_notify_type'                    => 'required_if:scb_qr_enable,on',
            'scb_qr_notify_url'                     => 'required_if:scb_qr_enable,on|max:250',
            'scb_qr_fee_rate'                       => 'nullable|numeric|min:0',

            'scb_credit_mid'                        => 'required_if:scb_credit_enable,on|max:20',
            'scb_credit_tid'                        => 'required_if:scb_credit_enable,on|max:20',
            'scb_credit_fee_rate'                   => 'nullable|numeric|min:0',

            'bank_transfer_enable'                  => 'nullable|in:on',
            'bank_transfer.*.account_name'          => 'required_if:bank_transfer_enable,on|max:50',
            'bank_transfer.*.account_number'        => 'required_with:bank_transfer.*.account_name|max:20',
            'bank_transfer.*.bank_name'             => 'nullable',
        ];
    }
}
