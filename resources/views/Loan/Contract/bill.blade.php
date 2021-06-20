<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
    <style> 
    /*ต้องสร้างโฟลเดอร์ชื่อ fonts ใน storage ก่อนนะครับ*/
        /*ข้อควรระวัง
            ในการสร้าง pdf ครั้งแรกมันจะสร้างได้ช้าพอสมควรเนื่องจากมันต้องไป download 
            font มา (จากเครื่องตัวเองนั่นแหละ) จากนั้นมาแปลง fonts เป็น format ของมัน
            และ cache ลงใน storage/fonts ทำให้ครั้งแรกช้ากว่าปกติพอสมควร แต่หลังจาก
            นั้นจะความเร็วปกติ (เพราะ cache ไว้แล้ว)*/
    @font-face {
      font-family: 'Prompt';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: local('Prompt'), local('Prompt-Regular'), url("{{ public_path('assets/fonts/Prompt/Prompt-Regular.ttf') }}") format('truetype');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    body{
        font-family: "Prompt";
        height: 100%;
        min-width: 100%;
    }
    html { 
        position: relative;
        height: 100%;
        min-height: 100%;
        min-width: 100%;
        font-family: 'Prompt', sans-serif !important;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    ul{
        list-style-type: none;
        padding-left: 0;
    }
    ul.main-ul{
        padding-left: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    ul.main-ul > li:last-child{
        /*border-bottom: 2px solid #ddd;*/
    }
    li{
        font-size:14px;
        margin-top: 0;
        margin-bottom: 0;
    }
    ul.sub-ul li{
        padding-left: 0;
        
    }
    .title{
        color: #3C9FD2;
    }
    .main-block{
        display: inline-block;
        width: 50%;
        padding: 0;
        padding-top: 5em;
    }
    @keyframes hover-color {
    from {
    border-color: #c0c0c0; }
    to {
    border-color: #0065FF; } }

    .magic-checkbox {
    position: absolute;
    opacity: 0; 
    }
    .magic-checkbox + label {
    position: relative;
    display: block;
    padding-left: 30px;
    cursor: pointer;
    vertical-align: middle;
    }

    .magic-checkbox + label:before {
    position: absolute;
    top: 5px;
    left: 0;
    display: inline-block;
    width: 20px;
    height: 20px;
    content: '';
    border: 1px solid #c0c0c0;
    }
    .magic-checkbox + label:before {
    border-radius: 3px; 
    }

    input[type="checkbox"]{
    visibility: hidden;
    }
    .main-container{
        position: relative;
        padding: 3em 0;
        display: block;
    }
    .main-content{
        width:100%;
        float:left;
        clear:none;
        padding:0;margin:0;
    }
    .text-left{
        text-align: left;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    .address-spacing{
        padding: 0px 10px 0px 0px;
        line-height: 10px;
    }
    .mt-minus-1em{
        margin-top: -1em;
    }
    .mb-0{
        margin-bottom: 0;
    }
    .mt-minus-5px{
        margin-top: -5px;
    }
    .d-inline-block{
        display: inline-block;
    }
    .w-100{
        width: 100%;
    }
    .pb-5px{
        padding-bottom: 5px;
    }
    .border-bottom{
        border-bottom: 2px solid #ddd;
    }
    .font18px{
        font-size: 18px;
    }
    .font14px{
        font-size: 14px;
    }
    .font12px{
        font-size: 12px;
    }
    .mt-minus-8px{
        margin-top: -8px;
    }
    .h-25px{
        height: 25px;
    }
    .float-left{
        float: left;
    }
    .float-right{
        float: right;
    }
    .mt-minus-15px{
        margin-top: -15px;
    }
    .mt-15px{
        margin-top: 15px;
    }
    .d-block{
        display: block;
    }
    .mt-minus-26em{
        margin-top: -26em;
    }
    .border-top{
        border-top:2px solid #ddd;
    }
    .pb-0{
        padding-bottom: 0;
    }
    .message-top{
        position:absolute;
        margin-bottom: 0;
        right: 0;
        margin-top: -2.3em;
    }
</style>


<body>
    <div class="main-container">
        <div class="main-content">
            <div id="left" class="main-block" style="margin-bottom: 2em;">
                <ul class="main-ul">
                    <li>
                        <ul>
                            <li>
                                <p class="text-left">
                                    <img src="{{ public_path('assets/images/logo-Nsquared.png') }}" width="100" />
                                </p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                <p class="text-left address-spacing">
                                    บริษัท ดิจิโอ (ประเทศไทย) จำกัด  สาขาสำนักงานใหญ่ <br /> 
                                    ที่อยู่ 972/1 อาคารวรสุบิน ชั้น 4 ซอยโรงพยาบาลพระราม 9 
                                    ถนนริมคลองสามเสน แขวงบางกะปิ  เขตห้วยขวาง  กรุงเทพมหานคร  10310 
                                    เลขประจำตัวผู้เสียภาษี  0105555037693 
                                </p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li class="mt-minus-1em">
                                <p class="title text-left mb-0">Client</p>
                                @if (isset($data['customer']['firstname_th']) && isset($data['customer']['firstname_th']))
                                    <p class="text-left mb-0 mt-minus-5px">คุณ {{ $data['customer']['firstname_th'] }} {{ $data['customer']['surname_th'] }}</p>
                                @else
                                    <p class="text-left mb-0 mt-minus-5px">คุณ {{ $data['customer']['firstname_en'] }} {{ $data['customer']['firstname_en'] }}</p>
                                @endif
                                <p class="text-left mb-0 mt-minus-5px">
                                    819/142 Sathupradit 54 Road.
                                </p>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="right" class="main-block" style="margin-bottom: 2em;">
                <ul class="main-ul">
                    <li>
                        <ul class="sub-ul">
                            <li class="with-border d-inline-block w-100 text-left pb-5px border-bottom">
                                <h1 class="title font18px mb-0">Invoice</h1>
                                <p class="title font14px mt-minus-8px">Copy (Set Document)</p>
                            </li>
                            <p class="message-top">-- สำหรับพนักงาน --</p>
                            <div class="float-right text-center" style="padding-right: 2.3em;">
                                <img src="data:image/png;base64,{{ $data['qr_contract_code'] }}" width="70">
                            </div>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="title d-inline-block float-left">Document No.</div>
                                <div class="float-right d-inline-block">{{ $data['bill_reference_id'] }}</div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="title d-inline-block float-left">Contract No.</div>
                                <div class="float-right d-inline-block">{{ $data['contract_code'] }}</div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="title d-inline-block float-left">Due Date</div>
                                <div class="float-right d-inline-block">{{ $data['bill_due_date'] }}</div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li class="border-bottom mt-15px mb-0"> 
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul mt-minus-15px w-100 h-25px">
                            <li> 
                                <div class="title d-inline-block float-left">Contact</div>
                                <div class="float-right d-inline-block">Digio Customer</div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li> 
                                <div class="title d-inline-block float-left">Phone</div>
                                <div class="float-right d-inline-block">02-987-0980</div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li> 
                                <div class="title d-inline-block float-left">Email</div>
                                <div class="float-right d-inline-block">customer@digio.co.th</div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="d-block w-100 mt-minus-26em">
                <ul class="main-ul border-top">
                    <li>
                        <ul class="sub-ul mb-0 pb-0">
                            <li class="with-border d-inline-block text-center" style="width:30px;padding-right:15px;">
                                <p class="mt-minus-8px font14px mb-0">#</p>
                            </li>
                            <li class="with-border d-inline-block text-left" style="width:530px;">
                                <p class="mt-minus-8px font14px mb-0">Description</p>
                            </li>
                            <li class="with-border d-inline-block text-right" style="width:100px;">
                                <p class="mt-minus-8px font14px mb-0">Total</p>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                <ul class="main-ul border-top">
                    @if (isset($data['items']) && count($data['items']) > 0)
                        
                        <?php $i = 1; ?>
                        @foreach ($data['items'] as $item)
                            <li>
                                <ul class="sub-ul mb-0 pb-0">
                                    <li class="with-border text-center d-inline-block" style="width:30px;padding-right:15px;">
                                        <p class="mt-minus-8px font14px mb-0">{{ $i }}</p>
                                    </li>
                                    <li class="with-border d-inline-block text-left" style="width:530px;">
                                        <p class="mt-minus-8px font14px mb-0">{{ $item['item_name'] }}</p>
                                    </li>
                                    <li class="with-border d-inline-block text-right" style="width:100px;">
                                        <p class="mt-minus-8px font14px mb-0">{{ number_format($item['item_price'], 2, '.', ',') }}</p>
                                    </li>
                                </ul>
                            </li>

                            <?php $i++ ?>
                        @endforeach
                    @endif
                </ul>
                
                <!-- Total vat excluding-->
                <ul class="main-ul border-top" style="padding-top: 1em;padding-bottom: .75em;">
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="d-inline-block float-left">
                                    <ul class="sub-ul mb-0 pb-0">
                                        <li class="">
                                            <p class="mt-minus-8px font14px mb-0">({{ $data['word_total_amount'] }} baht )</p>
                                        </li>
                                    </ul>
                                        
                                </div>
                                <div class="float-right d-inline-block">
                                    <ul class="sub-ul mb-0 pb-0">
                                        <li class="with-border d-inline-block text-right" style="width:78%;">
                                            <p class="title mt-minus-8px font14px mb-0">Total</p>
                                        </li>
                                        <li class="with-border d-inline-block text-right" style="width:20%;">
                                            <p class="mt-minus-8px font14px mb-0">{{ number_format($data['total_amount'], 2, '.', ',') }} THB</p>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-ul" style="margin-top: 0em;">
                    <li>
                        <ul class="sub-ul" style="width: 100%;height:200px;max-height: 200px;overflow: hidden">
                            <li>
                                <div class="d-inline-block float-left">
                                    <p class="title mt-minus-8px font14px mb-0">Remarks</p>
                                    <p class="mt-minus-8px font12px mb-0">ผ่อนชำระเป็นจำนวน {{ $data['contract_period'] }} งวด กำหนดชำระในทุกวันที่ {{ $data['bill_due_date'] }} ของทุกเดือน</p>
                                </div>
                                <div class="float-right d-inline-block">
                                    <p class="mb-0" style="padding-left: 1.8em;">-- สำหรับลูกค้า --</p>
                                    <img src="data:image/png;base64, {{ $data['qr_payment'] }}" width="160" height="160" />
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-ul" style="margin-top: 1em;">
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="d-inline-block">
                                    <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;margin-right: 15px;">Payment Received by:</p>
                                </div>
                                <div class="d-inline-block">
                                    <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;margin-right: 15px;">
                                        <input type="checkbox" class="magic-checkbox" />
                                        <label style="">Cash</label>
                                    </p>
                                </div>
                                <div class="d-inline-block">
                                    <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;margin-right: 15px;">
                                        <input type="checkbox" class="magic-checkbox" />
                                        <label style="">Cheque</label>
                                    </p>
                                </div>
                                <div class="d-inline-block">
                                    <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;margin-right: 15px;">
                                        <input type="checkbox" class="magic-checkbox" />
                                        <label style="">Transfer</label>
                                    </p>
                                </div>
                                <div class="d-inline-block">
                                    <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;margin-right: 15px;">
                                        <input type="checkbox" class="magic-checkbox" />
                                        <label style="">Credit Card</label>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="main-ul" style="margin-top: .5em;">
                    <li>
                        <ul class="sub-ul mb-0 pb-0">
                            <li class="with-border" style="display: inline-block;width:150px;text-align: left;padding-right:15px;border-bottom: 1px solid #ccc;">
                                <p class="mt-minus-8px font14px mb-0">Bank</p>
                            </li>
                            <li class="with-border" style="display: inline-block;width:150px;text-align: left;border-bottom: 1px solid #ccc;">
                                <p class="mt-minus-8px font14px mb-0">Number</p>
                            </li>
                            <li class="with-border" style="display: inline-block;width:150px;text-align: left;border-bottom: 1px solid #ccc;">
                                <p class="mt-minus-8px font14px mb-0">Date</p>
                            </li>
                            <li class="with-border" style="display: inline-block;width:200px;text-align: left;border-bottom: 1px solid #ccc;">
                                <p class="mt-minus-8px font14px mb-0">Amount</p>
                            </li>
                        </ul>
                    </li>
                </ul>
                {{-- <ul class="main-ul" style="margin-top: .5em;">
                    <li>
                        <ul class="sub-ul w-100 h-25px">
                            <li>
                                <div class="d-inline-block float-left">
                                    Test
                                </div>
                                <div class="float-right d-inline-block">
                                    <p class="mt-minus-8px font14px mb-0">บริษัท เอ็น-แสควร์ อีคอมเมิร์ซ จำกัด</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul> --}}
                <ul class="main-ul" style="margin-top: 1em;">
                    <li>
                        <ul class="sub-ul mb-0 pb-0">
                            <li class="with-border d-inline-block text-left" style="width:150px;margin-right:15px;border-bottom: 1px solid #ccc;">
                                <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;position: absolute;top:5px;padding-left: 4em;">Paid By</p>
                            </li>
                            <li class="with-border d-inline-block text-left" style="width:150px;border-bottom: 1px solid #ccc;margin-right:15px;">
                                <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;position: absolute;top:5px;padding-left: 4em;">Date</p>
                            </li>
                            <li class="with-border d-inline-block text-left" style="width:150px;border-bottom: 1px solid #ccc;margin-right:15px;">
                               <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;position: absolute;top:5px;padding-left: 2.5em;">Collected By</p>
                            </li>
                            <li class="with-border d-inline-block text-left" style="width:150px;border-bottom: 1px solid #ccc;margin-right:15px;">
                                <p style="margin-top: -8px;font-size: 14px;margin-bottom: 0;position: absolute;top:5px;padding-left: 4em;">Date</p>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <img src="{{ public_path('assets/images/head_invioce.png') }}" style="width:120%;height: 150px;position: absolute;top: -1rem;z-index: -9999;margin-left: -3rem">
    <img src="{{ public_path('assets/images/foot_invoice.png') }}" style="width:120%;height: 150px;position: absolute;bottom: -1rem;z-index: -9999;margin-left: -3rem">
</body>
</html>