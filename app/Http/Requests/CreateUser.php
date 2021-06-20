<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
      * add function validate Citizenid to validator

     */
    public function __construct()
    {
        $this->validator = app('validator');

        // $this->validateCitizenID($this->validator);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'          	=>  'required|min:5|max:50|alpha_num',
            'email'                 =>  'required|email',
            // 'citizen_id'        	=>  'nullable|numeric|digits:13|regex:/^[^\s().\W][^A-Za-z][^ก-๙][0-9]+$/i|citizen_checked',
            // 'citizen_id'            =>  'nullable|numeric|digits_between:12,13',
            'telephone'         	=>  'required|numeric|digits_between:8,20',
            'firstname_en'         	=>  'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'lastname_en'          	=>  'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'firstname_th'         	=>  'nullable|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'lastname_th'          	=>  'nullable|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            
            'corp_code'             =>  'alpha_num',
            'agent_code'          	=>  'nullable|alpha_num',
            'roles'                 =>  'required|nullable|array',
            'roles.*'               =>  'required|alpha_num',
            'rd_workflow'           =>  'nullable|array',
            'rd_workflow.*'         =>  'alpha_num'
        ];
    }
    public function validateCitizenID($validator)
    {
        $validator->extend('citizen_checked', function ($attribute, $value) {
            if (strlen($value) != 13 || is_null($value)) {
                return false;
            }
            $digits = str_split($value);
            $tail = array_pop($digits);
            $sum = array_sum(array_map(function ($x, $y) {
                return ($y + 2) * $x;
            }, array_reverse($digits), array_keys($digits)));
            return $tail === strval((11 - $sum % 11) % 10);
        });
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
