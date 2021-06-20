<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpleCreateBillRequest extends FormRequest
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
            'recipient_code'                        => 'nullable',
            'recipient_name'                        => 'required',
            'recipient_lastname'                    => 'nullable',
            'recipient_telephone'                   => 'required|numeric|digits:10',
            'payment_channel'                       => 'required',
            'send_bill_type'                        => 'required',
            'send_bill_schedule'                    => 'required_if:send_bill_type,schedule',
            'recipient_email'                       => 'required|email',
            'recipient_additional_telephone'        => 'nullable|regex:/^((\d{1,})?(\d{1,}(,\d{1,}){1,1})?)$/',
            'recipient_additional_email'            => 'nullable|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*,\s*)?(\s*$)?)){1,2})$/',
            'invoice_number'                        => 'required',
            'bill_due_date'                         => 'nullable|date_format:d/m/Y',
            'branch_name'                           => 'nullable|regex:/^[^\s][0-9]+$/|digits:5',                                            // default: '00000'
            'currency'                              => 'nullable|in:THB,MYR',                                          // default: 'THB'
            'product_name.*'                        => 'required',
            'product_price_per_unit.*'              => 'required|numeric',
            'product_qty.*'                         => 'required|numeric',
            'item_discount.*'                       => 'nullable|numeric',                  // default: 0
            'item_fee.*'                            => 'nullable|numeric',                  // default: 0
            'bill_discount'                         => 'nullable|numeric',                  // default: 0
            'bill_fee'                              => 'nullable|numeric',                  // default: 0
            'tax_percentage'                        => 'nullable|numeric',                  // default: 0
            'batch_name'                            => 'nullable',
            'address'                               => 'required',
        ];
    }
}
