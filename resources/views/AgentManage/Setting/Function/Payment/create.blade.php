@extends('argon_layouts.app', ['title' => __('Corporate Management')])

@section('style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    


    <link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all"> 
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        table.tier-table td{
            border:none;
            padding: 0 .75rem;
        }
    </style>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('corpsetting.corporate_setting')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">


                <div class="card">
                    <div class="card-body">
                        <div class="nav-wrapper">
                           
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div id="" class="row mx-auto mb-4">
                                <div class="col-12 p-0">
                                    <form id="payment_form" action="{{ url('Manage/Agents/Setting/Function/Create') }}" method="POST" class="form">                             
                                    {{ csrf_field() }}
                                            <input type="hidden" name="bank_id" value="{{ $bank_code}}">
                                                <div class="card">
                                                    <div class="container-fluid py-5">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="channel_name">channel_name </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="channel_name" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="channel_type">channel_type </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <select class="form-control" name="channel_type">
                                                                            <option value="">PLEASE SELECT</option>
                                                                            <option value="CREDIT_CARD">CREDIT_CARD</option>
                                                                            <option value="PROMPT_PAY" >PROMPT_PAY</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="merchant_name">merchant_name </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <select class="form-control" name="merchant_name">
                                                                                <option value="">PLEASE SELECT</option>
                                                                                <option value="SCHOOL1">SCHOOL1</option>
                                                                                <option value="DIGIO" >DIGIO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="mid">mid </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="number" class="form-control" name="mid" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="tid">tid </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="tid" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="biller_id">biller_id </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="number" class="form-control" name="biller_id" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="key">key </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="key" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="secret">secret </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="secret" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="secret">landing_path </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="landing_path" value=""  placeholder="/payment/tmb/portal">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="secret">payment_url </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="payment_url" value=""  placeholder="https://pgwuat.tau2904.com/TMBPayment/eng/payment/payForm.jsp">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="secret">notify_url </label><span class="text-danger"> *</span>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="notify_url" value=""  placeholder="http://174.138.23.160:8300/api/tmb/notify">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="status">status </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                    <input type="text" class="form-control" name="status_payment" value="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="ref_1">ref_1 </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="ref_1" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="ref_2">ref_2 </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="ref_2" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="ref_3">ref_3 </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="ref_3" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="ref_4">ref_4 </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="ref_4" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="ref_5">ref_5 </label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="ref_5" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12"></div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="option_1">option 1</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="option_1" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="option_2">option 2</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="option_2" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="option_3">option 3</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="option_3" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="option_4">option 4</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="option_4" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                                <div class="row p-3">
                                                                    <div class="col-4 text-left">
                                                                        <label for="option_5">option 5</label>
                                                                    </div>
                                                                    <div class="col-9">
                                                                        <input type="text" class="form-control" name="option_5" value=""> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="field_name_date">field_name_date</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="field_name_date" value=""> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="field_name_time">field_name_time</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="field_name_time" value=""> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="cutoff_time">cutoff_time</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input class="form-control" type="time" value="" name="cutoff_time" id="example-datetime-local-input">
                                                        </div>
                                                    </div>
                                                </div>


                                                        </div>
                                                    </div>
                                                                            
                                                    <div class="col-12 text-right">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                                                        </div>
                                                    </div>                          
                                                </div>
                                    </form>
                            </div>
                        </div>
</div>


@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AgentSettingPayment','#payment_form') !!}

@endsection
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>


    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/input-validation.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 
<script>
  $('#add').on('click', function() {
            
            // append
            $('.product-wrapper').append( newItem() )

            removeBtnUpdate()
        })
         
        </script>



@endsection