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
    'digits'               => 'The :attribute must be :digits digits.',
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
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
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
        'citizen_id' => [
            'citizen_checked' => 'The Citizen ID is invalid format.',
        ],
        'tax_id' => [
            'digits' => 'Tax id must be 13 digits',
        ],
        'branch_code' => [
            'digits' => 'Unit No. / Branch No. must be 5 digits',
        ],
        'username' => [
            'email' => ':attribute is invalid format.',
        ],
        'first_nameTH' => [
            'required' => 'The Recipient Name (TH) field is required.',
        ],
        'last_nameTH' => [
            'required' => 'The Recipient lastname (TH) field is required.',
        ],
        'first_nameEN' => [
            'required' => 'The Recipient Name (EN) field is required.',
        ],
        'last_nameEN' => [
            'required' => 'The Recipient lastname (EN) field is required.',
        ],
        'Citizen' => [
            'required' => 'The Citizen ID field is required.',
        ],
        'mobile_number' => [
            'required' => 'The Mobile no. field is required.',
        ],
        'AddressTH' => [
            'required' => 'The Address (TH) field is required.',
        ],
        'AddressEN' => [
            'required' => 'The Address (EN) field is required.',
        ],
        'Province' => [
            'required' => 'The Province field is required.',
        ],
        'District' => [
            'required' => 'The District field is required.',
        ],
        'Sub_District' => [
            'required' => 'The Sub District field is required.',
        ],
        'Zipcode' => [
            'required' => 'The Post Code field is required.',
        ],
        'Country' => [
            'required' => 'The Country field is required.',
        ],
        'check_email' => [
            'required_without_all' => 'select at least one notification channel.',
        ],
        'check_sms' => [
            'required_without_all' => 'select at least one notification channel.',
        ],
        'fee.*.min.*' => [
            'regex' => 'The :attribute may not be equal 0. and more than 9999999',
        ],
        'input_invalid' => 'Incorrect data in field (s)',
        'group_name_th' => [
            'required_if' => 'The :attribute field is required.'
        ],
        'group_name_en' => [
            'required_if' => 'The :attribute field is required.'
        ],
        'password' => [
            'regex' => 'รหัสผ่านต้องประกอบไปด้วยตัวอักษรภาษาอังกฤษทั้งตัวเล็ก/ใหญ่ ตัวเลข และอักขระพิเศษ (เช่น !@#$%) อย่างน้อยหนึ่งตัว',
        ],
        'payment_date' => [
            'date_format' => 'The payment date does not match the format YYYY-MM-DD.',
        ],
        'payment_time' => [
            'date_format' => 'The payment time does not match the format HH:MM:SS.',
        ],
        'due_date' => [
            'date_format' => 'The due date does not match the format YYYY-MM-DD.',
        ],
        'input.sms.mail_bit.sms_sender_name'   => [
            'required_if'   => 'The sms sender name field is required when notify setting is `ON`'
        ],
        'input.sms.infobip.sms_sender_name'   => [
            'required_if'   => 'The sms sender name field is required when notify setting is `ON`'
        ],
        'start_month'       => [
            'required_without'      => 'The :attribute field is required.',
        ],
        'end_month'       => [
            'required_without'      => 'The :attribute field is required.',
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
        'citizen_id' => 'Citizen ID',
        'firstname_en' => 'Name (EN)',
        'lastname_en' => 'Lastname (EN)',
        'firstname_th' => 'Name (TH)',
        'lastname_th' => 'Lastname (TH)',
        'username'  => 'Username',
        'telephone'  => 'Mobile no.',
        /*create corporate profile*/
        'group_name_th' => 'Company Group Name (TH)',
        'group_name_en' => 'Company Group Name (EN)',
        'company_name_th' => 'Company name (TH)',
        'company_name_en'   => 'Company name (EN)',
        'tax_id'    => 'Tax ID',
        'branch_code'   => 'Unit No. / Branch No.',
        'house_no'      => 'House No.',
        'building' => 'Building',
        'village_no'      => 'Village No.',
        'village'      => 'Village',
        'lane'      => 'Lane',
        'road'      => 'Road',
        'select_province' => 'Province',
        'select_district' => 'District',
        'select_sub_district' => 'Sub District',
        'select_zipcode' => 'Post Code',
        /*Create corporate add branch modal*/
        'modal_branch_name_th' => 'Branch name (TH)',
        'modal_branch_name_en' => 'Branch name (EN)',
        'modal_branch_code' => 'Unit No. / Branch No.',
        'modal_contact' => 'Contact',
        'modal_branch_province' => 'Province',
        'modal_branch_district' => 'District',
        'modal_branch_sub_district' => 'Sub District',
        'modal_branch_zipcode' => 'Post Code',
        'modal_branch_house_no' => 'House No.',
        'modal_branch_building'  =>  'Building',
        'modal_branch_lane'      =>  'Lane',
        'modal_branch_village'     =>  'Village',
        'modal_branch_village_no' =>  'Village No.',
        'modal_branch_road'      =>  'Road',
        /*Corporate Setting Fee Charging Account*/
        'bank_name' => 'Bank name',
        'acc_no' => 'Account No.',
        'acc_name' => 'Account name',
        'acc_type' => 'Account type',
        'day_of_month' => 'Day of Month',
        'time' => 'Time',
        /*Create Recipient*/
        'recipient_code'   => 'Customer Code',
        'first_nameTH'     => 'Recipient Name (TH)',
        'last_nameTH'      => 'Recipient lastname (TH)',
        'first_nameEN'     => 'Recipient Name (EN)',
        'last_nameEN'      => 'Recipient lastname (EN)',
        'Citizen'          => 'Citizen ID',
        'mobile_number'    => 'Mobile no.',
        'AddressTH'        => 'Address (TH)',
        'AddressEN'        => 'Address (EN)',
        'Province'         => 'Province',
        'District'         => 'District',
        'Sub_District'     => 'Sub District',
        'Zipcode'          => 'Post Code',
        'Country'          => 'Country',
        /*Create Bill/Invoice*/
        'bill_payment_item.0.item_name'             => 'Item Name',
        'bill_payment_item.0.item_qty'              => 'Item Quantity',
        'bill_payment_item.0.item_vat'	            => 'Item Total Vat',
        'bill_payment_item.0.item_fee'              => 'Item Total Fee',
        'bill_payment_item.0.item_amount'           => 'Item Amount',
        'bill_payment_item.0.item_discount'         => 'Item Discount',
        'bill_payment_item.0.item_total_amount'     => 'Item Total Amount',
        'product_price_per_unit.*'                  => 'Price per unit',
        'product_qty.*'                             => 'Quantity',
        'product_name.*'                            => 'Product name',
        'branch_name'                               => 'Branch',

        // CORP PAYMENT CHANNEL
        'bank_transfer.*.account_number'            => 'Account number',
        'bank_transfer.*.account_name'              => 'Account name',
        'bank_transfer.*.bank_name'                 => 'Bank name',
        'bank_transfer_enable'                      => 'Bank transfer enable',
    ],

];
