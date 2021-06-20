<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <title>EIPP | Activation User</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ URL::asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ URL::asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#0355bc">
    <meta name="theme-color" content="#0355bc">
    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link rel="preload" href="{{ URL::asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    <!-- Check Preload font --->
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KdNodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2Kb9odVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KbtodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KYNod.woff2') }}" as="font" crossorigin>
    <style type="text/css">
        /* body{
            height: 100vh;
            background: url(../assets/images/dashboard.png) , url(../assets/images/graphic_bg.png);
            background-repeat: no-repeat , no-repeat;
            background-size:  33% , cover;
            background-position: 23% 40% , 100% 100%;
        } */
    </style>
</head>

 <body id="login-body">
   <div class="d-flex align-content-center flex-wrap" style="height: 100%">
        <div class="container align-self-center pl-5">
            <div class="card float-right border-0 login-container">
                @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert" style="margin-top: 55px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ URL::to('/verify/activate')}}" id="setpassword_form">
                    {!! csrf_field() !!}
                    <input class="form-control" value="{{ $reference }}" name="ref" type="hidden">
                    <input class="form-control" value="{{ $code }}" name="code" type="hidden">
                    <div class="form-group mb-4">
                        <ul class="list-inline" style="margin-bottom: 0%;margin-top: 0%;margin-left: 0;;">
                            <li class="list-inline-item">
                               <img src="{{ URL::asset('assets/images/logo_blue.png') }}" class="align-bottom align-self-center mr-1" alt="..." height="50">
                            </li>
                        </ul>
                    </div>
                  
                    @if (isset($required_otp) && $required_otp === true)
                        <div class="form-group mb-4 pb-4">
                            <ul class="list-inline">
                                <li class="list-inline-item text-white" style="font-size: 24px;font-weight: bold;">Enter Verification Code</li>
                            </ul>
                        </div>
                        <div class="group-custom form-group row px-0">
                            <div class="col-8 px-0">
                                <input class="form-control input-with-underline-login kbank" value="" maxlength="6" name="otp" type="text" pattern="[0-9]*" placeholder="" required>
                                <label>OTP <span id="otp_reference"></span></label>
                            </div>
                            <div class="col-4">
                                <button type="button" id="btn_getotp" class="btn btn-signin px-3 text-white align-middle text-center">Request OTP</button>
                            </div>
                        </div>
                    @else
                        <div class="form-group mb-4">
                            <ul class="list-inline">
                                <li class="list-inline-item text-white" style="font-size: 24px;font-weight: bold;">Enter new password</li>
                            </ul>
                        </div>
                    @endif

                    <div class="group-custom form-group">
                        <input class="form-control input-with-underline-login required-field kbank" id="txtPassword" value="" name="password" type="password" placeholder="" require autocomplete="new-password">
                        <label>Password</label>
                    </div>
                    <div class="group-custom form-group">
                        <input class="form-control input-with-underline-login required-field kbank" id="txtPassword_Confirm" value="" type="password" placeholder="" require autocomplete="new-password">
                        <label>Confirm Password</label>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnSubmit" class="btn btn-signin text-white mt-4 pl-2 pr-2">Confirm</button>
                    </div>
                </form>
            </div>
            <footer class="login-footer py-5 pl-0">
                <div class="text-left">
                    <span class="text-black font-weight-bold">COPYRIGHT 2015 DIGIO (THAILAND) CO.,LTD. ALL RIGHTS RESERVED</span>
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    </div>
    <div id="global_modal_alert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="global_modal_alert_header" class="modal-header">

                </div>
                <div id="global_modal_alert_body" class="modal-body">

                </div>
                <div id="global_modal_alert_footer" class="modal-footer justify-content-center border-0">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/keyboard_detect.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/mainFunction.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/request.min.js') }}"></script>
    <script type="text/javascript">
       
        $(document).ready(function() {
            const pwd_pattern =  /^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/i;

            $('input[name=otp]').on("keyup input propertychange paste change focusout", function() {
                if (isNaN($(this).val()) || $(this).val().length !== 6) {
                    $(this).removeClass('is-valid').addClass('is-invalid')
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid')
                }
            })

            $("#txtPassword").on("keyup input propertychange paste change focusout", function(){
                var input = $(this).val()
                $(this).addClass("border-top-0 border-right-0 border-left-0");
                // console.log(pwd_pattern.test(input))
                // console.log(input)
                if(input != '') {

                    if (!pwd_pattern.test(input)) {
                        $(this).addClass("border-danger");
                        $(this).removeClass("border-success");
                    }
                    else {
                        $(this).addClass("border-success");
                        $(this).removeClass("border-danger");
                    }
                }
                else{
                    $(this).addClass("border-danger");
                    $(this).removeClass("border-success");
                }
            });
            
            $("#txtPassword_Confirm").on("keyup input propertychange paste change focusout", function(){
                var input = $(this).val()
                $(this).addClass("border-top-0 border-right-0 border-left-0");
                // console.log(pwd_pattern.test(input))
                // console.log(input)
                if (input != '') {

                    if(!pwd_pattern.test(input)){
                        $(this).addClass("border-danger");
                        $(this).removeClass("border-success");
                    }
                    else{
                        $(this).addClass("border-success");
                        $(this).removeClass("border-danger");
                    }
                }
                else{
                    $(this).addClass("border-danger");
                    $(this).removeClass("border-success");
                }
            });

            // function webRequest(method, url, data, callback, headers = null) {
            $(document).on('click', '#btn_getotp', function() {
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
                        if (err) {
                            console.error(JSON.stringify(err))

                            OpenAlertModal(
                                'เกิดข้อผิดพลาด', 
                                err.message, 
                                '<button type="button" class="btn btn-outline-danger standard-danger-btn pt-2 pb-2 text-white" data-dismiss="modal">Close</button>'
                            )
                            CloseModalCallback(() => {
                                location.reload()
                            })

                        } else {
                            if (result.success == true) {
                                console.log(result)
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
                                console.error(result)

                                OpenAlertModal(
                                    'เกิดข้อผิดพลาด', 
                                    result.message, 
                                    '<button type="button" class="btn btn-outline-danger standard-danger-btn pt-2 pb-2 text-white" data-dismiss="modal">Close</button>'
                                )
                                CloseModalCallback(() => {
                                    location.reload()
                                })
                            }
                        }
                    }
                )
            })

            var body = `<div class="container-fluid py-3">
                        <div class="d-flex justify-content-center pt-4 pb-3">
                            <div class="">
                                <img src="{{ URL::asset('assets/images/error-icon-25252.png') }}" width="50">
                                <!-- <div class="float-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h5 class="text-danger">กรุณาระบุรหัสผ่าน</h5>
                                <p style="letter-spacing: 2px;">กรอกข้อมูลให้ครบถ้วน</p>
                            </div>
                        </div>
                    </div>`

            var match = `<div class="container-fluid py-3">
                        <div class="d-flex justify-content-center pt-4 pb-3">
                            <div class="">
                                <img src="{{ URL::asset('assets/images/error-icon-25252.png') }}" width="50">
                                <!-- <div class="float-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h5 id="err_header" class="text-danger">รหัสผ่านไม่ตรงกัน</h5>
                                <p id="err_body" style="letter-spacing: 2px;">กรุณาระบุรหัสผ่านทั้งสองให้ตรงกัน</p>
                            </div>
                        </div>
                    </div>`
        
            $(document).on("click" , "#btnSubmit" , function(e){
                let is_success = true

                if (isNaN($('input[name=otp]').val()) || $('input[name=otp]').val().length !== 6) {
                    $('input[name=otp]').removeClass('is-valid').addClass('is-invalid')
                    is_success = false
                } else {
                    $('input[name=otp]').removeClass('is-invalid').addClass('is-valid')
                }
                
                if ($('#txtPassword').val().length === 0 || $('#txtPassword_Confirm').val().length === 0) {
                    // console.log('length 0')

                    $(".required-field").each(function(){
                        if($(this).val().length === 0){
                            $(this).addClass("border-top-0 border-right-0 border-left-0 border-danger");
                            $(this).addClass("border-danger");
                            $(this).removeClass("border-success");
                            is_success = false
                        }
                        else{
                            $(this).addClass("border-top-0 border-right-0 border-left-0 border-danger");
                            $(this).removeClass("border-danger")
                            $(this).addClass("border-success")
                        }
                    });
                    OpenAlertModal('', body, '<button type="button" class="btn btn-outline-danger standard-danger-btn pt-2 pb-2 text-white" data-dismiss="modal">Close</button>')
                }
                else {
                    if ($('#txtPassword').val() !== $('#txtPassword_Confirm').val()) {
                        // console.log('pwd1 != pwd2')

                        $(".required-field").each(function(){
                            $(this).addClass("border-top-0 border-right-0 border-left-0 border-danger");
                            $(this).addClass("border-danger");
                            $(this).removeClass("border-success");
                            is_success = false
                        })
                        OpenAlertModal('', match, '<button type="button" class="btn btn-outline-danger standard-danger-btn pt-2 pb-2 text-white" data-dismiss="modal">Close</button>')
                    }
                    else {

                        $(".required-field").each(function(){
                            var input = $(this).val()
                            $(this).addClass("border-top-0 border-right-0 border-left-0")
                            if (input !== '') {
                                if (!pwd_pattern.test(input)) {
                                    $(this).addClass("border-danger");
                                    $(this).removeClass("border-success");
                                    is_success = false
                                } else {
                                    $(this).addClass("border-success");
                                    $(this).removeClass("border-danger");
                                }
                            } else {
                                $(this).addClass("border-danger");
                                $(this).removeClass("border-success");
                                is_success = false
                            }
                        });
                    }
                }

                if (is_success !== true) {
                    e.preventDefault()
                    return false
                } else {
                    $('#setpassword_form').submit()
                }
                                
            });
        })

    </script>


</body>

</html>
<!-- end document-->