<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemSettingRequest extends FormRequest
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
            "item_name"                 => ['required','max:150'],
            "item_code"                 => ['max:50'],
            "item_qty"                  => ["regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"],
            "item_amount"               => ["required","regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"],
            // "item_vat"                  => ["regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"],
            // "item_fee"                  => ["regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"],
            // "item_discount"             => ["regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"],
            // "item_net_amount"           => ["required","regex:/^(\d+(\.\d{0,2})?|\.?\d{1,2})$/"]

            // 'item[0]' => [
            //     'item_code' => 'max:3',
            // ],
            // 'item.0.item_code' => 'required|numeric|min:1',
        ];
    }
}
