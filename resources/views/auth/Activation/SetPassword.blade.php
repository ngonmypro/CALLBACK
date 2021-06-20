@extends('auth.app', ['title' => __('EIPP')])

@section('style')

  
@endsection

@section('content')
	<div class="main-content">

	    <div class="header py-5 py-lg-6 pt-lg-6">
	        <div class="container">
	            <div class="header-body text-center mb-8 mb-lg-7">
	                <div class="row justify-content-center">
	                    <div class="col-lg-8 col-md-9">
	                        <h1 class="text-primary">ENTER VERIFICATION CODE</h1>
	                    </div>
	                </div>

	                @if (\Illuminate\Support\Facades\Session::has('message'))
                        <div class="col-md-12 alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissable text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{session('message')}}</strong>
                            {{ Session::forget('message') }}
                        </div>
                    @endif

	            </div>
	        </div>
        </div>
        
	    <div class="container mt--8 pb-2">
	        <div class="row justify-content-center">
	            <div class="col-lg-6 col-sm-6 col-md-6">
	                <div class="card bg-secondary shadow border-0">
	                    <img class="card-img-top" src="{{ URL::asset('assets/images/card_auth_img_top.png') }}" >
	                    <div class="card-body px-lg-4 py-lg-4">
	                        <form role="form" method="POST" action="{{ URL::to('/verify/activate')}}" id="ativate_form">
                   	 			
                   	 			{!! csrf_field() !!}

                                <input class="form-control" value="{{ $reference }}" name="ref" type="hidden">
                                <input class="form-control" value="{{ $code }}" name="code" type="hidden">

	                            <div class="form-group mb-3">
	                                <div class="input-group">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
	                                    </div>
	                                    <input class="form-control py-4" maxlength="6" name="otp" type="text" pattern="[0-9]*" placeholder="OTP" required>
	                                    <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" id="btn_getotp" style="font-size: 11px;">REQUEST OTP</button>
                                        </div>
                                    </div>
                                    <small class="text-muted py-2" id="otp_reference"></small>
	                            </div>

	                            <div class="form-group">
	                                <div class="input-group input-group-alternative">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
	                                    </div>
	                                    <input class="form-control py-4" type="password" id="password" name="password" autocomplete="new-password" value="{{old('password')}}" placeholder="********">
	                                </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control py-4" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" value="{{old('password_confirmation')}}" placeholder="CONFIRM PASSWORD">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <small class="text-muted py-2">รหัสผ่านต้องมีความยาว 8-20 ตัวอักษร และต้องประกอบไปด้วยตัวอักษรภาษาอังกฤษทั้งตัวเล็ก/ใหญ่ ตัวเลข และอักขระพิเศษ (เช่น !@#$%) อย่างน้อยหนึ่งตัว</small>
                                </div>

	                            <div class="text-center">
	                                <button id="btn-login" type="submit" class="btn btn-primary">Confirm</button>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	                <div class="row mt-3">
	                    <div class="col-12">
	                        <p class="text-center text-white">Powered by Digio (Thailand) CO.,LTD</p>
	                    </div>
	                </div>
	            </div>
	        </div>
        </div>
        
	</div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/request.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>   
    {!! JsValidator::formRequest('App\Http\Requests\ActivatePassword', '#ativate_form'); !!}
    <script type="text/javascript">

        $(document).ready(function() {

            const pwd_pattern =  /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/i;
            
            $(document).on('click', '#btn_getotp', function() {
                $.blockUI()
                $(this).attr('disabled', true)

                // AJAX CALL
                webRequest(
                    'POST',
                    '{{ url("/verify/activate/getotp") }}',
                    {
                        _token: '{{ csrf_token() }}',
                        code: $('input[name=code]').val(),
                        ref: $('input[name=ref]').val(),
                    },
                    function (err, result) {
                        $.unblockUI()

                        if (err) {
                            console.error(JSON.stringify(err))

                            Swal.fire('เกิดข้อผิดพลาด',err.message,'error').then(function() {
                                window.location.reload()
                            })

                        } else {
                            if (!!result.success) {
                                console.log('response: ', result)
                                $('#otp_reference').text(`( ref: ${result.otp_reference || ''} )`)

                                // 30 seconds
                                var timeRemaining = 30
                                const intval = setInterval(() => {
                                    --timeRemaining
                                    // console.log(`time reamining in: ${timeRemaining}`)
                                    $('#btn_getotp').text(`Remaining in ${timeRemaining} s`)

                                    if (timeRemaining == 0) {
                                        clearInterval(intval)
                                        $('#btn_getotp').text('Request OTP')
                                        $('#btn_getotp').attr('disabled', false)
                                    }
                                }, 1000)
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด', result.message, 'error').then(function() {
                                    window.location.reload()
                                })
                            }
                        }
                    }
                )
            })
        })
    </script>
@endsection