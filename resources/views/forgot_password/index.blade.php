@extends('auth.app', ['title' => __('Forgot Password')])

@section('style')
  
@endsection

@section('content')
	<div class="main-content">
	    <div class="header py-5 py-lg-6 pt-lg-6">
	        <div class="container">
	            <div class="header-body text-center mb-8 mb-lg-7">
	                <div class="row justify-content-center">

	                    <div class="col-lg-8 col-md-9">
                            <h1 class="text-primary">{{ __('login.forgot.title') }}</h1>
                            <h2 class="text-gray">{{ __('login.forgot.header') }}</h2>
                        </div>
                        
                        <div class="col-lg-6 col-md-6">
                            @include('components.error')
                        </div>

	                </div>
	            </div>
	        </div>

	    </div>
	    <div class="container mt--8 pb-2">

	        <div class="row justify-content-center">
	            <div class="col-lg-4 col-md-6">
                    
	                <div class="card bg-secondary shadow border-0">
	                    <img class="card-img-top" src="{{ URL::asset('assets/images/card_auth_img_top.png') }}" >
	                    <div class="card-body px-lg-4 py-lg-4">
	                        <form role="form" method="POST" action="{{ action('ForgotPasswordController@submit') }}" id="forgot-form">
                   	 			
                   	 			{!! csrf_field() !!}

	                            <div class="form-group mb-3">
	                                <div class="input-group input-group-alternative">
	                                    <div class="input-group-prepend">
	                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
	                                    </div>
	                                    <input class="form-control py-4" type="text" id="email" name="email" autocomplete="off" data-spec="email" placeholder="Enter Email" robot-test="forgot-username">
	                                </div>
                                </div>
                                
	                            <div class="text-right">
                                <button type="submit" class="btn btn-primary" robot-test="forgot-submit">{{ __('common.send') }}</button>
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
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ForgotPasswordRequest', '#forgot-form'); !!}
    <script type="text/javascript">
        //
    </script>
@endsection