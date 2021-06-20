<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>EIPP LINE REGISTER</title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('line_app/eipp/assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"   href="{{ URL::asset('line_app/eipp/assets/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"     href="{{ URL::asset('line_app/eipp/assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"     href="{{ URL::asset('line_app/eipp/assets/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"     href="{{ URL::asset('line_app/eipp/assets/images/favicon/favicon-16x16.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ URL::asset('line_app/eipp/assets/images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">


    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('line_app/eipp/assets/css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('line_app/eipp/assets/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/spinner.css') }}"/>
    <style>
        html , body{
            font-family: 'Prompt', sans-serif;
            color: #495057;
        }
        html , body , .container.custom > .row{
           min-height: 100%;
           height: 100%;
        }
        .group-custom{
            position: relative;
        }
        input.custom-input{
            height: 50px;
            padding-top: 1.375rem;
            padding-bottom: 0;
            padding-left:1.25rem; 
            font-size: 1.2rem;
            color: #495057;
        }
        input.custom-input ~ label{
            position: absolute;
            top: .25rem;
            left: 1.25rem;
            color: #a5a5a5;
            font-size: 1rem;
        }
        body {
            background: url('{{ URL::asset('line_app/eipp/assets/images/BG_Line.png') }}');
            background-repeat: no-repeat;
            background-position: top right;
            /*background-size: cover;*/
        }
        /* Magic Check.css
            -------------------------------------------------- */
            @keyframes hover-color {
              from {
                border-color: #c0c0c0; }
              to {
                border-color: #0065FF; } }

            .magic-radio,
            .magic-checkbox {
              position: absolute;
              opacity: 0; }

            .magic-radio[disabled],
            .magic-checkbox[disabled] {
              cursor: not-allowed; }

            .magic-radio + label,
            .magic-checkbox + label {
              position: relative;
              display: block;
              padding-left: 30px;
              cursor: pointer;
              vertical-align: middle; }
              .magic-radio + label:hover:before,
              .magic-checkbox + label:hover:before {
                animation-duration: 0.4s;
                animation-fill-mode: both;
                animation-name: hover-color; }
              .magic-radio + label:before,
              .magic-checkbox + label:before {
                position: absolute;
                top: 0;
                left: 0;
                display: inline-block;
                width: 20px;
                height: 20px;
                content: '';
                border: 1px solid #c0c0c0; }
              .magic-radio + label:after,
              .magic-checkbox + label:after {
                position: absolute;
                display: none;
                content: ''; }

            .magic-radio[disabled] + label,
            .magic-checkbox[disabled] + label {
              cursor: not-allowed;
              color: #e4e4e4; }
              .magic-radio[disabled] + label:hover, .magic-radio[disabled] + label:before, .magic-radio[disabled] + label:after,
              .magic-checkbox[disabled] + label:hover,
              .magic-checkbox[disabled] + label:before,
              .magic-checkbox[disabled] + label:after {
                cursor: not-allowed; }
              .magic-radio[disabled] + label:hover:before,
              .magic-checkbox[disabled] + label:hover:before {
                border: 1px solid #e4e4e4;
                animation-name: none; }
              .magic-radio[disabled] + label:before,
              .magic-checkbox[disabled] + label:before {
                border-color: #e4e4e4; }

            .magic-radio:checked + label:before,
            .magic-checkbox:checked + label:before {
              animation-name: none; }

            .magic-radio:checked + label:after,
            .magic-checkbox:checked + label:after {
              display: block; }

            .magic-radio + label:before {
              border-radius: 50%; }

            .magic-radio + label:after {
              /*top: 6px;
              left: 6px;
              width: 8px;
              height: 8px;
              border-radius: 50%;
              background: #3e97eb;*/
                  top: -6px;
                left: 11px;
                box-sizing: border-box;
                width: 13px;
                height: 25px;
                transform: rotate(45deg);
                border-width: 4px;
                border-style: solid;
                border-color: #fff;
                border-top: 0;
                border-left: 0; }

            .magic-radio:checked + label:before {
              border: 1px solid #4A2884;
              background: #4A2884; }

            .magic-radio:checked[disabled] + label:before {
              border: 1px solid #c9e2f9; }

            .magic-radio:checked[disabled] + label:after {
              background: #c9e2f9; }

            .magic-checkbox + label:before {
              border-radius: 3px; }

            .magic-checkbox + label:after {
              top: 2px;
              left: 7px;
              box-sizing: border-box;
              width: 6px;
              height: 12px;
              transform: rotate(45deg);
              border-width: 2px;
              border-style: solid;
              border-color: #fff;
              border-top: 0;
              border-left: 0; }

            .magic-checkbox:checked + label:before {
              border: #3e97eb;
              background: #0065FF; }

            .magic-checkbox:checked[disabled] + label:before {
              border: #c9e2f9;
              background: #c9e2f9; }
              
              .cursor-pointer{
                cursor: pointer;
              }
              .card-img-top{
                object-fit: cover;
              }
              .border-radius-10px{
                border-radius: 10px;
              }
              .card{
                -webkit-box-shadow: 0px 0px 2px 0px rgba(150,150,150,1);
                -moz-box-shadow: 0px 0px 2px 0px rgba(150,150,150,1);
                box-shadow: 0px 0px 2px 0px rgba(150,150,150,1);
              }
              .list-group-flush .list-group-item.item-border{
                border-left:6px solid #007FFF;
            }
            .card-content-history{
                border-left: 7px solid #1151E7;
            }
            .template-color{
                color: #1151E7;
            }

            @media only screen and (max-width: 600px) {
            .card-content-history .flex-fill .text-right {
              text-align: left !important;
            }
          }
    </style>

    </head>
    <body>

        {{-- <img src="{{ URL::asset('assets/images/PTTGC.png') }}" class="img-bg"> --}}

        <div class="container h-100 custom">

          {{--   @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert" style="margin-top: 55px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
 --}}
            @yield('content')

        </div>

    </body>
    <script src="{{ URL::asset('line_app/eipp/assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('line_app/eipp/assets/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('line_app/eipp/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>  
    <script type="text/javascript">
        $.blockUI.defaults.message = `<div class="lds-ring"><div></div><div></div><div></div><div></div></div>`
        $.blockUI.defaults.css.border = 'none'
        $.blockUI.defaults.css.backgroundColor = 'transparent'
    </script>
    @yield('script')
</html>