<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineOAForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }
    public function __construct()
    {
        $this->validator = app('validator');

        $this->validateCitizenID($this->validator);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'citizen_id'   =>  'required|digits:13|citizen_checked',
            'otp' => 'required|digits:6|numeric',
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
}
