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
	                        <h1 class="text-primary">ACTIVATE SUCCESS</h1>
	                    </div>
	                </div>
	            </div>
	        </div>

	    </div>
	    <div class="container mt--8 pb-2">
	        <div class="row justify-content-center">
	            <div class="col-lg-6 col-sm-6 col-md-6">
	                <div class="card bg-secondary shadow border-0">
	                    <img class="card-img-top" src="{{ URL::asset('assets/images/card_auth_img_top.png') }}" >
	                    <div class="card-body px-lg-4 py-lg-6 text-center">
	                        <h3 class="text-primary mb-4">คุณได้ทำรายการสำเร็จ </h3>
                            <p>เราจะพาคุณไปยังหน้าหลักเพื่อเข้าสู่ระบบ</p>

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
    <script type="text/javascript">

        $(document).ready(function() {
            setTimeout(() => { 
                window.location.replace('/')
            }, 2000)
        })

    </script>
@endsection