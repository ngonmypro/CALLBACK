@Permission(DASHBOARD.VIEW)
	@if(Session::get('user_detail')->user_type == 'USER')

        <div class="header bg-primary pb-4">
            <div class="container-fluid">

                <div class="header-body">

                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Short cut</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4"></nav>
                        </div>
					</div>

				</div>
					
				<div class="row"> 

					@Permission(BILL.UPLOAD_CONSUMER_BILL)
					<div class="col-xl-3 col-md-6 p-2">
						<div class="short_cut" style=" background-image: url('images/short_cut/bg_yellow.png');" >
							<a href="{{ action('Bill\SimpleCreateController@createNoCorporate') }}">
								<div class="card-body">
									<div>
										<img src="images/short_cut/createbill.png" width="30">
									</div>
									<br>
									<h3 class="text-white">Create Bill</h3>
									<p class="text-white">สร้างบิล</p>
								</div>
							</a>
						</div>
					</div>
				
					<div class="col-xl-3 col-md-6 p-2">
						<div class="short_cut" style=" background-image: url('images/short_cut/bg_blue.png');">
							<a href="{{ action('Bill\UploadController@import') }}">
								<div class="card-body">
									<div>
										<img src="images/short_cut/import.png" width="30">
									</div>
									<br>
									<h3 class="text-white">Import Bill</h3>
									<p class="text-white">สร้างบิล แบบเป็นไฟล์</p>
								</div>
							</a>
						</div>
					</div>
					@EndPermission

					@Permission(BILL.*)
					<div class="col-xl-3 col-md-6 p-2">
						<div class="short_cut" style=" background-image: url('images/short_cut/bg_ocean.png');">
							<a href="{{ action('Bill\UploadController@index') }}">    
								<div class="card-body">
									<div>
										<img src="images/short_cut/management.png" width="30">
									</div>
									<br>
									<h3 class="text-white">Bill Management</h3>
									<p class="text-white">จัดการบิล</p>
								</div>
							</a>
						</div>
					</div>
					@EndPermission

					@Permission(PAYMENT_TRANSACTION.VIEW)
					<div class="col-xl-3 col-md-6 p-2">
						<div class="short_cut" style=" background-image: url('images/short_cut/bg_lightblie.png');">
							<a href="{{ action('PaymentTransactionController@index') }}">    
								<div class="card-body">
									<div>
										<img src="images/short_cut/transaction.png" width="30">
									</div>
									<br>
									<h3 class="text-white">Transaction</h3>
									<p class="text-white">ดูรายการชำระ</p>
								</div>
							</a>
						</div>
					</div> 
					@EndPermission
						
				</div>

        	</div>
		</div>
		
	@endif

@EndPermission
       