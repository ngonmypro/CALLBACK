<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillInvoiceCreate extends FormRequest
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
            'batch_name'                 => 'max:200',
            'batch_description'          => 'max:200',
            'invoice_number'             => 'required',
            'currency'                   => 'required',
            'recipient_code'             => 'required',
            'bill_amount'                => 'regex:/^\d+(\.\d{1,2})?$/',
            'bill_discount'              => 'regex:/^\d+(\.\d{1,2})?$/',
            'bill_fee'                   => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'net_amount'                 => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_vat'                   => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_total_vat_amount'      => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_total_amount'          => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'bill_due_date'              => 'required',
            
            'ref_1'                      => 'nullable|max:50',
            'ref_2'                      => 'nullable|max:50',
            
            'bill_payment_item.0.item_name'             => 'required|max:100',
            'bill_payment_item.0.item_qty'              => 'required',
            'bill_payment_item.0.item_vat'	            => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_payment_item.0.item_fee'              => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_payment_item.0.item_amount'           => 'regex:/^\d+(\.\d{1,2})?$/',
            'bill_payment_item.0.item_discount'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'bill_payment_item.0.item_total_amount'     => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    public function messages()
    {
        return [
            // 'contract_no.required'     => 'The contract_no field is required.',
        ];
    }
}
