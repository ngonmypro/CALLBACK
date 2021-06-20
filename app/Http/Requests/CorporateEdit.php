<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporateEdit extends FormRequest
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
            'company_name_th'       =>  'required|min:4|max:150|regex:/^[^\s][ก-๙่เ0-9\s().\W]+$/i',
            'company_name_en'       =>  'required|min:4|max:150|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'tax_id'                =>  'required|digits:13|regex:/^[^\s][0-9]+$/',
            'branch_code'           =>  'required|digits:5|regex:/^[^\s][0-9]+$/',
            'select_province'       =>  'required',
            'select_district'       =>  'required',
            'select_sub_district'   =>  'required',
            'select_zipcode'        =>  'required',
            'contract'              =>  'max:80',
            // 'house_no'              =>  'required|max:16|regex:/^[^\s][0-9\-\/]+$/',
            'house_no'              =>  'required|max:16',
            'contract'              =>  'max:80',
            'building'              =>  'max:70',
            'lane'                  =>  'max:70',
            'village'               =>  'max:70',
            'village_no'            =>  'max:70',
            'road'                  =>  'max:70'
        ];
    }
}
