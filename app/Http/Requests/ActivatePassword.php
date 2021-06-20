<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivatePassword extends FormRequest
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
            'password'          => 'required|confirmed|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'ref'               => 'required|alpha_num|min:32|max:32',
            'code'              => 'required|alpha_num|min:32|max:32',
            'otp'               => 'required|digits:6',
        ];
    }
}
