<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorporateBranchEdit extends FormRequest
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
            // 'modal_branch_name_th'      =>  'required|max:150',
            // 'modal_branch_name_en'      =>  'required|max:150|alpha',
            // 'modal_branch_code'         =>  'required|max:5|digits:5',
            // 'modal_address_th'          =>  'required|max:300',
            // 'modal_address_en'          =>  'required|max:300',
            // 'modal_branch_province'     =>  'required',
            // 'modal_branch_district'     =>  'required',
            // 'modal_branch_sub_district' =>  'required',
            // 'modal_branch_zipcode'      =>  'required'
            // 'modal_branch_name_th' => 'required|min:4|max:150|regex:/^[^A-Za-z][ก-๙เ0-9\s\(\)\.\-]+$/i',
            // 'modal_branch_name_en' => 'required|min:4|max:150|regex:/^[A-Za-z0-9\s\(\)\.\-]+$/i',
            'modal_branch_name_th'              => 'required|min:4|max:150|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',
            'modal_branch_name_en'              => 'required|min:4|max:150|regex:/^[A-Za-z0-9\s\(\)\.\-\,]+$/i',
            'modal_branch_code'                 => 'required|digits:5|regex:/^[^\s][0-9]+$/',
            'modal_branch_short_name_en'        => 'required|min:4|max:30|regex:/^[A-Za-z0-9\(\)\.\-\,]+$/i',
            'modal_branch_contract'             => 'max:300|regex:/^[^\s]+$/i',
            'modal_branch_province'             => 'required',
            'modal_branch_district'             => 'required',
            'modal_branch_sub_district'         => 'required',
            'modal_branch_zipcode'              => 'required',
            'modal_branch_house_no'             => 'required|max:16|regex:/^\d+[0-9\-\/]*$/',
            'modal_branch_building'             => 'max:70',
            'modal_branch_lane'                 => 'max:70',
            'modal_branch_village'              => 'max:70',
            'modal_branch_village_no'           => 'max:70',
            'modal_branch_road'                 => 'max:70'
        ];
    }
}
