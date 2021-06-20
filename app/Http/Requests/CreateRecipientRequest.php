<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecipientRequest extends FormRequest
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
    // 'bank_info[name_th]'            => 'required|min:2|max:100|regex:/^[ก-๙่เ0-9\s\(\)\.\-\,]+$/i',
    

    public function rules()
    {
        return [

            'recipient_code'    => 'max:50|regex:/^[a-zA-Z0-9-_]+S*$/',
       
            'first_name'        => 'required|max:50',
            'last_name'         => 'max:50',
            'middle_name'       => 'nullable|max:50',
         
            'telephone'           => 'required|numeric|digits_between:8,15',
            'optional_telephones' => 'nullable|regex:/^((\d{1,})?(\d{1,}(,\d{1,}){1,1})?)$/',
            'email'             => 'nullable|email',
            'optional_emails'   => 'nullable|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*,\s*)?(\s*$)?)){1,2})$/',
            'contact'           => 'nullable|max:200',
            'career'            => 'nullable|max:50',
            'salary'            => 'nullable|numeric',
            'address'           => 'max:150',
            'state'             => 'nullable|max:50',
            'zipcode'           => 'nullable|numeric|digits:5',
            'localize'          => 'size:2',
            'ref_1'              => 'nullable|max:150',
            'ref_2'              => 'nullable|max:150',
            'ref_3'              => 'nullable|max:150',
            'ref_4'              => 'nullable|max:150',
            'ref_5'              => 'nullable|max:150',
            'noti'               => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            // 'first_nameTH.required'     => 'The Recipient Name (TH) field is required.',
            // 'last_nameTH.required'      => 'The Recipient lastname (TH) field is required.',
            // 'first_nameEN.required'     => 'The Recipient Name (EN) field is required.',
            // 'last_nameEN.required'      => 'The Recipient lastname (EN) field is required.',
            // 'Citizen.required'          => 'The Citizen ID field is required.',
            // 'mobile_number.required'    => 'The Mobile no. field is required.',
            // 'career.required'           => 'The Career field is required.',
            // 'salary.required'           => 'The Salary field is required.',
            // 'AddressTH.required'        => 'The Address (TH) field is required.',
            // 'AddressEN.required'        => 'The Address (EN) field is required.',
            // 'Province.required'         => 'The Province field is required.',
            // 'District.required'         => 'The District field is required.',
            // 'Sub_District.required'     => 'The Sub District field is required.',
            // 'Zipcode.required'          => 'The Post Code field is required.',
            // 'Country.required'          => 'The Country field is required.',
            // 'check_email.required_without_all'    => 'select at least one notification channel.',
            // 'check_sms.required_without_all'      => 'select at least one notification channel.',
            // 'check_line.required_without_all'     => 'select at least one notification channel.',
        ];
    }
}
