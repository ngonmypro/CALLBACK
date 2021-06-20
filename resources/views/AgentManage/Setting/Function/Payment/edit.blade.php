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
                                <form id="payment_form" action="{{ url('Manage/Agents/Setting/Function/Update') }}" method="POST" class="form">                             
                                            {{ csrf_field() }}
                                    <div class="card">
                                        <div class="container-fluid py-5">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="channel_name">channel_name </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="channel_name" id="channel_name" value="{{$bank_payment->channel_name}}">
                                                            <input type="hidden" class="form-control" name="check_channel_name" id="check_channel_name" value="{{$bank_payment->channel_name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" class="form-control" name="id"  value="{{$bank_payment->id}}">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="channel_type">channel_type </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-control" id="type"  onchange="Channel(this)" name="channel_type">
                                                                <option value=""  {{($bank_payment->channel_type === null) ? 'selected' : ''}} >PLEASE SELECT</option>
                                                                <option value="CREDIT_CARD"  {{($bank_payment->channel_type === 'CREDIT_CARD') ? 'selected' : ''}} >CREDIT_CARD</option>
                                                                <option value="PROMPT_PAY"   {{($bank_payment->channel_type === 'PROMPT_PAY') ? 'selected' : ''}} >PROMPT_PAY</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-5 text-left">
                                                            <!-- <label for="channel_type">merchant_name </label><span class="text-danger"> *</span> -->
                                                            <label for="merchant_name">merchant_name </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-control" name="merchant_name">
                                                                <option value="" {{($bank_payment->merchant_name === null) ? 'selected' : ''}} >PLEASE SELECT</option>
                                                                <option value="SCHOOL1" {{($bank_payment->merchant_name === 'SCHOOL1') ? 'selected' : ''}} >SCHOOL1</option>
                                                                <option value="DIGIO" {{($bank_payment->merchant_name === 'DIGIO') ? 'selected' : ''}} >DIGIO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6 col-md-6 col-sm-12 mid"> <!-- d-none -->
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="mid">mid </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="number" class="form-control" name="mid" value="{{$bank_payment->mid}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                           

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="tid">tid </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="tid" value="{{$bank_payment->tid}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                               
                                                <div class="col-lg-6 col-md-6 col-sm-12 biller_id">  <!-- d-none --> 
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="biller_id">biller_id </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="number" class="form-control" name="biller_id" value="{{$bank_payment->biller_id}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="key">key </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="key" value="{{$bank_payment->key}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="secret">secret </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="secret" value="{{$bank_payment->secret}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="secret">landing_path </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="landing_path" value="{{$bank_payment->landing_path}}"  placeholder="/payment/tmb/portal">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="secret">payment_url </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="payment_url" value="{{$bank_payment->payment_url}}"  placeholder="https://pgwuat.tau2904.com/TMBPayment/eng/payment/payForm.jsp">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="secret">notify_url </label><span class="text-danger"> *</span>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="notify_url" value="{{$bank_payment->notify_url}}"  placeholder="http://174.138.23.160:8300/api/tmb/notify">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="status">status </label>
                                                        </div>
                                                        <div class="col-9">
                                                        <input type="text" class="form-control" name="status_payment" value="{{$bank_payment->status}}" >
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="ref_1">ref_1 </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="ref_1" value="{{$bank_payment->ref_1}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="ref_2">ref_2 </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="ref_2" value="{{$bank_payment->ref_2}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="ref_3">ref_3 </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="ref_3" value="{{$bank_payment->ref_3}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="ref_4">ref_4 </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="ref_4" value="{{$bank_payment->ref_4}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="ref_5">ref_5 </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="ref_5" value="{{$bank_payment->ref_5}}"> 
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
                                                            <input type="text" class="form-control" name="option_1" value="{{$bank_payment->option_1}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="option_2">option 2</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="option_2" value="{{$bank_payment->option_2}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="option_3">option 3</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="option_3" value="{{$bank_payment->option_3}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="option_4">option 4</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="option_4" value="{{$bank_payment->option_4}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="option_5">option 5</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="option_5" value="{{$bank_payment->option_5}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="field_name_date">field_name_date</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="field_name_date" value="{{$bank_payment->field_name_date}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="field_name_time">field_name_time</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" name="field_name_time" value="{{$bank_payment->field_name_time}}"> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="row p-3">
                                                        <div class="col-4 text-left">
                                                            <label for="cutoff_time">cutoff_time</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <input class="form-control" type="time" value="{{$bank_payment->cutoff_time}}" name="cutoff_time" id="example-datetime-local-input">
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
    <!-- <script type="text/javascript">
        var channel_name = document.getElementsByName("channel_name").value;
        console.log(channel_name)
        console.log('channel_name')

        function Channel() {
        var _type = document.getElementById("type").value;
        if(_type == 'CREDIT_CARD'){
            $(".mid").removeClass("d-none");
            $(".biller_id").addClass("d-none");
        }else{
            $(".mid").addClass("d-none");
            $(".biller_id").removeClass("d-none");
        }
    }
    </script> -->

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>

@endsection