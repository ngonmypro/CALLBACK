@extends('Line.App.EIPP.master')

@section('content')
    <div class="d-flex align-items-start flex-column h-100">
        <div class="mb-auto w-100">
            <div class="col-12">
                <h1 class="pt-5">บิลค้างชำระ</h1>
                <p class="lead mb-4" style="width:17rem;">กรุณาเลือกบิลที่ต้องการชำระ</p>
            </div>
            <div id="section_bill" class="col-12 py-4">
                
            </div>
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
            url: "{{ url('/app/line') }}{{ $app_code }}/line/payment",
            type: "post",
            data: { 
                _token: '{{ csrf_token() }}',
                app_cde: '{{ $app_code }}',
                line_id: line_id
            },
            success: function (response) {
                if(response.success == true)
                {
                    $.each(response.data, function(k, v) {
                        gen_bill_box(k,v)
                    });
                }
                $.unblockUI()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function(){})
                $.unblockUI()
            }
        });
    }

    function gen_bill_box(no,data)
    {
        var html = `<div class="row mb-2 mx-0">
                        <div class="col-12 px-0">
                            <div class="card card-content-history">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap">
                                        <div class="flex-fill">
                                            <p class="mb-1 font-weight-bold">วันครบกำหนด : `+data.bill_due_date_format+`</p>
                                            <p class="mb-1 text-muted">เลขที่ใบแจ้งหนี้ : `+data.invoice_number+`</p>
                                            
                                        </div>
                                        <div class="flex-fill"> 
                                            <p class="text-right mb-1 template-color font-weight-bold">
                                                `+data.bill_total_amount+` `+data.currency+`
                                                <br>
                                            </p>
                                            <div class="text-right">
                                                <a href="{{ url('/app',$app_code) }}/line/payment_confirm/`+data.reference_code+`" class="btn btn-primary">ชำระเงิน</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

        $('#section_bill').append(html)
    }

</script>
@endsection