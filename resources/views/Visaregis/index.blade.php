@extends('visaregis_layouts.app', ['title' => __('Visa Register')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        a {
            text-decoration: none;
            color: inherit;
        },
    </style>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-12">
                        <h6 class="h2 p-2 mb-1 text-white d-inline-block">รายละเอียดบัญชี</h6>
                        <a class="btn btn-neutral float-right"  href="https://www.digio.co.th/meebill" target="_blank">รายละเอียดเพิ่มเติม</a> 
                    </div>
                    <div class="col-12 pt-2">
                        <h6 class="pt-3 p-2 h4 text-white d-inline-block mb-1">กรุณาตรวจสอบข้อมูลให้ถูกต้อง เนื่องจากเป็นข้อมูลที่ใช้ในการออกใบแจ้งหนี้และใบเสร็จ</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4"></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ action('Visaregis\VisaregisController@create_submit') }}" method="post" enctype="multipart/form-data" id="form_visaregis">        
                    {{ csrf_field() }}
                    <div class="d-flex justify-content-center">
                        <div class="card w-100">
                            <div class="align-items-center">
                                <div class="col-12">
                                    <div class="row p-3">
                                        <div class="col-6 text-center">
                                            <div class="form-group my-2">
                                                <label class="form-control-label">
                                                    <input type="radio"  name="status" id="type1" value="corporate">
                                                    บริษัท
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-center">
                                            <div class="form-group my-2 ">
                                                <label class="form-control-label">
                                                    <input type="radio"  name="status" id="type2" value="normal">
                                                    บุลคลธรรมดา 
                                                </label>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                            </div> 
                        </div>
                    </div>

                    <!-- บริษัท -->
                    <div id="form1" class="d-none">
                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลผู้สมัคร</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อบริษัท (ไทย)</label>
                                                    <input type="text" class="form-control" name="corporate_name_th"  placeholder="ชื่อบริษัท (ไทย)" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อบริษัท (อังกฤษ)</label>
                                                    <input type="text" class="form-control" name="corporate_name_en"  placeholder="ชื่อบริษัท (อังกฤษ)" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขจดทะเบียนบริษัท</label>
                                                    <input type="number" class="form-control" name="corporate_number" placeholder="หมายเลขจดทะเบียนบริษัท" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขโทรศัพท์</label>
                                                    <input type="number" class="form-control" name="corporate_telephone" placeholder="หมายเลขโทรศัพท์" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ที่อยู่ตามทะเบียนบริษัท</label>
                                                    <input type="text" class="form-control" name="corporate_address" placeholder="ที่อยู่ตามทะเบียนบริษัท" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> จังหวัด</label>
                                                    <select class="form-control province" name="corporate_select_province"  robot-test="corporate-create-provice">
                                                        @if(old('corporate_select_province'))
                                                        <option value="{{ old('corporate_select_province') }}">{{ old('corporate_select_province') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> อำเภอ / เขต</label>
                                                    <select class="form-control district" name="corporate_select_district" robot-test="corporate-create-district">
                                                        @if(old('select_district'))
                                                        <option value="{{ old('select_district') }}">{{ old('select_district') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> ตำบล / แขวง</label>
                                                    <select class="form-control sub-district" name="corporate_select_sub_district" robot-test="corporate-create-subdistrict">
                                                        @if(old('select_sub_district'))
                                                        <option value="{{ old('select_sub_district') }}">{{ old('select_sub_district') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label">รหัสไปรษณีย์</label>
                                                    <input type="text" class="form-control" name="corporate_select_zipcode" value="{{ old('select_zipcode') }}" readonly="readonly" robot-test="corporate-create-zipcode">
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="corporate_zipcode_address" robot-test="corporate-create-zipcodeaddress">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลเจ้าของสถานที่ประกอบการ (หากไม่มีให้ระบุข้อมูลผู้บริหารสูงสุด)</h4>
                                </div>
                                <div class="card-body">
                                    <section class="add-wrapper">
                                        <div class="p-3 mb-2 border rounded clonable">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group my-2">
                                                        <label class="form-control-label text-truncate"> <span class="text-danger">*</span> ชื่อ</label>
                                                        <input type="text" class="form-control" name="operate_firstname[0]" placeholder="ระบุ ชื่อ" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group my-2">
                                                        <label class="form-control-label text-truncate"> <span class="text-danger">*</span> นามสกุล</label>
                                                        <input type="text" class="form-control" name="operate_surname[0]" placeholder="ระบุ นามสกุล" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group my-2">
                                                        <label class="form-control-label text-truncate"> <span class="text-danger">*</span> หมายเลขโทรศัพท์</label>
                                                        <input type="number" class="form-control" name="operate_telephone[0]" placeholder="หมายเลขโทรศัพท์" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group my-2">
                                                        <label class="form-control-label text-truncate"> <span class="text-danger">*</span> อีเมล</label>
                                                        <input type="email" class="form-control" name="operate_email[0]" placeholder="อีเมล" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group my-2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <div class="pt-2 float-right">
                                        <button type="button" id="add" class="btn btn-outline-primary">เพิ่มรายชื่อ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลผู้ติดต่อ</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อ (ไทย)</label>
                                                    <input type="text" class="form-control" name="corporate_first_name_th" placeholder="ระบุ ชื่อ" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> นามสกุล (ไทย)</label>
                                                    <input type="text" class="form-control" name="corporate_last_name_th" placeholder="ระบุ นามสกุล" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขโทรศัพท์</label>
                                                    <input type="number" class="form-control" name="telephone" placeholder="หมายเลขโทรศัพท์" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> อีเมล</label>
                                                    <input type="email" class="form-control" name="corporate_email" placeholder="อีเมล" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลการโอนเงินเข้าธนาคาร</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ธนาคาร</label>
                                                    <select class="form-control bank_name" name="corporate_bank_name"  robot-test="corporate_bank_name">
                                                        @if(old('corporate_bank_name'))
                                                            <option value="{{ old('corporate_bank_name') }}">{{ old('corporate_bank_name') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">สาขา</label>
                                                    <input type="text" class="form-control" name="corporate_bank_branch" placeholder="ระบุ สาขา" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขบัญชี</label>
                                                    <input type="number" class="form-control" name="corporate_account_number" placeholder="ระบุ หมายเลขบัญชี" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อบัญชี</label>
                                                    <input type="text" class="form-control" name="corporate_account_name" placeholder="ระบุ ชื่อบัญชี" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลร้านค้า</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อร้านค้า</label>
                                                    <input type="text" class="form-control" name="corporate_trade_name" placeholder="ชื่อร้านค้า" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">เว็ปไซต์ </label>
                                                    <input type="text" class="form-control" name="corporate_website" placeholder="ระบุ เว็ปไซต์" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ประเภทของสินค้า/บริการ</label>
                                                    <input type="text" class="form-control" name="corporate_product_type" placeholder="ประเภทของสินค้า/บริการ" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> นโยบายการคืนเงิน</label>
                                                    <select class="form-control province" name="corporate_policy" id="policy" robot-test="corporate-create-provice">
                                                        <option value="">กรุณาระบุนโยบายการคืนเงิน</option>
                                                        <option value="ไม่มีนโยบายการคืนเงิน">ไม่มีนโยบายการคืนเงิน</option>
                                                        <option value="มีนโยบายการคืนเงินเต็มจำนวน">มีนโยบายการคืนเงินเต็มจำนวน</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> จำนวนรายการต่อเดือน</label>
                                                    <input type="number" class="form-control" name="corporate_item_month" placeholder="จำนวนรายการต่อเดือน" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ยอดเงินโดยเฉลี่ยต่อรายการ</label>
                                                    <input type="number" class="form-control" name="corporate_median_month" placeholder="จำนวนรายการต่อเดือน" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ช่องทางรับชำระ</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                <input type="checkbox" class="form-control-lable" name="corporate_qr_promptpay"/>
                                                QR พร้อมเพย์ (ไม่มีค่าธรรมเนียม)</label>
                                            </div>
                                        </div>          
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                <input type="checkbox" class="form-control-lable" name="corporate_debit"/>    
                                                บัตรเครดิด/เดบิต (ค่าธรรมเนียมการชำระเริ่มต้น 3%)</label>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                <input type="checkbox" class="form-control-lable" name="corporate_transfer"/>
                                                เข้าบัญชีร้านค้าตรง (ไม่อัพเดตรายการให้อัตโนมัติ ต้องยืนยันรายการด้วยตัวเอง)</label>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="text-left">
                                                        <a href="/" id="btn_cancel" class="btn btn-warning mt-3">ยกเลิก</a>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-right">
                                                        <button type="submit" id="submit" class="btn btn-primary mt-3">สมัคร</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- บริษัท -->

                    <!-- บุลคลธรรมดา -->
                    <div id="form2" class="d-none">
                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลผู้สมัคร</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อ (ไทย)</label>
                                                    <input type="text" class="form-control" name="normal_first_name_th" placeholder="ชื่อ (ไทย)" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> นามสกุล (ไทย)</label>
                                                    <input type="text" class="form-control" name="normal_last_name_th" placeholder="นามสกุล (ไทย)" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขประจำตัวประชาชน</label>
                                                    <input type="number" class="form-control" name="identification_number" placeholder="หมายเลขประจำตัวประชาชน" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขโทรศัพท์</label>
                                                    <input type="number" class="form-control" name="normal_telephone" placeholder="หมายเลขโทรศัพท์" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> อีเมล</label>
                                                    <input type="email" class="form-control" name="normal_email" placeholder="อีเมล" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> จังหวัด</label>
                                                    <select class="form-control province" name="normal_select_province" id="normal_select_province" robot-test="corporate-create-provice">
                                                        @if(old('normal_select_province'))
                                                        <option value="{{ old('normal_select_province') }}">{{ old('normal_select_province') }}</option>
                                                        @endif
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> อำเภอ / เขต</label>
                                                    <select class="form-control district" name="normal_select_district" id="normal_select_district"  robot-test="corporate-create-district">
                                                        @if(old('normal_select_district'))
                                                        <option value="{{ old('select_district') }}">{{ old('normal_select_district') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label"><span class="text-danger">*</span> ตำบล / แขวง</label>
                                                    <select class="form-control sub-district" name="normal_select_sub_district" id="normal_select_sub_district" robot-test="corporate-create-subdistrict">
                                                        @if(old('normal_select_sub_district'))
                                                        <option value="{{ old('select_sub_district') }}">{{ old('normal_select_sub_district') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label for="" class=" form-control-label">รหัสไปรษณีย์</label>
                                                    <input type="text" class="form-control" name="normal_select_zipcode" value="{{ old('select_zipcode') }}" readonly="readonly" robot-test="corporate-create-zipcode">
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="normal_zipcode_address" robot-test="corporate-create-zipcodeaddress">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลการโอนเงินเข้าธนาคาร</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ธนาคาร</label>
                                                    <select class="form-control bank_name" name="normal_bank_name"  robot-test="normal_bank_name">
                                                        @if(old('normal_bank_name'))
                                                            <option value="{{ old('normal_bank_name') }}">{{ old('normal_bank_name') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">สาขา </label>
                                                    <input type="text" class="form-control" name="normal_bank_branch" placeholder="สาขา" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> หมายเลขบัญชี</label>
                                                    <input type="number" class="form-control" name="normal_account_number" placeholder="หมายเลขบัญชี" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อบัญชี</label>
                                                    <input type="text" class="form-control" name="normal_account_name" placeholder="ชื่อบัญชี" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ข้อมูลร้านค้า</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                <label class="form-control-label text-truncate"><span class="text-danger">*</span> ชื่อร้านค้า</label>
                                                    <input type="text" class="form-control" name="normal_trade_name" placeholder="ชื่อร้านค้า" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">เว็ปไซต์</label>
                                                    <input type="text" class="form-control" name="normal_website" placeholder="เว็ปไซต์" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ประเภทของสินค้า/บริการ</label>
                                                    <input type="text" class="form-control" name="normal_product_type" placeholder="ประเภทของสินค้า/บริการ" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> นโยบายการคืนเงิน</label>
                                                    <select class="form-control province" name="normal_policy" id="policy" robot-test="corporate-create-provice">
                                                        <option value="">กรุณาระบุนโยบายการคืนเงิน</option>
                                                        <option value="ไม่มีนโยบายการคืนเงิน">ไม่มีนโยบายการคืนเงิน</option>
                                                        <option value="มีนโยบายการคืนเงินเต็มจำนวน">มีนโยบายการคืนเงินเต็มจำนวน</option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> จำนวนรายการต่อเดือน</label>
                                                    <input type="number" class="form-control" name="normal_item_month" placeholder="จำนวนรายการต่อเดือน" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate"><span class="text-danger">*</span> ยอดเงินโดยเฉลี่ยต่อรายการ</label>
                                                    <input type="number" class="form-control" name="normal_median_month" placeholder="จำนวนรายการต่อเดือน" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <h4 class="card-title">ช่องทางรับชำระ</h4>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 mb-2 border rounded">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                    <input type="checkbox" class="form-control-lable" name="normal_qr_promptpay"/>    
                                                    QR พร้อมเพย์ (ไม่มีค่าธรรมเนียม)
                                                </label>
                                            </div>
                                        </div>          
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                    <input type="checkbox" class="form-control-lable" name="normal_debit"/>    
                                                    บัตรเครดิด/เดบิต (ค่าธรรมเนียมการชำระเริ่มต้น 3%)
                                                </label>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-control-label">
                                                    <input type="checkbox" class="form-control-lable" name="normal_transfer"/>    
                                                    โอนเงินเข้าบัญชีร้านค้าตรง (ไม่อัพเดตรายการให้อัตโนมัติ ต้องยืนยันรายการด้วยตัวเอง)
                                                </label>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <div class="card w-100">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="text-left">
                                                        <a href="/" id="btn_cancel" class="btn btn-warning mt-3">ยกเลิก</a>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-right">
                                                        <button type="submit" id="submit" class="btn btn-primary mt-3">สมัคร</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                     <!-- บุลคลธรรมดา -->
                     
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\VisaregisCreate','#form_visaregis') !!}

<script type="text/javascript">
    const oldData = JSON.parse(`{!! json_encode(Session::getOldInput()) !!}`)
    const init = (data = null) => {
        const oldData = data
        backData( oldData )
    }

    const backData = (oldData) => {

        if ( oldData === undefined || oldData.length === 0 ) {
            return
        }
        // array item
        const _array = ['operate_firstname', 'operate_surname', 'operate_telephone', 'operate_email']

        Object.keys( oldData ).map(function(objectKey, index) {
            const value = oldData[objectKey]
            if ( Array.isArray( value ) ) {
                if ( _array.indexOf( objectKey ) !== -1 ) {
                    value.forEach( (element, index) => {
                        if ( $(`*[name='${objectKey}[${index}]']`).length === 0  ) {
                            $('.add-wrapper').append( newItem() ) // appendItem
                        }
                        $(`*[name='${objectKey}[${index}]']`).val( element )
                    })
                } else {
                    //
                }
            } else {
                $(`*[name=${objectKey}]`).val( value )
            }
        })
    }

    const removeBtnUpdate = () => {
        const count = $('.clonable').length - 1
        $('.clonable').each(function() {
            if ( $(this).index() === 0 ) {
                return
            } else if ( $(this).index() === count ) {
                if ( $(this).find('.removable').first().length === 0 ) {
                    $(this).find('.row').first().prepend( removeBtn() )
                }
            } else {
                $(this).find('.removable').first().remove()
            }
        })
    }

    const newItem = () => {
        // count whole element
        const count = $('.clonable').length

        // clone the element
        const newItem = $('.clonable').first().clone().off()

        // adding remove button
        newItem.find('.row').first().prepend( removeBtn() )
        console.log('sdsdsdsd  ='+count)
        // change input name
        newItem.find('input').each(function() {
            $(this).attr( 'name', this.name.replace('[0]', `[${count}]`) )
            $(this).val( $(this).data('default') || '' )
            $(this).removeClass('is-valid').removeClass('is-invalid')
        })

        // change toggle wrapper id
        newItem.find('div#item-0').each(function() {
            $(this).attr('id', `item-${count}`)
        })

        // change data-target of toggle button
        newItem.find('*[data-target]').each(function() {
            $(this).attr('data-target', `#item-${count}`)
        })

        newItem.find('*[data-parent]').each(function() {
            $(this).attr('data-parent', `#parent-item-${count}`)
        })

        newItem.find('div.collable-row').each(function() {
            $(this).attr('id', `parent-item-${count}`)
        })

        return newItem
    }

    const removeBtn = () => {
        return `
            <div class="col-12 text-right">
                <button type="button" class="btn btn-outline-danger removable px-1 pb-0 pt-1">
                    <i class="ni ni-fat-remove fa-2x"></i>
                </button>
            </div>
        `
    }

    $(document).ready(function(){
        init(oldData)
        // add new item
        $('#add').on('click', function() {
            
            // append
            $('.add-wrapper').append( newItem() )

            removeBtnUpdate()
        })   

        $('#type1').on('click', function() {
            var type = $('input[id=type1]').val()
            $('#form1').removeClass('d-none');
            $('#form2').addClass('d-none');
            console.log('type => '+type);
        })
        $('#type2').on('click', function() {
            var type = $('input[id=type2]').val()
            $('#form2').removeClass('d-none');
            $('#form1').addClass('d-none');
            console.log('type2 => '+type);
        })

        $(document).on('click', '.removable', function(e) {
            if ( $(this).closest('.clonable').index() !== 0 ) {
                $(this).closest('.clonable').remove()
                removeBtnUpdate()
            } else {
                $(this).remove()
            }
        })

        if(Array.isArray(oldData) && oldData.length == 0){
            $("#type1").trigger("click");
        }
    }) 

    $('select').on("change.select2", function(e) {
        if($(this).val() !== null){
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");

            $(this).parent().find("span.select2-selection.select2-selection--single").addClass("is-valid");
            $(this).parent().find("span.select2-selection.select2-selection--single").removeClass("is-invalid")

            if($(this).parent().find("span.invalid-feedback").length != 0){
                $(this).next().text('');
            }
        }
        else{
            $(this).parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid")
            $(this).parent().find("span.select2-selection.select2-selection--single").addClass("is-invalid")
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        }
    });

    $('select[name="select_sub_district"]').on("change.select2", function(e) {
        if($(this).val() !== null){
            $('input[name="select_zipcode"]').addClass("is-valid");
            $('input[name="select_zipcode"]').removeClass("is-invalid");
            if($('input[name="select_zipcode"]').parent().find("span.invalid-feedback").length != 0){
                $('input[name="select_zipcode"]').next().text('');
                $('input[name="select_zipcode"]').removeClass("is-invalid");
            }
        }
        else{
            $('input[name="select_zipcode"]').removeClass("is-valid");
            $('input[name="select_zipcode"]').addClass("is-invalid");
        }
    });

    $('select[name="corporate_select_province"]').on("select2:selecting", function(e) {
        $('select[name="corporate_select_district"]').val(null).trigger('change');
        $('select[name="corporate_select_sub_district"]').val(null).trigger('change');
        $('input[name="corporate_select_zipcode"]').val(null).trigger('change');
        $('input[name="corporate_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="corporate_select_district"]').on("select2:selecting", function(e) {
        $('select[name="corporate_select_sub_district"]').val(null).trigger('change');
        $('input[name="corporate_select_zipcode"]').val(null).trigger('change');
        $('input[name="corporate_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="corporate_select_sub_district"]').on("select2:selecting", function(e) {
       $('input[name="corporate_select_zipcode"]').val(e.params.args.data.zipcode)
       $('input[name="corporate_zipcode_address"]').val(e.params.args.data.id)
    });

    $('select[name="normal_select_sub_district"]').on("change.select2", function(e) {
        if($(this).val() !== null){
            $('input[name="normal_select_zipcode"]').addClass("is-valid");
            $('input[name="normal_select_zipcode"]').removeClass("is-invalid");
            if($('input[name="normal_select_zipcode"]').parent().find("span.invalid-feedback").length != 0){
                $('input[name="normal_select_zipcode"]').next().text('');
                $('input[name="normal_select_zipcode"]').removeClass("is-invalid");
            }
        }
        else{
            $('input[name="normal_select_zipcode"]').removeClass("is-valid");
            $('input[name="normal_select_zipcode"]').addClass("is-invalid");
        }
    });

    $('select[name="normal_select_province"]').on("select2:selecting", function(e) {
        $('select[name="normal_select_district"]').val(null).trigger('change');
        $('select[name="normal_select_sub_district"]').val(null).trigger('change');
        $('input[name="normalselect__sub_district"]').val(null).trigger('change');
        $('input[name="normal_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="normal_select_district"]').on("select2:selecting", function(e) {
        $('select[name="normal_select_sub_district"]').val(null).trigger('change');
        $('input[name="normal_select_zipcode"]').val(null).trigger('change');
        $('input[name="normal_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="normal_select_sub_district"]').on("select2:selecting", function(e) {
       $('input[name="normal_select_zipcode"]').val(e.params.args.data.zipcode)
       $('input[name="normal_zipcode_address"]').val(e.params.args.data.id)
    });

    function select2_company(elem,type) {
        $(elem).select2({
            placeholder: 'กรุณาระบุ',
            ajax: {
                type: 'POST',
                url: '{{ url('/zipcode_address') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        province: $('select[name="corporate_select_province"').val(),
                        district: $('select[name="corporate_select_district"').val(),
                        locale: 'th',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }

    function select2_normal(elem,type) {
        $(elem).select2({
            placeholder: 'กรุณาระบุ',
            ajax: {
                type: 'POST',
                url: '{{ url('/zipcode_address') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        province: $('select[name="normal_select_province"').val(),
                        district: $('select[name="normal_select_district"').val(),
                        locale: 'th',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }

    function select2_bank(elem,type) {
        $(elem).select2({
            placeholder: 'กรุณาระบุ ธนาคาร',
            ajax: {
                type: 'POST',
                url: '{{ url('/bank') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        bank_name: $('select[name="corporate_bank_name"').val(),
                        locale: 'th',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }

    function select2_bank_normal(elem,type) {
        $(elem).select2({
            placeholder: 'กรุณาระบุ ธนาคาร',
            ajax: {
                type: 'POST',
                url: '{{ url('/bank') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        bank_name: $('select[name="corporate_bank_name"').val(),
                        locale: 'th',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }

    select2_company('select[name="corporate_select_province"]','province');
    select2_company('select[name="corporate_select_district"]','district');
    select2_company('select[name="corporate_select_sub_district"]','sub_district');
    
    select2_normal('select[name="normal_select_province"]','province');
    select2_normal('select[name="normal_select_district"]','district');
    select2_normal('select[name="normal_select_sub_district"]','sub_district');

    select2_bank('select[name="corporate_bank_name"]','bank_name');
    select2_bank_normal('select[name="normal_bank_name"]','bank_name');
     
</script>

@endsection
