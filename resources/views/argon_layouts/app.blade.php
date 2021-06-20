<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> E-Tax Demo </title>
        <!-- Favicon -->
        {{-- <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png"> --}}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
        <link type="text/css" href="{{ asset('argon') }}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">

        {{-- Spinner --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/spinner.css') }}"/>

        <!--Custom CSS --->
        @if(isset(Session::get('BANK_CURRENT')['name_en']) && Session::get('BANK_CURRENT')['name_en'] == 'TMB')
        <link type="text/css" href="{{ asset('argon') }}/css/custom-theme.css?v=0.0.1" rel="stylesheet">
        @endif
        <style type="text/css">
            .bg-primary { background-color: #4272D7 !important }
            .select2-container .select2-selection--single {
                height: calc(2.75rem + 2px) !important;
            }
            .select2-container--default .select2-selection--single {
                border: 1px solid #dee2e6 !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #8898aa !important;
            }
            @media (min-width: 992px){
                .modal-lg, .modal-xl {
                    max-width: 800px;
                }
            }
            @media (min-width: 1200px){
                .modal-xl {
                    max-width: 1140px;
                }
            }

            .dataTables_info,
            .dataTables_paginate {
                margin: 20px 0 !important; 
            }

            .cursor-pointer {
                cursor: pointer;
            }

            .lang-inactive {
                opacity: 0.5;
            }

            .lang-active {
                opacity: 1;
            }
            .header-body > .row > div:first-child{
              min-height: 43px;
            }
            li.branch-item div.d-flex div:nth-child(1) > div:nth-child(1) > span{
                top: .75rem !important; 
                left: 1.2rem;
                color: #2B7EFF !important; 
            }
            li.branch-item div.d-flex > div:nth-child(1) > div:nth-child(1) > div{
                height: 50px !important; 
                width: 50px !important; 
                border: 2px solid #2B7EFF !important; 
            }
            li.branch-item div.d-flex div:nth-child(1) > div:nth-child(1) > p{
                font-size: 14px !important;
                color: #979797 !important; 
            }
            li.branch-item div.d-flex div:nth-child(2) i{
                cursor: pointer !important;
            }
            a.nav-link.active{
              color: #007abc !important;
              font-weight: bold !important;
            }
            .navbar-vertical .navbar-nav .nav-link.active{
              background: #f6f9fc;
              margin-right: .5rem;
              margin-left: .5rem;
              padding-right: 1rem;
              padding-left: 1rem;
              border-radius: .375rem;
            }
            .navbar-light .navbar-nav .nav-link{
                color: rgba(0, 0, 0, .9) !important;
            }
        </style>
        
        @yield('style')
    </head>
    <body class="{{ $class ?? '' }} ">
        
        @include('argon_layouts.navbars.sidebar')
        
        <div class="main-content">
            @include('argon_layouts.navbars.navbar')
                
                @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text">{{ Session::get('message') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="mb-2">
                            <span class="alert-text">{{ (__('validation.custom.input_invalid')) }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
        
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><small>{{ $error }}</small></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            @if ( env('APP_ENV', '') === 'local' && env('APP_DEBUG', false) === true )
            <div class="saf" id="asfasfaf">
                <div class="card">
                    <div class="card-header" id="abc11124">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#askjfh12414"
                                aria-expanded="true" aria-controls="askjfh12414">
                                Session Data
                            </button>
                        </h2>
                    </div>
            
                    <div id="askjfh12414" class="collapse" aria-labelledby="abc11124" data-parent="#asfasfaf">
                        <div class="card-body">
                            <pre>{{ json_encode(Session::all(), JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @yield('content')

        </div>

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/js-cookie/js.cookie.js"></script>
        <script src="{{ asset('argon') }}/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/lavalamp/js/jquery.lavalamp.min.js"></script>
        <!-- Optional JS -->
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
        <script src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/ajaxWatcher.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/lodash.min.js') }}"></script>
        <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>   
        <script src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/leftMenu.js') }}"></script>

        @yield('script')

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        <script>
            _.ucwords = (str, regex = null) => {
                if (regex) {
                    return _.upperFirst(str.toLowerCase().replace(regex, ' '))
                } else {
                    return _.upperFirst(str.toLowerCase().replace(/[^a-zA-Z0-9]/g, ' '))
                }
            }
            _.isURL = (str) => {
                const pattern = new RegExp(/[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi)
                return !!pattern.test(str)
            }
            _.isJSON = (str) => {
                try {
                    var obj = JSON.parse(str)
                    if (obj && typeof obj === 'object' && obj !== null) {
                        return true
                    }
                } catch (err) {}
                return false
            }
            $.fn.serializeObject = function() {
                var o = {}
                var a = this.serializeArray()
                $.each(a, function() {
                    if (o[this.name]) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]]
                        }
                        o[this.name].push(this.value || '')
                    } else {
                        o[this.name] = this.value || ''
                    }
                })
                return o
            }
        </script>
        <script>
            $.blockUI.defaults.message = `<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`
            $.blockUI.defaults.css.border = 'none'
            $.blockUI.defaults.css.backgroundColor = 'transparent'

            $(document).ready(function() {
                $(document).on('click', '.corp_select_switch_item', function() {
                    $.blockUI()
                    $('input[name=corp_ref]').val( $(this).data('switch-corp') )
                    $('#form_switch_corp').submit()
                })
                $(document).on('submit', 'form', function(e) {
                    if ( !e.isDefaultPrevented() ) {
                        $.blockUI()
                    }
                })
            })
        </script>
        
    </body>
</html>