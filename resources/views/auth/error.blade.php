<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <title>Something went wrong</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ URL::asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ URL::asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#0355bc">
    <meta name="theme-color" content="#0355bc">
    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link rel="preload" href="{{ URL::asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    <!-- Check Preload font --->
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KdNodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2Kb9odVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KbtodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KYNod.woff2') }}" as="font" crossorigin>
    <style type="text/css">
        body{
            height: 100vh;
            background: url(../assets/images/graphic_bg.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 100% 100%;
        }
    </style>
</head>

 <body>

    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="w-100 text-center px-4">
            <img src="{{ URL::asset('assets/images/man-thinking.png') }}" class="pl-5 mb-3 img-fluid" width="400">
        </div>
        <div class="w-100 text-center px-4">
            <h1 style="font-size: 36px !important;">Something's wrong here...</h1>
        </div>
        <div class="w-100 text-center px-4">
            <p style="font-size: 24px !important;">{{ $error ?? '' }}</p>
        </div>
        <div class="w-100 text-center px-4">
            <button type="button" class="btn btn-dark" onclick="window.location.href='/'">Home</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
        </div>
    </div>

    <footer class="login-footer">
        <div class="text-center">
            <span>©2019 All Rights Reserved. Powered by Digio and PCC. |  Version 1.0 </span>
        </div>
        <div class="clearfix"></div>
    </footer>

    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>

</body>

</html>
<!-- end document-->