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
	                        <h1 class="text-primary">WELCOME TO EIPP PLATFORM</h1>
	                        <h2 class="text-gray">
	                            New Solution of Electronic Invoice
	                            <br/>
	                            Presentment and Payment
	                        </h2>
	                    </div>
	                </div>

                  @if (\Illuminate\Support\Facades\Session::has('throw_success'))
                        <div class="col-md-12 alert alert-success alert-dismissable text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{session('throw_success')}}</strong>
                            {{ Session::forget('throw_success') }}
                        </div>
	                @elseif (\Illuminate\Support\Facades\Session::has('throw_detail'))
                        <div class="col-md-12 alert alert-danger alert-dismissable text-center">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>{{session('throw_detail')}}</strong>
                            {{ Session::forget('throw_detail') }}
                        </div>
                  @endif
	            </div>
	        </div>

	    </div>
	    <div class="container mt--8 pb-2">
	        <div class="row justify-content-center">
	            <div class="col-lg-4 col-md-6">
	                <div class="card bg-secondary shadow border-0">
	                    <img class="card-img-top" src="{{ URL::asset('assets/images/card_auth_img_top.png') }}" >
	                    <div class="card-body px-lg-4 py-lg-4">
	                        <form role="form" method="POST" action="{{ URL::to('/login')}}"  id="login-form">
                   	 			
                   	 			{!! csrf_field() !!}

	                            <div class="form-group mb-3">
	                                <div class="input-group input-group-alternative">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
	                                    </div>
	                                    <input class="form-control py-4" type="text" id="email" name="username" value="{{old('username')}}" autocomplete="off" data-spec="email" placeholder="USERNAME" robot-test="login-username">
	                                </div>
	                            </div>
	                            <div class="form-group">
	                                <div class="input-group input-group-alternative">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
	                                    </div>
	                                    <input class="form-control py-4" type="password" id="password" name="password" autocomplete="off" data-spec="password" value="{{old('password')}}" placeholder="********" robot-test="login-password">
	                                </div>
	                            </div>
	                            <div class="text-center">
	                                <button id="btn-login" type="submit" class="btn btn-primary" robot-test="login-submit">Sign In</button>
                                </div>
                                
                                <div class="text-center mt-3 mb-1">
                                    <span><a href="{{ action('ForgotPasswordController@index') }}" style="font-size:0.8rem;" class="text-muted">{{ __('login.forgot.link') }}</a></span>
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
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login-form'); !!}
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
@endsection