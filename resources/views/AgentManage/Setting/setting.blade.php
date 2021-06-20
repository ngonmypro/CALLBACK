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
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">


                                <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">
                                            <span>Permission</span>  
                                        </a>
                                </li>
                        

                                @Permission(CORPORATE_MANAGEMENT.PAYMENT_SETTING)                                
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">
                                            <span>{{__('corpsetting.payment')}}</span>  
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

                              
                                
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                        
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                @include('AgentManage.Setting.Function.permission') 
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            @include('AgentManage.Setting.Function.payment') 
                            </div>

                            <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                    @include('AgentManage.Setting.Function.notify') 
                            </div>

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


    @yield('script.eipp.agent-setting.notify')
    @yield('script.eipp.agent-setting.permission')
    @yield('script.eipp.agent-setting.payment')



@endsection