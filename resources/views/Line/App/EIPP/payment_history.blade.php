@extends('Line.App.EIPP.master')


@section('content')
<div class="container h-100 custom">
    <div class="align-content-center col-12 px-0"> 
        <div class="col-12 px-0 mt-5">
            <div class="media">
                <img src="{{ URL::asset('assets/images/bill_his_iccon.png') }}" class="align-self-start mr-3" alt="...">
                <div class="media-body">
                    <h1 class="mt-0 mb-0">ประวัติการชำระ</h1>
                    {{-- <p class="font-weight-normal">Please scroll down to see more transaction</p> --}}
                </div>
            </div>
        </div>
        <div id="bill_zone" class="col-12 px-0">
            
            
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
            url: "{{ url('/app/line') }}{{ $app_code }}/line/payment_history",
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
                                                <span class="text-muted"><small>`+data.payment_date_time+`</small></span>
                                            </p>
                                            <div class="text-right">
                                                <a href="`+data.receipt_url+`" class="btn btn-sm btn-primary">PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

        $('#bill_zone').append(html)
    }

</script>
@endsection