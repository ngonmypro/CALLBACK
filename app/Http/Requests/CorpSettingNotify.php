<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorpSettingNotify extends FormRequest
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
            'input.sms.*.sms_sender_name'    => 'required_if:input.sms.*.enable,on'
        ];
    }
}

// "input": {
//     "sms": {
//       "mail_bit": {
//         "enable": "on",
//         "sms_sender_name": "",
//         "sms_message": "{AGENT_NAME} 555 ja"
//       }
//     },
//     "email": {
//       "enable": "on",
//       "mailgun": {
//         "enable": "on",
//         "email_from": "fff@gmail.com",
//         "domain": "asfafa.com",
//         "api_key": ""
//       },
//       "template": "on"
//     }
//   },
//   "template": {
//     "INVOICE": {
//       "subject": "e-Invoice for :",
//       "data": ""
//     },
//     "RECEIPT": {
//       "subject": "Thankyou for your payment :",
//       "data": ""
//     }
//   },
//   "files": ""
