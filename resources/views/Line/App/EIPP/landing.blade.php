@extends('Line.App.EIPP.master')

@section('content')
    <div class="row px-4 pt-5">
        <form id="form_inquiry" action="{{ url('/app',$app_code)}}/line/inquiry" method="POST" enctype="multipart/form-data" style="margin: 0 auto;">

            <div class="d-flex align-content-center flex-wrap col-12"> 
                <div class="col-12 px-0">
                    <h1 class="mt-3">กรอกข้อมูล</h1>
                    <p class="lead mb-4" style="width:17rem;">กรุณากรอกระบุข้อมูลเพื่อทำการลงทะเบียนผู้ใช้ใหม่</p>
                </div>
                <div class="col-12 px-0">
                    
                    {{ csrf_field() }}

                    <input type="hidden" name="line_id" value="">

                    <div class="group-custom form-group">
                        <input id="recipient_reference" name="recipient_reference" type="text" class="form-control custom-input" value="{{ old('reference') }}">
                        <label>หมายเลขอ้างอิงที่ได้จากเจ้าหน้าที่</label>
                    </div>

                </div>
            </div>
            <div class="d-flex align-items-end flex-wrap col-12 mb-4"> 
                <button id="confirm_code" type="button" class="btn btn-primary btn-lg btn-block">ยืนยัน</button>
            </div>
            <div class="d-flex align-items-end flex-wrap col-12 mb-4"> 
                <p class="lead" style="width:17rem;">หรือลงทะเบียนใหม่สำหรับผู้ใช้ใหม่</p>
                <a href="#" class="btn btn-secondary btn-lg btn-block">ลงทะเบียนใหม่</a>
            </div>
        </form>

        <form id="form_auth" action="{{ url('/app',$app_code)}}/line/auth" method="POST" enctype="multipart/form-data" style="margin: 0 auto;display: none;">

            <div class="d-flex align-content-center flex-wrap col-12"> 
                <div class="col-12 px-0">
                    <h1 class="mt-3">กรุณาตรวจสอบข้อมูล</h1>
                    {{-- <p class="lead mb-4" style="width:17rem;">กรุณากรอกระบุข้อมูลเพื่อทำการลงทะเบียนผู้ใช้ใหม่</p> --}}
                </div>
                <div class="col-12 px-0">
                    
                    {{ csrf_field() }}

                    <input type="hidden" name="line_id" value="Uc2e9817a1ee2ce934962b9b3636829e4">
                    <input type="hidden" name="recipient_reference" value="">

                    <div class="group-custom form-group">
                        <input id="ref_code" type="text" class="form-control custom-input" value="" readonly="readonly">
                        <label>รหัสอ้างอิง</label>
                    </div>
                    <div class="group-custom form-group">
                        <input id="full_name" type="text" class="form-control custom-input" value="" readonly="readonly">
                        <label>ชื่อ</label>
                    </div>
                    <div class="group-custom form-group">
                        <input id="telephone" type="text" class="form-control custom-input" value="" readonly="readonly">
                        <label>เบอร์โทรศัพท์</label>
                    </div>
                    <div class="group-custom form-group">
                        <input id="email" type="text" class="form-control custom-input" value="" readonly="readonly">
                        <label>อีเมล์</label>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-end flex-wrap col-12 mb-4"> 
                <button id="confirm_register" type="button" class="btn btn-primary btn-lg btn-block">ยืนยัน</button>
            </div>
            
        </form>
    </div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ asset('line_app/eipp/assets/js/jquery.form.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script type="text/javascript">
    function runApp() {
        liff.getProfile().then(profile => {
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

                    $('#ref_code').val(data.recipient_code)
                    $('#full_name').val(data.first_name+' '+data.middle_name+' '+data.last_name)
                    $('#telephone').val(data.telephone)
                    $('#email').val(data.email)

                    $('input[name="recipient_reference"]').val($('#recipient_reference').val())

                    $('#form_inquiry').toggle();
                    $('#form_auth').toggle();
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
@endsection
