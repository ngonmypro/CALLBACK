<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <title>PRIM</title>

    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('assets/css/frameworks/open-iconic-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">

    @yield('style')

</head>

 <body id="login-body">
        @yield('content')

    <!-- Jquery JS-->
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.3.1.slim.min.js') }}"></script>

    <!-- Bootstrap JS-->
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/keyboard_detect.js') }}"></script>

    <script type="text/javascript">
       
        

    </script>
    @yield('script')

</body>

</html>
<!-- end document-->