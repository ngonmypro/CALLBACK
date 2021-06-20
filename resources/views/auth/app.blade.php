<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> EIPP </title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        {{-- Spinner --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/spinner.css') }}"/>
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        @yield('style')
        <style type="text/css">
            
            html {
              height: 100%;
            }
            body {
              min-height: 100%;
            }

            .text-primary {
                color: #4272D7;
            }

            .text-gray {
                color: #ccc;
            }

            .main-body {
                position: relative;
                z-index: 9999;
            }

            .bg {
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                margin: auto;
                z-index: -1;
            }

            .bg .box-top {
                width: 100%;
                height: 15%;
                background-color: transparent;
            }
            .bg .triangle {
                width: 100%;
                height: 65%;
                background: linear-gradient(to bottom right, transparent 0%, transparent 50%, #123abc 50%, #123abc 100%);
            }
            .bg .box-bottom {
                width: 100%;
                height: 20%;
                background-color: #123abc;
            }

            input {
                color: #123abc !important;
                font-size: 1.1rem !important;
            }

        </style>
    </head>
    <body class="main-body g-sidenav-show g-sidenav-pinned">
        
        

        @yield('content')


        <div class="bg">
            <div class="box-top"></div>
            <div class="triangle"></div>
            <div class="box-bottom"></div>
        </div>

        


        {{-- <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 800" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 800 0 800"></polygon>
            </svg>
        </div> --}}

        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/js-cookie/js.cookie.js"></script>
        <script src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
        

        @yield('script')

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

        <script>
            $.blockUI.defaults.message = `<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`
            $.blockUI.defaults.css.border = 'none'
            $.blockUI.defaults.css.backgroundColor = 'transparent'
            
            $(document).ready(function() {
                $(document).on('submit', 'form', function(e) {
                    if ( !e.isDefaultPrevented() ) {
                        $.blockUI()
                    }
                })
            })
        </script>
        
    </body>
</html>