<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
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
            'user_id'          	    =>  'required|alpha_num|max:50',
            'username'          	=>  'required',
            // 'citizen_id'            =>  'nullable|numeric|digits_between:12,13',
            'telephone'             =>  'required|numeric|digits_between:8,20',
            'firstname_en'         	=>  'required',
            'lastname_en'          	=>  'required',
            'firstname_th'         	=>  'nullable',
            'lastname_th'          	=>  'nullable',
            
            'corp_code'          	=>  'nullable|array',
            'corp_code.*'           =>  'alpha_num',
            'roles'                 =>  'nullable|array',
            'roles.*'               =>  'alpha_num'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'first_nameTH.required'     => 'The Recipient Name (TH) field is required.',
    //         'last_nameTH.required'      => 'The Recipient lastname (TH) field is required.',
    //         'first_nameEN.required'     => 'The Recipient Name (EN) field is required.',
    //         'last_nameEN.required'      => 'The Recipient lastname (EN) field is required.',
    //         'Citizen.required'          => 'The Citizen ID field is required.',
    //         'mobile_number.required'    => 'The Mobile no. field is required.',
    //         // 'career.required'           => 'The Career field is required.',
    //         // 'salary.required'           => 'The Salary field is required.',
    //         'AddressTH.required'        => 'The Address (TH) field is required.',
    //         'AddressEN.required'        => 'The Address (EN) field is required.',
    //         'Province.required'         => 'The Province field is required.',
    //         'District.required'         => 'The District field is required.',
    //         'Sub_District.required'     => 'The Sub District field is required.',
    //         'Zipcode.required'          => 'The Post Code field is required.',
    //         'Country.required'          => 'The Country field is required.',
    //         'check_email.required_without_all'    => 'select at least one notification channel.',
    //         'check_sms.required_without_all'      => 'select at least one notification channel.',
    //         // 'check_line.required_without_all'     => 'select at least one notification channel.',
    //     ];
    // }
}
