<?php
return 
    [
        // index page
        'title'                         => 'เอกสารสัญญาทั้งหมด',
        'menu'                          => 'เอกสารสัญญา',
        'export_contract_btn'           => 'ส่งออกในรูปแบบ Excel',
        'upload_cotract_btn'            => 'นำเข้าเอกสารสัญญา',
        'dt-date'                       => 'วันที่สัญญา',
        'dt-contract_code'              => 'เลขที่สัญญา',
        'dt-contract_name'              => 'ชื่อสัญญา',
        'dt-total_bill'                 => 'จำนวนใบแจ้งหนี้',
        'dt-contract_period'            => 'ระยะสัญญา',
        'dt-delivery_date'              => 'วันที่ต้องจัดส่ง',
        'dt-payment_status'             => 'สถานะการชำระเงิน',
        'dt-signing_date'               => 'ลงลายเซ็น ณ ที่',
        'dt-total_amount'               => 'ทั้งหมด',
        'dt-status'                     => 'สถานะ',
        'dt-application-search'         => 'เลขที่สัญญา',
        'dt-options'                    => '',
        'filter-default'                => 'ทั้งหมด',
        'filter-new'                => 'มาใหม่',
        'filter-active'                => 'มีผล',
        'filter-rejected'                => 'ปฏิเสธ',
        'filter-approval'                => 'อนุมัติ',
        'filter-document_uploaded'                => 'เอกสารนำเข้า',
        'filter-customer_accepted'                => 'ลูกค้าที่อนุมัติ',
        'filter-paid' => 'ชำระเงินแล้ว',
        'filter-unpaid' => 'ค้างชำระ',
        'filter-closed' => 'จบสัญญา',
        'all_bill' => 'ใบรายการทั้งหมด',

        'error-message-1'   => 'ไม่สามารถทำรายการได้ในขณะนี้',
        'export_report_success'   => 'ส่งออกรายงานสำเร็จ',
        'response-message-1' => 'ระบบได้ทำการส่งไฟล์ Report ไปยัง Email ของท่านแล้ว',
        'info_1'                    => 'ข้อมูลเอกสารสัญญา',
        'info_2'                    => 'ถึง',
        'info_3'                    => 'จากทั้งหมด',
        'info_4'                    => 'บริษัท',
        'infoEmpty'                 => 'ไม่มีข้อมูลเอกสารสัญญา',
        'lengthMenu_1'                => 'แสดง',
        'lengthMenu_2'                => 'เอกสารสัญญา',
        'loadingRecords'            => 'กำลังเรียกข้อมูล...',
        'processing'                => 'กำลังประมวลผล...',
        'zeroRecords'               => 'ไม่พบข้อมูลที่ตรงกับที่ค้นหา',
        'first'                     => 'หน้าแรก',
        'last'                      => 'หน้าสุดท้าย',
        'next'                      => 'ถัดไป',
        'previous'                  => 'ย้อนกลับ',
        'emptyTable'                => 'ไม่มีข้อมูลในตารางนี้',
        'filter-default'                => 'สถานะ',
        'filter-payment_status'         => 'สถานะการชำระเงิน',

        'create_success'            => 'คำขอของคุณได้ถูกสร้างเรียบร้อยแล้ว',
        
        //upload contract
        'upload' => [
            'upload_title' =>    'นำเข้าเอกสารสัญญา',
            'instruction' => 'ข้อแนะนำ',
            'instruction_description' => 'สำหรับการนำเข้าสัญญาใหม่ กรุณาคลิกเพื่อนำเข้าไฟล์ และทำการเลือกไฟล์จากคอมพิวเตอร์ของท่าน หรือทำการลากไฟล์ที่ท่านต้องการนำเข้ามายังบริเวณที่เว็บไซต์นี้กำหนด',
            'file_template' => 'คุณลักษณะของเท็มเพลตไฟล์',
            'file_template_description' => 'สำหรับผู้ใช้ใหม่ ท่านสามารถดาวน์โหลดตัวอย่างเท็มเพลตไฟล์ได้โดยการกดที่ปุ่ม "เท็มเพลตไฟล์" เพื่อทำการดาวน์โหลดตัวอย่าง',
            'download' => 'ดาวน์โหลด',
            'template' => 'เท็มเพลต',
            'validation_title' => 'การตรวจสอบไฟล์นำเข้า',
            'validation_description' => 'ข้อมูลในไฟล์จะถูกตรวจสอบตามเงื่อนไขดังต่อไปนี้',
            'validation_description_1' => 'ระบุข้อมูลลงทุกๆช่องในตาราง ยกเว้นฟิลด์ข้อมูลที่เป็นทางเลือก (ระบุหรือไม่ก็ได้)',
            'validation_description_2' => 'ระบบรองรับเฉพาะไฟล์ CSV สำหรับการนำเข้าเท่านั้น',
            'dropzone_message_1' => 'ลาก หรือ คลิกเลือกไฟล์ที่ต้องการ',
            'dropzone_message_2' => 'จากคอมพิวเตอร์ของท่าน',
            'please_select' => 'เลือกประเภทไฟล์ที่ต้องการนำเข้า',
            'option_1' => 'ข้อมูลเต็มรูปแบบ (THB)',
            'option_2' => 'ข้อมูลอย่างย่อ (MYR)',
        ],
        // contract info page

        'info'                          => [
            'title'                         => 'รายละเอียดสัญญา',
            'application_info'              => 'รายละเอียดสัญญา',
            'field-contract_name'           => 'ชื่อสัญญา',
            'field-contract_item'           => 'ชื่อสินค้า',
            'field-amount'                  => 'จำนวนเงิน',
            'field-outstanding_balance'     => 'ยอดยกมา',
            'field-recipient'               => 'ผู้รับ/ลูกค้า',
            'field-goto_recipient_detail'   => 'รายละเอียดลูกค้า',
            'field-contract_period'         => 'ระยะเวลาผ่อน (เดือน)',
            'field-fee_percent'             => 'ค่าธรรมเนียม (%)',
            'field-fee_amount'              => 'ค่าธรรมเนียมจำนวน',
            'field-interest_percent'        => 'อัตราดอกเบี้ย (%)',
            'field-monthly_installment'     => 'ยอดผ่อนต่อเดือน',
            'field-total_amount'            => 'ราคาสุทธิ',
            'field-effective_date'          => 'วันที่สัญญามีผล',
            'field-contract_submit_date'    => 'วันที่อนุมัติสัญญา',
            'field-additional_info'         => 'ข้อมูลเพิ่มเติมอื่นๆ',
            'field-contact_address'         => 'ที่อยู่สำหรับส่งสินค้าตามเอกสารสัญญา',
            'field-currency'                => 'สกุลเงิน',
            'field-delivery_date'           => 'วันที่จัดส่ง',
            'field-document_list'           => 'เอกสารแนบ และ รูปภาพ',
            'field-upload_document_btn'     => 'นำเข้าเอกสาร',
            'field-file_upload_at'          => 'วันที่',
            'field-file_name'               => 'ชื่อเอกสาร',
            'field-file_description'        => 'รายละเอียด',
            'field-file_option'             => '',

            'field-bill_transaction_title'  => 'รายการใบแจ้งหนี้',
            'field-bill_reference'          => 'Reference code',
            'field-bill_created_date'       => 'วันที่',
            'field-bill_amount'             => 'จำนวนเงิน',
            'field-bill_due_date'           => 'กำหนดชำระ',
            'field-bill_overdue'            => 'เกินชำระ',
            'field-bill_payment_date'       => 'วันทำรายการ',
            'field-bill_payment_status'     => 'สถานะการชำระ',
            'field-bill_status'             => 'สถานะ',
            'field-bill_download'           => 'ดาวน์โหลด',
            'field-mark_as_paid'            => 'ทำรายการจ่าย',
            
            'field-unbilled_add'            => 'เพิ่มรายการ',
            'field-unbilled_title'          => 'รายการเพิ่มในรอบบิลถัดไป',
            'field-unbilled_date'           => 'วันที่',
            'field-unbilled_name'           => 'รายการธุรกรรม',
            'field-unbilled_desc'           => 'รายละเอียด',
            'field-unbilled_amount'         => 'จำนวนเงิน',

            'unbill-option-calling_fee'     => 'ค่าติดตามทวงถาม',
            'unbill-option-unpaid_fee'      => 'ค่าปรับค้างชำระ',
            'unbill-option-discount'        => 'ส่วนลด',
            'unbill-add_btn'                => 'ค่าธรรมเนียม / ส่วนลด',
            'placeholder-unbilled_item_type'        => 'ระบุประเภทรายการ',
            'placeholder-unbilled_amount'           => 'ระบุจำนวนเงิน',
            'placeholder-unbilled_description'      => 'ระบุรายละเอียด',
            'upload_title'                  => 'นำเข้าเอกสาร / รูปภาพ',
            'upload_method'                 => 'ทางเลือก',
            'upload_method-from_url'        => 'ด้วย URL',
            'upload_method-browse'          => 'ด้วยการนำเข้าไฟล์',
            'upload_method-url_input'       => 'ระบุ URL',
            
            'please_select_transactions'    => 'โปรดเลือกรายการชำระเงิน',
            'please_select_bill'            => 'โปรดเลือกใบแจ้งหนี้',
            'bill_payment_not_found'        => 'ไม่พบรายการใบแจ้งหนี้ที่มีสถานะยังไม่ชำระ',
            'dup_transactions_not_found'    => 'ไม่พบรายการจ่ายเงินที่ซ้ำกัน',
            'button_repayment'              => 'ชำระเงิน',        
        ],

        // contract upload confirm page
        'confirm'                       => [
            'dt-contract_reference'                       => 'เลขที่สัญญา',
            'dt-contract_period'                          => 'จำนวนงวด (เดือน)',
            'dt-interest_amount'                          => 'ดอกเบี้ย',
            'dt-contract_installment'                     => 'ชำระต่อเดือน',
            'dt-product_reference'                        => 'รหัสอ้างอิงสินค้า',
            'dt-product_name'                             => 'ชื่อสินค้า',
            'dt-product_price'                            => 'ราคา',
            'dt-customer_name'                            => 'ชื่อลูกค้า',
            'dt-citizen_id'                               => 'เลขประจำตัวประชาชน',
            'dt-total_document'                           => 'เอกสาร',
            'dt-mobile_no'                                => 'เบอร์โทรศัพท์',
            'dt-upload_status'                            => 'สถานะ',
            'dt-error_message'                            => 'เหตุผลที่ไม่สำเร็จ',
            'title'                                       => 'ตัวอย่างข้อมูลที่นำเข้า',
        ],

        //payment transaction report
        'payment' =>[
            'title' => 'รายการธรุกรรมทั้งหมดที่เกิดขึ้น',
            'status' => 'สถานะ',
            'all' => 'ทั้งหมด',
            'active' => 'กำลังดำเนินการ',
            'pending' => 'อยู่ในระหว่างรอดำเนินการ',
            'export_excel' => 'ส่งออกเอกสาร Excel',
            'bill_reference' => 'เลขที่อ้างอิงใบรายการ',
            'from' => 'จาก',
            'transaction_id' => 'ไอดีอ้างอิงของธุรกรรม',
            'amount' => 'จำนวนเงิน',
            'date' => 'วันที่',
            'info_1'                    => 'ข้อมูลการทำธุรกรรม',
            'info_2'                    => 'ถึง',
            'info_3'                    => 'จากทั้งหมด',
            'info_4'                    => 'รายการธุรกรรม',
            'infoEmpty'                 => 'ไม่มีข้อมูลการทำธุรกรรม',
            'lengthMenu_1'                => 'แสดง',
            'lengthMenu_2'                => 'รายการธุรกรรม',
            'loadingRecords'            => 'กำลังเรียกข้อมูล...',
            'processing'                => 'กำลังประมวลผล...',
            'zeroRecords'               => 'ไม่พบข้อมูลที่ตรงกับที่ค้นหา',
            'first'                     => 'หน้าแรก',
            'last'                      => 'หน้าสุดท้าย',
            'next'                      => 'ถัดไป',
            'previous'                  => 'ย้อนกลับ',
            'emptyTable'                => 'ไม่มีข้อมูลในตารางนี้',
        ],
    ];
