<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BAACProductEditRequest extends FormRequest
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
            'catalogue'       => 'required',
            'product_type'    => 'required',
            'name'            => 'required',
            'images'          => 'nullable',
            'price'           => 'required',
            'unit'            => 'required',
            'description'     => 'nullable',
            'short_desc'      => 'nullable',
            'expired_at'      => 'nullable',
        ];
    }
}
