<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisaregisCreate extends FormRequest
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
            'corporate_name_th'                          => 'required|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'corporate_name_en'                          => 'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'corporate_first_name_th'                    => 'required|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'corporate_last_name_th'                     => 'required|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'corporate_first_name_en'                    => 'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'corporate_last_name_en'                     => 'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            'corporate_number'                           => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:15',
            'corporate_telephone'                        => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:10',
            'corporate_address'                          => 'required|max:255',
            'corporate_select_province'                  => 'required',
            'corporate_select_district'                  => 'required',
            'corporate_select_sub_district'              => 'required',
            'corporate_email'                            => 'required|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*,\s*)?(\s*$)?)){1,2})$/',
            'operate_firstname'                        => 'required',
            'operate_surname'                          => 'required',
            'operate_telephone'                        => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:10',
            'operate_email'                             => 'required|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*,\s*)?(\s*$)?)){1,2})$/',
            'corporate_bank_name'                        => 'required',
            'corporate_bank_branch'                      => 'nullable',
            'corporate_account_number'                   => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            'corporate_account_name'                     => 'required',
            'corporate_website'                          => 'nullable',
            'corporate_product_type'                     => 'required',
            'corporate_policy'                           => 'required',
            'corporate_item_month'                      => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            'corporate_median_month'                    => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            'corporate_trade_name'                                => 'required',
            'normal_trade_name'                                => 'required',
            'telephone'                                => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:10',
            'normal_first_name_th'                     => 'required|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'normal_last_name_th'                      => 'required|regex:/^[^\s][^A-Za-z][ก-๙0-9\s().\W]+$/i',
            'normal_telephone'                         => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:10',
            'normal_select_province'                   => 'required',
            'normal_select_district'                   => 'required',
            'normal_select_sub_district'               => 'required',
            'normal_bank_name'                         => 'required',
            'normal_bank_branch'                       => 'nullable',
            'normal_account_number'                    => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            'normal_account_name'                      => 'required',
            'normal_website'                           => 'nullable',
            'normal_product_type'                      => 'required',
            'normal_policy'                            => 'required',
            'identification_number'                    => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/|max:13',  
            'normal_email'                             => 'required|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*,\s*)?(\s*$)?)){1,2})$/',
            'normal_item_month'                      => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            'normal_median_month'                    => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
            // 'normal_first_name_en'                     => 'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
            // 'normal_last_name_en'                      => 'required|regex:/^[^\s][^ก-๙][A-Za-z0-9\s().\W]+$/i',
        ];
    }
    // 'telephone' => [
    //     'regex' => 'เบอร์โทรศัพท์ไม่ถูกต้องตามรูปแบบ',
    //     'numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
    //     'digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 8 ถึง 20 หลักเท่านั้น',
    // ],
    public function messages()
    {
        return [
            'corporate_name_th.required'     => 'จำเป็นต้องระบุข้อมูล ชื่อบริษัท (ไทย)',
            'corporate_name_th.regex'     => 'ข้อมูล ชื่อบริษัท (ไทย) ไม่ถูกต้องตามรูปแบบที่กำหนด',   

            'corporate_name_en.required' =>  'จำเป็นต้องระบุข้อมูล ชื่อบริษัท (อังกฤษ)',
            'corporate_name_en.regex'     => 'ข้อมูล ชื่อบริษัท (อังกฤษ) ไม่ถูกต้องตามรูปแบบที่กำหนด',   

            'corporate_number.required' =>  'จำเป็นต้องระบุข้อมูล หมายเลขจดทะเบียนบริษัท',
            'corporate_number.regex' =>  'ข้อมูล หมายเลขจดทะเบียนบริษัท ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'corporate_telephone.required'   => 'จำเป็นต้องระบุข้อมูล หมายเลขโทรศัพท์',
            'corporate_telephone.regex'   => 'ข้อมูล หมายเลขโทรศัพท์ ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'corporate_address.required' => 'จำเป็นต้องระบุข้อมูล ที่อยู่ตามทะเบียนบริษัท',

            'corporate_select_province.required' =>  'จำเป็นต้องระบุข้อมูล จังหวัด',
            'corporate_select_district.required' =>  'จำเป็นต้องระบุข้อมูล อำเภอ / เขต',
            'corporate_select_sub_district.required'   => 'จำเป็นต้องระบุข้อมูล ตำบล / แขวง ',

            'corporate_email.required'   => 'จำเป็นต้องระบุข้อมูล อีเมล',
            'corporate_email.regex'   => 'ข้อมูล อีเมล ไม่ถูกต้องตามรูปแบบที่กำหนด',
            

            'operate_firstname.required' => 'จำเป็นต้องระบุข้อมูล ชื่อ',
            'operate_surname.required' =>  'จำเป็นต้องระบุข้อมูล นามสกุล',
            
            'operate_telephone.required' =>  'จำเป็นต้องระบุข้อมูล หมายเลขโทรศัพท์',
            'operate_telephone.regex'   =>  'ข้อมูล หมายเลขโทรศัพท์ ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'operate_email.required' => 'จำเป็นต้องระบุข้อมูล อีเมล',
            'operate_email.regex' => 'ข้อมูล อีเมล ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'corporate_bank_name.required'   => 'จำเป็นต้องระบุข้อมูล ธนาคาร',
            'corporate_account_number.required'   => 'จำเป็นต้องระบุข้อมูล หมายเลขบัญชี',
            'corporate_account_number.regex' =>  'ข้อมูล หมายเลขบัญชี ไม่ถูกต้องตามรูปแบบที่กำหนด',
            'corporate_account_name.required'   => 'จำเป็นต้องระบุข้อมูล ชื่อบัญชี',
            'corporate_trade_name.required'   => 'จำเป็นต้องระบุข้อมูล ชื่อร้านค้า',
            'corporate_product_type.required'   => 'จำเป็นต้องระบุข้อมูล ประเภทของสินค้า/บริการ',
            'corporate_policy.required'   => 'จำเป็นต้องระบุข้อมูล นโยบายการคืนเงิน',

            'corporate_item_month.required'   => 'จำเป็นต้องระบุข้อมูล จำนวนรายการต่อเดือน',
            'corporate_item_month.regex'   => 'ข้อมูล จำนวนรายการต่อเดือน ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'corporate_median_month.required'   => 'จำเป็นต้องระบุข้อมูล ยอดเงินโดยเฉลี่ยต่อรายการ',
            'corporate_median_month.regex'  =>  'ข้อมูล ยอดเงินโดยเฉลี่ยต่อรายการ ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'telephone.required'        => 'จำเป็นต้องระบุข้อมูล หมายเลขโทรศัพท์',
            'telephone.regex'        => 'ข้อมูล หมายเลขโทรศัพท์ ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'corporate_first_name_th.required'   => 'จำเป็นต้องระบุข้อมูล ชื่อ (ไทย)',
            'corporate_first_name_th.regex'   => 'ข้อมูล ชื่อ (ไทย) ไม่ถูกต้องตามรูปแบบที่กำหนด',
            
            'corporate_last_name_th.required'   => 'จำเป็นต้องระบุข้อมูล นามสกุล (ไทย)',
            'corporate_last_name_th.regex'   => 'ข้อมูล นามสกุล (ไทย) ไม่ถูกต้องตามรูปแบบที่กำหนด',

            
            'normal_first_name_th.required'   => 'จำเป็นต้องระบุข้อมูล ชื่อ (ไทย)',
            'normal_first_name_th.regex'   => 'ข้อมูล ชื่อ (ไทย) ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'normal_last_name_th.required'   => 'จำเป็นต้องระบุข้อมูล นามสกุล (ไทย)',
            'normal_last_name_th.regex'   => 'ข้อมูล นามสกุล (ไทย) ไม่ถูกต้องตามรูปแบบที่กำหนด',
            

            'identification_number.required' => 'จำเป็นต้องระบุข้อมูล หมายเลขประจำตัวประชาชน',
            'identification_number.regex' => 'ข้อมูล หมายเลขประจำตัวประชาชน ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'normal_telephone.required'  => 'จำเป็นต้องระบุข้อมูล หมายเลขโทรศัพท์',
            'normal_telephone.regex' => 'ข้อมูล หมายเลขโทรศัพท์ ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'normal_email.required'   => 'จำเป็นต้องระบุข้อมูล อีเมล',
            'normal_email.regex'   => 'ข้อมูล อีเมล ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'normal_select_province.required'  => 'จำเป็นต้องระบุข้อมูล จังหวัด',
            'normal_select_district.required'  => 'จำเป็นต้องระบุข้อมูล อำเภอ / เขต',
            'normal_select_sub_district.required'  => 'จำเป็นต้องระบุข้อมูล ตำบล / แขวง',


            'normal_bank_name.required'      => 'จำเป็นต้องระบุข้อมูล ธนาคาร',

            'normal_account_number.required' => 'จำเป็นต้องระบุข้อมูล หมายเลขบัญชี',
            'normal_account_number.regex' =>  'ข้อมูล หมายเลขบัญชี ไม่ถูกต้องตามรูปแบบที่กำหนด',

            'normal_account_name.required'   => 'จำเป็นต้องระบุข้อมูล ชื่อบัญชี',
            'normal_trade_name.required' => 'จำเป็นต้องระบุข้อมูล ชื่อร้านค้า',
            'normal_product_type.required'      => 'จำเป็นต้องระบุข้อมูล ประเภทของสินค้า/บริการ',
            'normal_policy.required' => 'จำเป็นต้องระบุข้อมูล นโยบายการคืนเงิน',

            'normal_item_month.required'   => 'จำเป็นต้องระบุข้อมูล จำนวนรายการต่อเดือน',
            'normal_item_month.regex'   => 'ข้อมูล จำนวนรายการต่อเดือน ไม่ถูกต้องตามรูปแบบที่กำหนด',


            'normal_median_month.required' => 'จำเป็นต้องระบุข้อมูล ยอดเงินโดยเฉลี่ยต่อรายการ',
            'normal_median_month.regex' => 'ข้อมูล ยอดเงินโดยเฉลี่ยต่อรายการ ไม่ถูกต้องตามรูปแบบที่กำหนด',
            
        ];
    }
}
