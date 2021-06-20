@extends('Line.App.EIPP.master')

@section('content')

        <div class="d-flex align-content-center flex-wrap col-12"> 
            <div class="col-12 px-0">
                <h1 class="pt-5">กรุณาชำระบิล</h1>
                <p class="lead mb-4" style="width:17rem;">กรุณา scan qr code ด้านล่าง หรือบันทึกรูปภาพเพื่อชำระ</p>
                <ul class="list-group m-0">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 pl-0">
                        bill reference no.
                        <span id="reference_code" class="">1234567890</span>
                    </li>
                </ul>
            </div>
            <div class="col-12 px-0 py-4">
                
                {{ csrf_field() }}
                <div class="d-flex justify-content-center mb-4">
                    <div class="">
                        <div class="d-flex flex-column">
                            <div class="text-center pb-2">
                                <img src="{{ asset('line_app/eipp/assets/images/PromptPay-banner.jpg') }}" width="300" class="img-fluid">
                            </div>
                            <div id="qr-render" class="qr text-center position-relative" style="width: 300px;height: 300px;">
                                <img id="qr_img" src="" class="img-thumbnail" width="300" height="300">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <ul class="list-inline">
                            <li class="list-inline-item"><span style="font-size: 18px;">ยอดเงิน</span></li>
                            <li class="list-inline-item"><span id="total_amount" class="text-primary font-weight-bold" style="font-size: 28px;">...</span> <span id="currency" style="font-size: 18px;">...</span></li>
                        </ul>
                        <ul class="list-inline">
                            <li class="list-inline-item"><span id="corporate_name" style="font-size: 21px;">...</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-end flex-wrap mb-4"> 
            <div class="col">
                <button id="btn_save" type="button" onclick="save2()" class="btn btn-secondary btn-lg btn-block">บันทึก QR</button>
            </div>
            <div class="col">
                <button id="confirm" type="button" class="btn btn-primary btn-lg btn-block">เสร็จสิ้น</button>
            </div>
        </div>
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script type="text/javascript">
    function runApp() {
        liff.getProfile().then(profile => {
            get_data(profile.userId)
        }).catch(err => console.error(err));
    }
    liff.init({ liffId: "{{ isset($config->auth_liff) ? $config->auth_liff : '' }}" }, () => {
        if (liff.isLoggedIn()) {
            runApp()
        } else {
            @if(isset($config->enable) && $config->enable === false)
                liff.login();
            @endif
        }
    }, err => console.error(err.code, error.message));

    function get_data(line_id)
    {
        $.ajax({
            url: "{{ url('/app/line') }}{{ $app_code }}/line/payment_confirm/{{ $bill_reference }}",
            type: "post",
            data: { 
                _token: '{{ csrf_token() }}',
                app_cde: '{{ $app_code }}',
                line_id: line_id
            },
            success: function (response) {
                console.log(response)
                if(response.success == true)
                {
                    $('#reference_code').text(response.data.bill_payment.reference_code)
                    $('#total_amount').text(response.data.bill_payment.bill_total_amount)
                    $('#currency').text(response.data.bill_payment.currency)
                    $('#corporate_name').text(response.data.corp_info.name_th)
                    $('#qr_img').attr('src','data:image/png;base64,'+response.data.qr)
                }
                $.unblockUI()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function(){})
                $.unblockUI()
            }
        });
    }

    function save2() {
        var gh = $('#qr_img').attr('src')

        var a  = document.createElement('a');
        a.href = gh;
        a.download = 'qr.png';

        a.click()
    }

</script>
@endsection