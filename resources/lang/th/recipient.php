<?php

return [
    'index' => [
        'title' => 'จัดการผู้รับบิล',
        'bill_import' => 'นำเข้าบิล',
        'import' => 'นำเข้าข้อมูลลูกค้า',
        'export_excel' => 'ส่งออกไฟล์',
        'invoice_number' => 'เลขใบแจ้งหนี้',
        'payment_reference' => 'รหัสอ้างอิงการชำระเงิน',
        'total_amount' => 'จำนวนเงินทั้งหมด',
        'total' => 'ทั้งหมด',
        'due_date' => 'วันครบกำหนดชำระ',
        'type' => 'ประเภท',
        'bill_status' => 'สถานะบิล',
        'payment_status' => 'สถานะการชำระเงิน',
        'payment_date' => 'วันที่ชำระเงิน',
        'action' => 'ตัวเลือก',
        'error-message-1'   => 'ระบบไม่สามารถประมวลผลได้ในขณะนี้',
        'response-message-1' => 'ระบบได้ทำการส่งไฟล์รายงานให้ท่านทางอีเมลแล้วเป็นที่เรียบร้อย',
        'info_1'                    => 'ข้อมูลผู้ใช้งาน',
        'info_2'                    => 'ถึง',
        'info_3'                    => 'จากทั้งหมด',
        'info_4'                    => 'ผู้ใช้งาน',
        'infoEmpty'                 => 'ไม่มีข้อมูลของผู้ใช้งาน',
        'lengthMenu_1'              => 'แสดง',
        'lengthMenu_2'              => 'ผู้ใช้งาน',
        'loadingRecords'            => 'กำลังเรียกข้อมูล...',
        'processing'                => 'กำลังประมวลผล...',
        'zeroRecords'               => 'ไม่พบข้อมูลที่ตรงกับที่ค้นหา',
        'first'                     => 'หน้าแรก',
        'last'                      => 'หน้าสุดท้าย',
        'next'                      => 'ถัดไป',
        'previous'                  => 'ย้อนกลับ',
        'emptyTable'                => 'ไม่มีข้อมูลในตารางนี้',
        'all_status' => 'สถานะทั้งหมด',
        'active' => 'ใช้งาน',
        'inactive' => 'ไม่ใช้งาน',
        'customer_code' => 'รหัสอ้างอิงลูกค้า',
        'name' => 'ชื่อ',
        'email' => 'อีเมล',
        'telephone' => 'โทรศัพท์',
        'status' => 'สถานะ',
        'search_customer_code' => 'ค้นหารหัสอ้างอิงลูกค้า',
        'pending' => 'รอดำเนินการ',
        'search_fullname' => 'ค้นหาชื่อ-นามสกุลอย่างเต็ม',
        'new' => 'นำเข้าไฟล์ ผู้รับใหม่',
        'replace' => 'นำเข้าไฟล์ แทนที่ผู้รับเดิม',
    ],
    'import' =>[
        'title' => 'นำเข้าลูกค้า',
        'instruction' => 'ข้อแนะนำ',
        'instruction_description' => 'สำหรับการนำเข้าสัญญาใหม่ กรุณาคลิกเพื่อนำเข้าไฟล์ และทำการเลือกไฟล์จากคอมพิวเตอร์ของท่าน หรือทำการลากไฟล์ที่ท่านต้องการนำเข้ามายังบริเวณที่เว็บไซต์นี้กำหนด',
        'file_template' => 'คุณลักษณะของเท็มเพลตไฟล์',
        'file_template_description' => 'สำหรับผู้ใช้ใหม่ ท่านสามารถดาวน์โหลดตัวอย่างเท็มเพลตไฟล์ได้โดยการกดที่ปุ่ม "เท็มเพลตไฟล์" เพื่อทำการดาวน์โหลดตัวอย่าง',
        'file_template_xls_description' => 'สำหรับผู้ใช้ระบบปฏิบัติการ Windows, คุณสามารถดาวน์โหลดไฟล์ XLS ที่ช่วยให้ผู้ใช้ตรวจสอบและสร้างไฟล์ CSV (UTF-8) อัตโนมัติก่อนนำเข้า',
        'download_xls' => 'ดาวน์โหลด XLS',
        'download' => 'ดาวน์โหลด CSV',
        'template' => 'เท็มเพลต',
        'file_validation' => 'การตรวจสอบไฟล์นำเข้า',
        'file_validation_description' => 'ข้อมูลในไฟล์จะถูกตรวจสอบตามเงื่อนไขดังต่อไปนี้',
        'file_validation_description_1' => 'ระบุข้อมูลลงทุกๆช่องในตาราง ยกเว้นฟิลด์ข้อมูลที่เป็นทางเลือก (ระบุหรือไม่ก็ได้)',
        'file_validation_description_2' => 'ระบบรองรับเฉพาะไฟล์ CSV สำหรับการนำเข้าเท่านั้น',
        'dropzone_message_1' => 'ลาก หรือ คลิกเลือกไฟล์ที่ต้องการ',
        'dropzone_message_2' => 'จากคอมพิวเตอร์ของท่าน',
        'detail' => 'ข้อมูล',
    ],
    'group' => [
        'title'     => 'กลุ่มผู้รับ',
        'create' => 'สร้าง',
        'create_title' => 'สร้างกลุ่มของผู้รับ',
        'recipient_group' => 'กลุ่มผู้รับ',
        'group_name_en' => 'ชื่อกลุ่มผู้รับ (ภาษาอังกฤษ)',
        'description' => 'รายละเอียด',
        'select_recipient' => 'เลือกผู้รับ',
        'add_more' => 'เพิ่มผู้รับ',
        'close' => 'ปิด',
        'message_1' => 'กรุณากรอกข้อมูลให้ถูกต้อง',
        'delete_group' => 'ลบกลุ่ม',
        'edit_group' => 'แก้ไขกลุ่ม',
        'update' => 'แก้ไขข้อมูลกลุ่มผู้รับ',
        'delete_confirm_message' => 'หากลบแล้วกลุ่มนี้จะหายไป ต้องการลบใช่หรือไม่',
        'delete_confirm_title' => 'ต้องการลบกลุ่มใช่หรือไม่',
        'error_delete' => 'ไม่สามารถลบข้อมูลได้กรุณาลองใหม่ หรือติดต่อฝ่ายช่วยเหลือ',
        'update_title' => 'แก้ไขข้อมูลกลุ่มผู้รับ',
    ],
    'profile' => [
        'title'     => 'ข้อมูลผู้รับ',
        'edit' => 'แก้ไข',
        'profile' => 'ข้อมูล',
        'customer_code' => 'รหัสอ้างอิงผู้รับ',
        'invitation_code' => 'รหัสอ้างอิงการลงทะเบียน',
        'customer_name' => 'ชื่อลูกค้า',
        'email' => 'อีเมล',
        'first_name' => 'ชื่อ',
        'middle_name' => 'ชื่อกลาง',
        'last_name' => 'นามสกุล',
        'country' => 'ประเทศ',
        'citizen_id' => 'เลขประจำตัวประชาชน',
        'mobile_no' => 'เบอร์โทรศัพท์มือถือ',
        'contact' => 'ติดต่อ',
        'address' => 'ที่อยู่',
        'additional_information' => 'ข้อมูลอื่นๆเพิ่มเติม',
        'career' => 'อาชีพ',
        'salary' => 'เงินเดือน',
        'reference_1' => 'รหัสอ้างอิงที่ 1',
        'reference_2' => 'รหัสอ้างอิงที่ 2',
        'reference_3' => 'รหัสอ้างอิงที่ 3',
        'reference_4' => 'รหัสอ้างอิงที่ 4',
        'reference_5' => 'รหัสอ้างอิงที่ 5',
        'bill_transaction' => 'รายการธุรกรรมบิล',
        'date' => 'วันที่',
        'reference_code' => 'รหัสอ้างอิง',
        'amount' => 'จำนวนเงิน',
        'total_amount' => 'จำนวนเงินทั้งหมด',
        'due_date' => 'วันครบกำหนดชำระ',
        'overdue' => 'วันเกินกำหนดชำระ',
        'transaction_date' => 'วันที่ทำธุรกรรม',
        'payment_status' => 'สถานะการชำระเงิน',
        'status' => 'สถานะ',
        'download' => 'ดาวน์โหลด',
        'back' => 'ย้อนกลับ',
        'full_name' => 'ชื่อ-นามสกุลอย่างเต็ม',
        'zipcode' => 'รหัสไปรษณีย์',
        'state' => 'เมือง',
        'country' => 'ประเทศ',
        'save_and_change' => 'บันทึก และ เปลี่ยนแปลง',
        'cancel' => 'ยกเลิก',
        'edit_title' => 'แก้ไขข้อมูลผู้รับ',
        'create' => 'สร้างผู้รับ',
        'create_confirm' => 'สร้างผู้รับ',
        'save' => 'บันทึก',
        'by_web' => 'หน้าเว็บไซต์',
        'by_sms' => 'SMS',
        'credit_score'  => [
            'title'         => 'ตารางคะแนนเครดิต',
            'created_at'    => 'วัน/เวลา',
            'credit_score'  => 'คะแนนเครดิต',
            'remark'        => 'หมายเหตุ',
            'btn-add'       => 'เพิ่มรายการ',
            'active'        => 'ช่องทางชำระ ตัดบัตรอัตโนมัติพร้อมใช้งาน',
            'add-credit'    => [
                'title'                 => 'เพิ่มรายการ',
                'validate_score'        => 'กรุณากรอกข้อมูลให้ถูกต้อง',
                'enter_credit_score'    => 'กรอกคะแนนเครดิตที่ต้องการเพิ่ม',
                'enter_reason'          => 'กรุณาระบุเหตุผล',
            ],
        ],
        'line_id'   => 'ไลน์ไอดี',
        'optional_mobile_no' => 'เบอร์โทรศัพท์เพิ่มเติม',
        'optional_email' => 'อีเมลเพิ่มเติม',
        'hint_mobile' => 'กรุณาใสเครื่องหมาย , (จุลภาค) ระหว่างเบอร์โทร (สูงสุด 2 หมายเลข)',
        'hint_email' => 'กรุณาใสเครื่องหมาย , (จุลภาค) ระหว่างอีเมล (สูงสุด 2 อีเมล)',
        'send_card_store'   => 'ขอใช้งานช่องทางชำระ ตัดบัตรอัตโนมัติ',
        'resend_card_store' => 'ขอใช้งานช่องทางชำระ ตัดบัตรอัตโนมัติอีกครั้ง',
        'resend'            => 'คุณต้องการขอใช้งานช่องทางชำระ ตัดบัตรอัตโนมัติอีกครั้งหรือไม่ ?',
        'card_detail'       => 'ข้อมูลบัตรที่ถูกบันทึกไว้',
        'card_no'           => 'หมายเลขบัตร',
        'create_at'         => 'นำเข้าระบบเมื่อ',
        'remove_old'        => 'หากคุณยืนยันที่จะขอใหม่เพื่อเพิ่มบัตรสำหรับการชำระเงินแบบตัดบัตรอัตโนมัติ บัตรใบนี้จะถูกลบ!'
    ],
    'active' => 'ใช้งาน',
    'inactive' => 'ไม่ใช้งาน',
    'payment_transaction' => 'รายการบิล',
    'confirm_recipient' => 'ยืนยันผู้รับรายการ',
    'confirm_title' => 'ตัวอย่างข้อมูลรายการผู้รับที่นำเข้า',
    'detail' => 'รายการผู้รับ',
    'lock'          => 'ล็อคผู้รับ',
    'unlock'          => 'ปลดล็อคผู้รับ',
    'delete'          => 'ลบผู้รับ',
    'sure'            => 'คุณต้องการที่จะ',
    'or_not'          => 'หรือไม่?',

    "profile_edit" => [
        'customer_edit' => 'แก้ไขข้อมูลผู้รับ',
    ],
];
