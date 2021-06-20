<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpSettingPDFTemplate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'template_name'                         => 'required|max:50|regex:/^([-\.\w]+)$/',
            'document_type'                         => 'required',
            'max_record'                            => 'required|numeric|max:30',
            'file'                                  => 'required_without:reference',
        ];
    }
}
