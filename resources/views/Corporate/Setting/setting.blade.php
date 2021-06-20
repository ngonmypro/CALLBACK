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

    <input id="corp_code" type="hidden" value="{{$corp_code}}">
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
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                
                                @Permission(CORPORATE_MANAGEMENT.ETAX_CONFIG)
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-8-tab" data-toggle="tab" href="#tabs-icons-text-8" role="tab" aria-controls="tabs-icons-text-8" aria-selected="false">
                                        <span>{{__('corpsetting.etax')}}</span>  
                                    </a>
                                </li>
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE)
                                   {{--  <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">
                                            <span>{{__('corpsetting.customer_fee')}}</span>
                                        </a>
                                    </li> --}}
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.LOAN_SCHEDULE)
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                                            <span>{{__('corpsetting.loan_schedule')}}</span>  
                                        </a>
                                    </li>
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.PAYMENT_SETTING)                                
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                                            <span>{{__('corpsetting.payment')}}</span>  
                                        </a>
                                    </li>
                                @EndPermission                                

                                @Permission(CORPORATE_MANAGEMENT.BRANCH_CONFIG)
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">
                                            <span>{{__('corpsetting.image_logo')}}</span>  
                                        </a>
                                    </li>
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.NOTIFY_CONFIG)
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false">
                                        <span>{{__('corpsetting.notify')}}</span>  
                                    </a>
                                </li>
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.LINE_APP_CONFIG)
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false">
                                        <span>Line</span>  
                                    </a>
                                </li>
                                @EndPermission

                                @Permission(CORPORATE_MANAGEMENT.SHEET_SETTING)                                
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-9-tab" data-toggle="tab" href="#tabs-icons-text-9" role="tab" aria-controls="tabs-icons-text-9" aria-selected="false">
                                        <span>{{__('corpsetting.delivery_form')}}</span>
                                    </a>
                                </li>
                                @EndPermission
                                
                                @Permission(CORPORATE_MANAGEMENT.TEMPLATE_SETTING)
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-10-tab" data-toggle="tab" href="#tabs-icons-text-10" role="tab" aria-controls="tabs-icons-text-10" aria-selected="false">
                                        <span>{{__('corpsetting.template')}}</span>
                                    </a>
                                </li>
                                @EndPermission
                                
                                {{-- @Permission(CORPORATE_MANAGEMENT.FUNCTION_SETTING) --}}
                                @if(\Session::get('user_detail')->user_type === "SYSTEM")
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-11-tab" data-toggle="tab" href="#tabs-icons-text-11" role="tab" aria-controls="tabs-icons-text-11" aria-selected="false">
                                        <span>Function Setting</span>
                                    </a>
                                </li>
                                @endif
                                {{-- @EndPermission --}}
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            {{-- <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab"> --}}
                                @Permission(CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE)
                                    {{-- @include('Corporate.Setting.Function.customer_fee') --}}
                                @EndPermission
                            {{-- </div> --}}
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                @Permission(CORPORATE_MANAGEMENT.LOAN_SCHEDULE)
                                    @include('Corporate.Setting.Function.loan_schedule')
                                @EndPermission
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                @Permission(CORPORATE_MANAGEMENT.PAYMENT_SETTING)                                
                                    @include('Corporate.Setting.Function.payment')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                @Permission(CORPORATE_MANAGEMENT.BRANCH_CONFIG)
                                    @include('Corporate.Setting.Function.image_logo')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                @Permission(CORPORATE_MANAGEMENT.NOTIFY_CONFIG)
                                    @include('Corporate.Setting.Function.notify')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-7" role="tabpanel" aria-labelledby="tabs-icons-text-7-tab">
                                @Permission(CORPORATE_MANAGEMENT.LINE_APP_CONFIG)
                                    @include('Corporate.Setting.Function.line')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-8" role="tabpanel" aria-labelledby="tabs-icons-text-8-tab">
                                @Permission(CORPORATE_MANAGEMENT.ETAX_CONFIG)
                                    @include('Corporate.Setting.Function.etax')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-9" role="tabpanel" aria-labelledby="tabs-icons-text-9-tab">
                                @Permission(CORPORATE_MANAGEMENT.SHEET_SETTING)
                                    @include('Corporate.Setting.Function.sheet')
                                @EndPermission
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-10" role="tabpanel" aria-labelledby="tabs-icons-text-10-tab">
                                @Permission(CORPORATE_MANAGEMENT.TEMPLATE_SETTING)
                                    @include('Corporate.Setting.Function.template')
                                @EndPermission
                            </div>
                            
                            <div class="tab-pane fade" id="tabs-icons-text-11" role="tabpanel" aria-labelledby="tabs-icons-text-11-tab">
                                {{-- @Permission(CORPORATE_MANAGEMENT.FUNCTION_SETTING) --}}
                                @if(\Session::get('user_detail')->user_type === "SYSTEM")
                                    @include('Corporate.Setting.Function.function')
                                @endif
                                {{-- @EndPermission --}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/input-validation.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script>    
        // *********************
        // Global function
        //
        let helper = {}
        helper.isEmpty = (val) => {
            if (val === null || val === '') {
                return true
            } else {
                return false
            }
        }
        helper.isValid = (elem) => {
            const rule = ($(elem).data('rule') || '').toUpperCase().split('|')
            if ($(elem).prop('disabled') === true) {
                return true
            }
            if (!Array.isArray(rule) && rule.length === 0) {
                return false
            }
            return InputValidation([
                {
                    elem: $(elem),
                    data: $(elem).val(),
                    rule,
                    option: {
                        minlength: $(elem).data('minlength') || '',
                        maxlength: $(elem).data('maxlength') || '',
                        length: $(elem).data('length') || ''
                    }
                }
            ])
        }
        helper.switchONOFF = (elem) => {
            $(elem).is(':checked') === true 
                ? $(elem).val('ON')
                : $(elem).val('OFF')
        }
        helper.form_disabled_input = (elem, except, en) => {
            $(elem).each(function() {
                if (except.indexOf($(this).attr('name')) === -1) {
                    $(this).attr('disabled', en)
                }
            })
        }
        helper.MarkValidate = (elem, is_valid) => {
            if (is_valid === true) {
                $(elem).removeClass('is-invalid').addClass('is-valid')
            } else {
                $(elem).removeClass('is-valid').addClass('is-invalid')
            }
        }
        helper.init = () => {
            $('#tabs-icons-text .nav-link').first().trigger('click')
        }
    </script>  
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search)
            const tab = urlParams.get('tab')
            if ( tab !== null ) {
                let openTab = false
                $('#tabs-icons-text .nav-link').each(function(i, obj) {
                    if ( obj.innerText === tab ) {
                        openTab = true
                        $(obj).trigger('click')
                    }
                })
                if ( !openTab ) {
                    helper.init()
                } 
            } else {
                helper.init()
            }

            $('#tabs-icons-text .nav-link').on('click', function() {
                const tabname = $(this).text().trim()
                if ( history.pushState ) { 
                    const path = window.location.search
                    if ( tab ) {
                        window.history.pushState({path}, '', window.location.protocol + "//" + window.location.host + window.location.pathname + `?tab=${tabname}`);
                    } else {
                        window.history.pushState({path}, '', window.location.search + `?tab=${tabname}`);
                    }
                }
            })

        })
    </script>

    @Permission(CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE)
    @yield('script.eipp.corp-setting.customer_fee')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.LOAN_SCHEDULE)
    @yield('script.eipp.corp-setting.loan_schedule')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.PAYMENT_SETTING)
    @yield('script.eipp.corp-setting.payment')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.BRANCH_CONFIG)
    @yield('script.eipp.corp-setting.img_logo')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.NOTIFY_CONFIG)
    @yield('script.eipp.corp-setting.notify')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.ETAX_CONFIG)
    @yield('script.eipp.corp-setting.etax')
    @EndPermission

    @Permission(CORPORATE_MANAGEMENT.SHEET_SETTING)
    @yield('script.eipp.corp-setting.sheet')
    @EndPermission
    
    @Permission(CORPORATE_MANAGEMENT.TEMPLATE_SETTING)
    @yield('script.eipp.corp-setting.template')
    @EndPermission
    
    {{-- @Permission(CORPORATE_MANAGEMENT.FUNCTION_SETTING) --}}
    @if(\Session::get('user_detail')->user_type === "SYSTEM")
    @yield('script.eipp.corp-setting.function')
    @endif
    {{-- @EndPermission --}}
@endsection