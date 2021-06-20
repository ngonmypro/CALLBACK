@extends('Line.App.layouts')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ion_rangeSlider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        .pin-block > div{
            padding: 1rem;
        }
        .pin-block > div button{
            font-size: 26px;
            color: #000;
            font-weight: bold;
        }
        .magic-radio + label:before, .magic-checkbox + label:before{
            left: 5px !important;
        }
    </style>
@endsection

@section('content')


<div class="d-flex justify-content-center mt-4">
    <div class="col-sm-12 col-md-6">

        @if(isset($config->enable) && $config->enable === true)
            <div class="card mb-4">
                <img id="pictureUrl" width="25%" src="">
                <p id="userId"></p>
                <p id="displayName"></p>
                <p id="statusMessage"></p>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header card-header-img bg-white border-dashed">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <img src="{{ URL::asset('assets/images/virtual_card/ic_card.png') }}" class="img-fluid" alt="..." width="40">
                    </li>
                    <li class="list-inline-item align-middle">
                        <h5 class="color-primary mb-0">ยืนยันผู้ใช้งาน</h5>
                    </li>
                </ul>
                
            </div>
            

                <div id="zone_code" class="card-body pt-3 pb-2">
                    <form id="form_inquiry" action="{{ url('/app',$app_code)}}/line/inquiry" class="pb-4" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <input type="hidden" name="line_id" value="">

                        <div class="form-group">
                            <label>รหัสยืนยันผู้ใช้งาน</label>
                            <input id="recipient_reference" type="text" name="recipient_reference" class="form-control">
                        </div>

                        <button id="confirm_code" type="button" class="btn btn-primary col-12">ยืนยัน</button>
                    </form>
                </div>

                <div id="zone_confirm" class="card-body pt-3 pb-2" style="display: none;">
                    <form id="form_auth" action="{{ url('/app',$app_code)}}/line/auth" class="pb-4" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <input type="hidden" name="line_id" value="Uc2e9817a1ee2ce934962b9b3636829e4">
                        <input type="hidden" name="recipient_reference" value="">

                        <div class="form-group">
                            <label><b>รหัสอ้างอิง</b></label>
                            <p id="ref_code" class="ml-2"></p>
                        </div>    
                        <div class="form-group">
                            <label><b>ชื่อ นามสกุล</b></label>
                            <p id="full_name" class="ml-2"></p>
                        </div>
                        <div class="form-group">
                            <label><b>เบอร์โทรศัพท์</b></label>
                            <p id="telephone" class="ml-2"></p>
                        </div>
                        <div class="form-group">
                            <label><b>อีเมล์</b></label>
                            <p id="email" class="ml-2"></p>
                        </div>
                        <button id="confirm_register" type="button" class="btn btn-primary col-12">ยืนยัน</button>
                    </form>
                </div>
            </form>
        </div>
        
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script>
    function runApp() {
        liff.getProfile().then(profile => {
            @if (env('APP_ENV')!='production' && env('APP_DEBUG')!=false)
                document.getElementById("pictureUrl").src = profile.pictureUrl;
                document.getElementById("userId").innerHTML = '<b>UserId:</b> ' + profile.userId;
                document.getElementById("displayName").innerHTML = '<b>DisplayName:</b> ' + profile.displayName;
                document.getElementById("statusMessage").innerHTML = '<b>StatusMessage:</b> ' + profile.statusMessage;
            @endif
        
            $('input[name="line_id"]').val(profile.userId);

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

    $('#confirm_code').click(function(){
        if($('#form_inquiry').valid()) {
            $.blockUI()
            $('#form_inquiry').submit()
        }
    });

    $('#confirm_register').click(function(){
        if($('#form_auth').valid()) {
            $.blockUI()
            $('#form_auth').submit()
        }
    });

    $('#form_inquiry').submit(function() {

        $(this).ajaxSubmit({
            error: function(data) {
            },
            success:function(response){
                console.log(response)

                if (response.success == true)
                {
                    var data = response.data;

                    $('#ref_code').text(data.recipient_code)
                    $('#full_name').text(data.first_name+' '+data.middle_name+' '+data.last_name)
                    $('#telephone').text(data.telephone)
                    $('#email').text(data.email)

                    $('input[name="recipient_reference"]').val($('#recipient_reference').val())

                    $('#zone_code').toggle();
                    $('#zone_confirm').toggle();
                }
                else
                {
                    Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function() {
                 
                    })
                }
                $.unblockUI()
            }
        });
        return false;
    });
 

    $('#form_auth').submit(function() {

        $(this).ajaxSubmit({
            error: function(data) {
            },
            success:function(response){

                if (response.success == true)
                {
                    $.unblockUI()
                    
                    $('#confirm_register').attr('disabled','disabled');
                    Swal.fire('Register success','','success').then(function() {
                        if (liff.isInClient()) {
                            liff.closeWindow();
                        } 
                    })
                }
                else
                {
                    Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function() {
                 
                    })

                    $.unblockUI()
                }
            }
        });
        return false;
    });
</script>
@yield('script')
@endsection