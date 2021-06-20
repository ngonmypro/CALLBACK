@extends('layouts.auth')

@section('style')
<style type="text/css">

</style>
@endsection

@section('content')
    <div class="d-flex align-content-center flex-wrap" style="height: 100%">
        <div class="container align-self-center">
            <div class="card float-right border-0 login-container">
                <form class="form-horizontal" method="POST" action="{{ URL::to('/login')}}" id="login-form">
                    {!! csrf_field() !!}
                    @if (\Illuminate\Support\Facades\Session::has('throw_detail'))
                        <div class="col-md-12 alert alert-danger alert-dismissable text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{session('throw_detail')}}</strong>
                            {{ Session::forget('throw_detail') }}
                        </div>
                    @endif
                    <div class="form-group mb-4">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <img src="{{ URL::asset('assets/images/logo.png') }}" class="align-bottom align-self-center mr-1" alt="..." height="50">
                            </li>
                            <li class="list-inline-item text-white" style="font-size: 38px;font-weight: bold;">BILL</li>
                        </ul>
                    </div>
                    <div class="group-custom form-group">
                        <input id="email" type="text" class="form-control input-with-underline-login" name="username" value="{{old('username')}}" autocomplete="off" onkeypress="return isEmail(event)" data-spec="email">
                        <label>Staff name of Email</label>
                    </div>
                    <div class="group-custom form-group">
                        <input id="password" type="password" class="form-control input-with-underline-login" name="password" autocomplete="off" data-spec="password" value="{{old('password')}}">
                        <label>Password</label>
                    </div>
                    <div class="form-group">
                        <button id="btn-login" type="button" class="btn btn-signin text-white mt-4">SIGN IN <span class="oi oi-arrow-right pl-3"></span></button>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 system_message">
                            <label id="err_mgs" class="login-msg"></label>
                        </div>
                    </div>

                    
                </form>
            </div>
        </div>
        <footer class="login-footer">
            <div class="text-center">
                <span>©2019 All Rights Reserved. Powered by Digio and PCC. |  Version 1.0 </span>
            </div>
            <div class="clearfix"></div>
        </footer>
    </div>
    
    
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login-form'); !!}
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypress(function (event) {
                var keycode = event.keyCode || event.which;
                if (keycode == '13') {
                    $("#btn-login").trigger('click');
                }
            });
            $("#email").focusout(function () {

                var emailinput = $("#email").val();
                const alphanum = /^[a-zA-Z0-9]{6,24}$/gm
                const pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                if (emailinput !== '') {

                    if(!pattern.test(emailinput) && !alphanum.test(emailinput)){
                        $("#email").removeClass("is-valid");
                        $("#email").addClass("is-invalid");
                    }
                    else{
                        $("#email").removeClass("is-invalid");
                        $("#email").addClass("is-valid");
                    }
                }
                else{
                    $("#email").removeClass("is-valid");
                    $("#email").addClass("is-invalid");
                }
            });
        });

        $("#btn-login").on("click" , function(){
            //reset storage
            sessionStorage.setItem("currently_menu", "");

            var email = $("#email").val();
            var password = $("#password").val();

            var checked = "";
            $('.form-custom').each(function() {
                var elem = $(this);
                var required = $(this).val();

                if ((required == '' || required == null)) {
                    $(this).removeClass("is-valid");
                    $(this).addClass("is-invalid");
                } else {
                    if(elem.data("spec") == "email"){
                        var emailinput = elem.val();
                        
                        const alphanum = /^[a-zA-Z0-9]{6,24}$/gm
                        const patternemail = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                        if(emailinput != ''){
                            // alert("email case != ''");
                            if(!patternemail.test(emailinput) && !alphanum.test(emailinput)){
                                // alert("email case fail");
                                elem.removeClass("is-valid");
                                elem.addClass("is-invalid");
                            }
                            else{
                                // alert("email case success");
                                elem.removeClass("is-invalid");
                                elem.addClass("is-valid");
                            }
                        }
                        else{
                            // alert("email case empty");
                            elem.removeClass("is-valid");
                            elem.addClass("is-invalid");
                        }
                    }
                    else{
                        $(this).addClass("is-valid");
                        $(this).removeClass("is-invalid");
                    }

                    $(this).addClass("is-valid");
                    $(this).removeClass("is-invalid");
                }
            });
            
            if ($("body").find(".is-invalid").length == 0) {
                $('#login-form').submit();
            } else {
                return false;
            }
        });

    </script>
@endsection


