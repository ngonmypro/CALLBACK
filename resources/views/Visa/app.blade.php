<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <title>EIPP Payment System</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ URL::asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ URL::asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
    {{-- <link href="{{ URL::asset('assets/css/css.css') }}" rel="stylesheet" media="all"> --}}
    <link href="{{ URL::asset('assets/css/extensions/magic-check.css') }}" rel="stylesheet" media="all">


    <style type="text/css">
        
        html,
        body {
            background-color: #1b4afc;
        }
        /**/
        .owl-carousel .item img{
            max-width: 150px;
        }
        .owl-stage-outer .owl-stage{
            padding-left: 0px !important;
        }
        .owl-item{
            padding-left: .5rem;
            padding-right: .5rem;
        }
        .owl-item > .item{
            border: 2px solid #ccc;
            border-radius: 5px;
            
        }
        .owl-item > .item > div{
            padding: 1rem !important;
        }
        .owl-item > .item > div h5{
            font-size: 80%;
        }
        .owl-item.active > .item{
            border: 2px solid rgb(50, 116, 245) !important;
        }
        .irs--flat .irs-bar , 
        .irs--flat .irs-from, .irs--flat .irs-to, .irs--flat .irs-single ,
        .irs--flat .irs-handle > i:first-child {
            background-color: #1540FC !important;
        }
        .irs--flat .irs-from:before, .irs--flat .irs-to:before, .irs--flat .irs-single:before{
            border-top-color: #1540FC !important;
        }
        .color-primary{
            color: #1540FC;
        }
        .irs--flat .irs-handle>i:first-child{
            width: 20px !important;
            margin-left: -3px !important;
            border-radius: 50% !important;
        }
        .irs--flat .irs-bar , .irs--flat .irs-line{
            top: 28px !important;
            height: 7px !important;
        }
        .irs--flat .irs-handle.state_hover>i:first-child, .irs--flat .irs-handle:hover>i:first-child{
            background-color: #032199 !important;
        }
        /**/
        .color-primary{
            color: #1540FC !important;
        }
        @media only screen and (max-width: 600px)  {
            .owl-item > .item > div{
                padding: .5rem !important;
            }
        }
        .card-header.card-header-img{
            padding: .75rem 1rem !important;
        }
        .border-dashed{
            border-bottom-style: dashed;
        }
                /**/
            .magic-radio + label:after {
            top: -6px;
            left: 11px;
            box-sizing: border-box;
            width: 0;
            height: 0;
         }

        .magic-radio:checked + label:before {
            border: 1px solid #032199;
            background: #032199; 
        }
        .magic-radio + label:before{
            width: 25px;
            height: 25px;
            border: 1px solid #ccc;
        }
        .btn-pin{
            border: 1px solid #ccc;
            border-radius: 50%;
            /*width: 65px;
            height: 65px;*/
            color: #fff;
            font-size: 24px;
            padding: 10px 22px;
        }
        .pointer-event-none.btn-pin{
           border: none !important; 
        }
        .btn-link.btn-pin:hover , .btn-link.btn-pin:focus {
            color: #fff;
            text-decoration: none;
            background-color: #032199;
            border-color: 2px solid #032199;
        }
        .pin-display + label{
            cursor: none;
        }
        .pointer-event-none{
            pointer-events: none !important;
        }
    </style>
    @yield('style')
</head>

 <body>
    <div class="container px-0 py-0">

    	@yield('content')
        
    </div>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/addComma.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">
       
    </script>
    @yield('script')
</body>

</html>