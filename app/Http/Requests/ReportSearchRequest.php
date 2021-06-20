<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSearchRequest extends FormRequest
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
            'report_type'       => 'required',
            'date_range'        => 'required_without_all:start_month,end_month',
            'start_month'       => 'required_without:date_range|date_format:m/Y',  
            'end_month'         => 'required_without:date_range|date_format:m/Y',  
            'criteria'          => 'required|in:daily,monthly'
        ];
    }
}
