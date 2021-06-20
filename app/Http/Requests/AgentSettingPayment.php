<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentSettingPayment extends FormRequest
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
            'name'         =>  'required',
            'type'         =>  'required',
            'provider'     =>  'required',
            'status'       =>  'required',
            
            'app_id'    => 'required',
            'user_type'    => 'required',
            'permission'            => 'required|array',
            'permission.*'          => 'required|alpha_num',


            //Payment
            'channel_name'      => 'required',
            'channel_type'      => 'required',
            'merchant_name'     => 'required',
            // 'mid'               => 'required',
            // 'biller_id'         => 'required',
            'landing_path'      => 'required',
            'payment_url'       => 'required',
            'notify_url'        => 'required',
        ];




      
    }
}
