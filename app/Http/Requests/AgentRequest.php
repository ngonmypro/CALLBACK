<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
            'bank_info[name_th]'            => 'required|min:2|max:100|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',
            'bank_info[name_en]'            => 'required|min:2|max:100|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'admin[firstname_th]'           => 'required|max:100|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',
            'admin[lastname_th]'            => 'required|max:100|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',
            'admin[firstname_en]'           => 'required|max:100|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'admin[lastname_en]'            => 'required|max:100|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'admin[email]'                  => 'required|email',
            'admin[telephone]'              => 'required|numeric|digits_between:8,20',
            // 'admin[citizen_id]'             => 'required|numeric|digits_between:8,20|regex:/^[^\s().\W][^A-Za-z][^ก-๙][0-9]+$/i'
        ];
    }
}
