<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="keywords" content="">
      <title>History</title>
      <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('assets/images/favicon/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon/favicon-16x16.png') }}">
      <link rel="manifest" href="{{ URL::asset('assets/images/favicon/site.webmanifest') }}">
      <link rel="mask-icon" href="{{ URL::asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#0355bc">
      <meta name="theme-color" content="#0355bc">
      <!-- Bootstrap CSS-->
      <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
      <link rel="preload" href="{{ URL::asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
      <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}"  media="all">
      <link rel="preload" href="{{ URL::asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
      <!-- Check Preload font -->
      <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KdNodVkI.woff2') }}" as="font" crossorigin>
      <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2Kb9odVkI.woff2') }}" as="font" crossorigin>
      <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KbtodVkI.woff2') }}" as="font" crossorigin>
      <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KYNod.woff2') }}" as="font" crossorigin>
      <style type="text/css">
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
         background: url('{{ URL::asset('assets/images/bill.png') }}');
         background-repeat: no-repeat;
         background-position: top right;
         /*background-size: cover;*/
         }
         label,
         p {
            font-size: 18px !important;
         }
         .payment-status {
            color: #1151E7;
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
      </style>
   </head>
   <body>
      <div class="container h-100 custom">
         <div class="row px-4">
            @yield('content')
         </div>
      </div>
      <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
      <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/keyboard_detect.js') }}"></script>
      @yield('script')
   </body>
</html>
<!-- end document-->