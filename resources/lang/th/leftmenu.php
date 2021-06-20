<?php
return 
    [
        'dashboard'       => 'กระดานหลัก',
        'corporate'       => 'บริษัท',
        'user_management'       => 'จัดการผู้ใช้งาน',
        'corporate_usermanagement'  => 'จัดการผู้ใช้งานบริษัท',
        'agent_usermanagement'  => 'จัดการผู้ใช้งานตัวแทน',
        'role_management'       => 'จัดการบทบาท',
        'agents_management'       => 'จัดการตัวแทน',
        'invoice'           => 'ใบแจ้งหนี้',
        'support'       => 'ช่วยเหลือ',
        'search_bill'       => 'ค้นหาบิล',
        'etax'       => 'ใบกำกับภาษี',
        'file_mapping'       => 'จับคู่ฟิลด์',
        'main_title'       => 'E-Tax Demo',
        'sign_out'       => 'ออกจากระบบ',
        'login_time'       => 'เวลาเข้าใช้งาน',
        'footer'  => '©2019 All Rights Reserved. Powered by Digio and PCC. |  Version 1.0',
        'broadcast' => 'การเผยเเพร่',
        'news' => 'ข่าวสาร',
        'richmenu' => 'ไลน์ริชเมนู',
        'loan' => 'สัญญากู้',
        'payment_transaction' => 'รายการธุรกรรม',
        'recipient' => 'ผู้รับ/ลูกค้า',
        'list' => 'รายการผู้รับ',
        'group' => 'กลุ่มของผู้รับ',
        'edit_profile' => 'แก้ไขข้อมูลส่วนตัว',
        'my_profile' => 'ข้อมูลส่วนตัว',
        'item_product' => 'รายการสินค้า',
        'item_product_setting' => 'จัดการรายการสินค้า',
        'bill' => [
            'title'             => 'ใบแจ้งหนี้',
            'listpage'          => 'รายการทั้งหมด'
        ],
        'all_bill' => 'ใบเเจ้งหนี้ทั้งหมด',
        'line' => 'ไลน์ แอปพลิเคชัน',
        'corpsetting-loan_schedule' => 'ตารางเวลา',
        'corporate_role'            => 'บทบาทผู้ใช้ของบริษัท',
        'agent_role'                => 'บทบาทผู้ใช้ของตัวแทน',
        'report'    => [
            'title'                 => 'รายงาน',
            'corporate'             => 'บริษัท',
            'bill_payment'          => 'ใบแจ้งหนี้',
            'payment_transaction'   => 'รายการธุรกรรม',
            'inquiry'               => 'ค้นหารายงาน',
        ],
        'manage'    => [
            'bill'          => [
                'log_activity'      => 'บันทึกกิจกรรมของใบแจ้งหนี้'
            ]
        ],
        'recurring_title'      => 'ตัดบัตรอัตโนมัติ',
        'recurring'  =>  'ตัดบัตร',

        'corporate_setting'       => 'จัดการตั้งค่า',
        'corp_current_name' =>  Session::get('CORP_CURRENT')['name_th'] ?? '',
    
    ];
