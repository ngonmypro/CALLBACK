<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'ข้อมูล :attribute ต้องมี :digits หลัก.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute ต้องไม่เกิน :max ตัวอักษร.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'ข้อมูล :attribute ต้องมีข้อความอย่างน้อย :min ตัวอักษร',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'ข้อมูล :attribute ไม่ถูกต้องตามรูปแบบที่กำหนด',
    'required'             => 'จำเป็นต้องระบุข้อมูล :attribute',
    'required_if'          => 'จำเป็นต้องระบุ :attribute',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'จำเป็นต้องระบุ :attribute เมื่อค่า :values ถูกระบุ',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'จำเป็นต้องระบุข้อมูล :attribute',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric'          => 'The :attribute must be :size.',
        'file'             => 'The :attribute must be :size kilobytes.',
        'string'           => 'The :attribute must be :size characters.',
        'array'            => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    // 'custom' => [
    //     'attribute-name' => [
    //         'rule-name' => 'custom-message',
    //     ],
    // ],

    'custom' => [
        'tax_id' => [
            'digits' => 'เลขประจำตัวผู้เสียภาษีต้องมี 13 หลัก',
        ],
        'branch_code' => [
            'digits' => 'รหัสหน่วยงานย่อยต้องมี 5 หลัก',
        ],
        'citizen_id' => [
            'citizen_checked' => 'เลขประจำตัวประชาชนไม่ถูกต้องตามรูปแบบ',
        ],
        'telephone' => [
            'regex' => 'เบอร์โทรศัพท์ไม่ถูกต้องตามรูปแบบ',
            'numeric' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น',
            'digits_between' => 'เบอร์โทรศัพท์ต้องเป็นตัวเลข 8 ถึง 20 หลักเท่านั้น',
        ],
        'username' => [
            'email' => ':attribute ไม่ถูกต้องตามรูปแบบ',
        ],
        'first_nameTH' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
           
        ],
        'last_nameTH' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'first_nameEN' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'last_nameEN' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'Citizen' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'mobile_number' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'AddressTH' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'AddressEN' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'Province' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'District' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'Sub_District' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'Zipcode' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'Country' => [
            'required' => 'จำเป็นต้องระบุข้อมูล :attribute',
        ],
        'check_email' => [
            'required_without_all' => 'select at least one notification channel.',
        ],
        'check_sms' => [
            'required_without_all' => 'select at least one notification channel.',
        ],
        'input_invalid' => 'กรุณากรอกข้อมูลให้ถูกต้อง',
        'group_name_th' => [
            'required_if' => 'จำเป็นต้องระบุ :attribute'
        ],
        'group_name_en' => [
            'required_if' => 'จำเป็นต้องระบุ :attribute'
        ],
        'password' => [
            'regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวอักษรภาษาอังกฤษทั้งตัวเล็ก/ใหญ่ ตัวเลข และอักขระพิเศษ (เช่น !@#$%) อย่างน้อยหนึ่งตัว',
        ],
        'input.sms.mail_bit.sms_sender_name'   => [
            'required_if'   => 'จำเป็นต้องระบุ sms sender name เมื่อการตั้งค่าถูกเปิดใช้งาน'
        ],
        'input.sms.infobip.sms_sender_name'   => [
            'required_if'   => 'จำเป็นต้องระบุ sms sender name เมื่อการตั้งค่าถูกเปิดใช้งาน'
        ],
        'start_month'       => [
            'required_without'      => 'จำเป็นต้องระบุ :attribute',
        ],
        'end_month'       => [
            'required_without'      => 'จำเป็นต้องระบุ :attribute',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        /*visaregis*/
        'corporate_name_th' => 'ชื่อบริษัท (ไทย)',
        'corporate_name_en' =>  'ชื่อบริษัท (อังกฤษ)',
        'corporate_number' =>  'หมายเลขจดทะเบียนบริษัท',
        'corporate_telephone'   => 'หมายเลขโทรศัพท์',
        'corporate_address' => 'ที่อยู่ตามทะเบียนบริษัท',
        'corporate_select_province' =>  'จังหวัด',
        'corporate_select_district' =>  'อำเภอ / เขต',
        'corporate_select_sub_district'   => 'ตำบล / แขวง ',
        'corporate_email'   => 'อีเมล',
        'operate_firstname' => 'ชื่อ',
        'operate_surname' =>  'นามสกุล',
        'operate_telephone' =>  'หมายเลขโทรศัพท์',
        'operate_email' => 'อีเมล',
        'corporate_bank_name'   => 'ธนาคาร',
        'corporate_account_number'   => 'หมายเลขบัญชี',
        'corporate_account_name'   => 'ชื่อบัญชี',
        'corporate_trade_name'   => 'ชื่อร้านค้า',
        'corporate_product_type'   => 'ประเภทของสินค้า/บริการ',
        'corporate_policy'   => 'นโยบายการคืนเงิน',
        'corporate_item_month'   => 'จำนวนรายการต่อเดือน',
        'corporate_median_month'   => 'ยอดเงินโดยเฉลี่ยต่อรายการ',
        'corporate_first_name_th'   => 'ชื่อ (ไทย)',
        'corporate_last_name_th'   => 'นามสกุล (ไทย)',

    
        'normal_first_name_th'   => 'ชื่อ (ไทย)',
        'normal_last_name_th'   => 'นามสกุล (ไทย)',
        'normal_first_name_en'  => 'ชื่อ (อังกฤษ)',
        'normal_last_name_en'   => 'นามสกุล (อังกฤษ)',
        'identification_number' => 'หมายเลขประจำตัวประชาชน',
        'normal_telephone'  => 'หมายเลขโทรศัพท์',
        'normal_select_province'  => 'จังหวัด',
        'normal_select_district'  => 'อำเภอ / เขต',
        'normal_select_sub_district'  => 'ตำบล / แขวง',
        'normal_bank_name'      => 'ธนาคาร',
        'normal_account_number' => 'หมายเลขบัญชี',
        'normal_account_name'   => 'ชื่อบัญชี',
        'normal_trade_name' => 'ชื่อร้านค้า',
        'normal_product_type'      => 'ประเภทของสินค้า/บริการ',
        'normal_policy' => 'นโยบายการคืนเงิน',
        'normal_item_month'   => 'จำนวนรายการต่อเดือน',
        'normal_median_month' => 'ยอดเงินโดยเฉลี่ยต่อรายการ',
        'normal_email'   => 'อีเมล',




        /*user management*/
        'citizen_id' => 'เลขบัตรประชาชน',
        'firstname_en' => 'ชื่อจริง (ภาษาอังกฤษ)',
        'lastname_en' => 'นามสกุล (ภาษาอังกฤษ)',
        'firstname_th' => 'ชื่อจริง (ภาษาไทย)',
        'lastname_th' => 'นามสกุล (ภาษาไทย)',
        'username'  => 'ชื่อผู้ใช้งาน',
        'telephone'  => 'เบอร์โทรศัพท์',
        /*create corporate profile*/
        'group_name_th' => 'ชื่อกลุ่มของบริษัท (ภาษาไทย)',
        'group_name_en' => 'ชื่อกลุ่มของบริษัท (ภาษาอังกฤษ)',
        'company_name_th' => 'ชื่อบริษัท (ภาษาไทย)',
        'company_name_en'   => 'ชื่อบริษัท (ภาษาอังกฤษ)',
        'tax_id'    => 'เลขประจำตัวผู้เสียภาษี',
        'branch_code'   => 'รหัสหน่วยงานย่อย',
        'house_no'      => 'บ้านเลขที่',
        'building' => 'ที่ตั้ง',
        'village_no'      => 'หมู่ที่',
        'village'      => 'หมู่บ้าน',
        'lane'      => 'ตรอก / ซอย',
        'road'      => 'ถนน',
        'select_province' => 'จังหวัด',
        'select_district' => 'อำเภอ / เขต',
        'select_sub_district' => 'ตำบล / แขวง',
        'select_zipcode' => 'รหัสไปรษณีย์',
        /*Create corporate add branch modal*/
        'modal_branch_name_th' => 'ชื่อสาขา (ภาษาไทย)',
        'modal_branch_name_en' => 'ชื่อสาขา (ภาษาอังกฤษ)',
        'modal_branch_code' => 'รหัสหน่วยงานย่อย',
        'modal_contact' => 'ข้อมูลการติดต่อ',
        'modal_branch_province' => 'จังหวัด',
        'modal_branch_district' => 'อำเภอ / เขต',
        'modal_branch_sub_district' => 'ตำบล / แขวง',
        'modal_branch_zipcode' => 'รหัสไปรษณีย์',
        'modal_branch_house_no' => 'บ้านเลขที่',
        'modal_branch_building'  =>  'ที่ตั้ง',
        'modal_branch_lane'      =>  'ตรอก / ซอย',
        'modal_branch_village'     =>  'หมู่บ้าน',
        'modal_branch_village_no' =>  'หมู่ที่',
        'modal_branch_road'      =>  'ถนน',
        /*Corporate Setting Fee Charging Account*/
        'bank_name' => 'ธนาคาร',
        'acc_no' => 'เลขบัญชี',
        'acc_name' => 'ชื่อบัญชี',
        'acc_type' => 'ประเภทบัญชี',
        'day_of_month' => 'วันที่เรียกเก็บค่าธรรมเนียม',
        'time' => 'เวลาเรียกเก็บค่าธรรมเนียม',
        /*Create Recipient*/
        'recipient_code'    => 'รหัสอ้างอิงผู้รับ',
        'first_name'        => 'ชื่อ',
        'last_name'         => 'นามสกุล',
        'address'           => 'ที่อยู่',
        'localize'          => 'ประเทศ',

        /*Create Bill*/
        'invoice_number'    => 'เลขใบแจ้งหนี้',
        'currency'          => 'หน่วยเงินตรา',
        'bill_total_amount' => 'จำนวนเงินทั้งหมด',
        'bill_due_date'     =>'กำหนดชำระ',

        'first_nameTH'     => 'Recipient Name (TH)',
        'first_name'     => 'ชื่อ',
        'last_nameTH'      => 'Recipient lastname (TH)',
        'last_name'     => 'นามสกุล',
        'first_nameEN'     => 'Recipient Name (EN)',
        'last_nameEN'      => 'Recipient lastname (EN)',
        'Citizen'          => 'Citizen ID',
        'mobile_number'    => 'Mobile no.',
        'AddressTH'        => 'Address (TH)',
        'AddressEN'        => 'Address (EN)',
        'address'          => 'ที่อยู่',
        'Province'         => 'Province',
        'District'         => 'District',
        'Sub_District'     => 'Sub District',
        'Zipcode'          => 'Post Code',
        'Country'          => 'Country',
        'localize'          => 'ประเทศ',

         /*Bill Detail*/
        'amount'          => 'จำนวนเงิน',
        'from_name'       => 'ผู้ชำระเงิน',
        'transaction_id'  => 'รหัสอ้างอิงการชำระเงิน',
        'remarks'         => 'หมายเหตุ',
        /*Create Bill/Invoice*/
        'bill_payment_item.0.item_name'             => 'ชื่อสินค้า',
        'bill_payment_item.0.item_qty'              => 'จำนวนรายการ',
        'bill_payment_item.0.item_vat'	            => 'Item Total Vat',
        'bill_payment_item.0.item_fee'              => 'Item Total Fee',
        'bill_payment_item.0.item_amount'           => 'Item Amount',
        'bill_payment_item.0.item_discount'         => 'Item Discount',
        'bill_payment_item.0.item_total_amount'     => 'จำนวนเงินทั้งหมดของรายการ',
        'product_price_per_unit.*'                  => 'ราคาต่อหน่วย',
        'product_qty.*'                             => 'จำนวนสินค้า',
        'product_name.*'                            => 'ชื่อสินค้า',
        'branch_name'                               => 'สาขาที่ออกบิล',

        // CORP PAYMENT CHANNEL
        'bank_transfer.*.account_number'            => 'เลขที่บัญชีธนาคาร',
        'bank_transfer.*.account_name'              => 'ชื่อบัญชี',
        'bank_transfer.*.bank_name'                 => 'ชื่อธนาคาร',
        'bank_transfer_enable'                      => 'ปุ่มเปิดใช้งาน',
    ],

];
