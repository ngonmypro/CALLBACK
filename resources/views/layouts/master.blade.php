<!DOCTYPE html>
<html lang="{{ app()->getLocale('th') }}">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- Title Page-->
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ URL::asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ URL::asset('assets/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#0355bc">
    <meta name="theme-color" content="#0355bc">

    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('assets/css/frameworks/open-iconic-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/extensions/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ URL::asset('assets/css/extensions/magic-check.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}"  media="all">
    <link rel="preload" href="{{ URL::asset('assets/css/style.css') }}" as="style" onload="this.rel='stylesheet'">
    
    <!-- Check Preload font --->
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KdNodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2Kb9odVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KbtodVkI.woff2') }}" as="font" crossorigin>
    <link rel="preload" href="{{ URL::asset('assets/fonts/Prompt/-W__XJnvUD7dzB2KYNod.woff2') }}" as="font" crossorigin>

    <style type="text/css">
        .lang-active{
            opacity: 1;
        }
        .lang-inactive{
            opacity: 0.3;
        }
    </style>
    @yield('style')

</head>
<body id="portal-body">
    <header>
        <nav id="navbar">
            <div id="top-nav" class="d-flex justify-content-between">
                <div class="">
                    <div class="row">
                        <div id="title-header-nav" class="col-12">
                            @if (Request::path() == 'welcome')
                                <img class="d-inline-block ml-4" src="{{ URL::asset('assets/images/logo_blue.png') }}" width="40" style="margin-top: -5px;">
                                <h3 id="breadcrumb-title" class="pt-4 pl-2 pr-4 text-style-1 d-inline-block breadcrumb-title" style="margin-left: 0 !important;"></h3>
                            @else
                            <!-- <div class="d-inline-block">
                                <button class="btn-nav d-none" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-menu"></span>
                                </button>
                            </div> -->
                            <div class="d-inline-block">
                                 <h3 id="breadcrumb-title" class="pt-4 px-4 text-style-1 breadcrumb-title"></h3>
                            </div>



                            @endif
                        </div>
                    </div>
                </div>
                <div class="pt-3 px-2">
                    <ul class="nav">
                        <li class="nav-item px-1">
                            <!-- ******************* SWITCH CORPORATE ******************* -->
                            <div class="btn-group">
                                @if(\Session::has('CORP_LIST') && \Session::has('CORP_CURRENT'))
                                    <button id="corp_current_selected" type="button" class="btn btn-outline-primary light-custom dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Session::get('CORP_CURRENT')['name'] }}
                                    </button>
                                        <div class="dropdown-menu dropdown-menu-right p-0 template-background w-100">
                                            <div class="account-dropdown__body">
                                                @foreach(session('CORP_LIST') as $corp)
                                                @if ($corp['refid'] == Session::get('CORP_CURRENT')['refid'])
                                                    @continue
                                                @endif
                                                <div class="corp-dropdown__item py-2 px-2 draw meet corp_select_switch_item" data-switch-corp="{{ $corp['refid'] }}">
                                                    <div class="d-inline-block overflow-hidden mr-4">
                                                        <p class="mb-0 text-white">
                                                            {{ $corp['name'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <form id="form_switch_corp" method="POST" action="{!! URL::to('/switch/corporate') !!}">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="corp_ref">
                                    </form>
                                @endif
                            </div>
                        </li>
                        <li class="nav-item px-1">
                            <ul class="list-inline pt-2 mx-2">
                                <li class="list-inline-item cursor-pointer {{app()->getLocale() == 'th' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ url('/locale/th')}}'">
                                    <img src="{{ URL::asset('assets/images/region/thailand.png') }}" class="img-fluid" alt="...">
                                </li>
                                <li class="list-inline-item cursor-pointer {{app()->getLocale() == 'en' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ url('/locale/en')}}'">
                                    <img src="{{ URL::asset('assets/images/region/united-states.png') }}" class="img-fluid" alt="...">
                                </li>
                                {{-- <li class="list-inline-item cursor-pointer {{Session::get('locale') == 'th' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ url('/locale/th')}}'">
                                    <img src="{{ URL::asset('assets/images/region/thailand.png') }}" class="img-fluid" alt="...">
                                </li>
                                <li class="list-inline-item cursor-pointer {{Session::get('locale') == 'en' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ url('/locale/en')}}'">
                                    <img src="{{ URL::asset('assets/images/region/united-states.png') }}" class="img-fluid" alt="...">
                                </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item px-1">
                            <div class="dropdown d-inline-block dropleft">
                                <div class="card-img-top d-inline rounded-circle wh-profile" data-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" id="mini_profile_img">
                                        <g transform="translate(20, 20)">
                                            <circle r="19" stroke="grey" stroke-width="2" fill="none" />
                                            <text font-size=".9em" stroke="grey" fill="grey" stroke-width="2px" dy=".2em" text-anchor="middle" alignment-baseline="middle">{{ strtoupper(substr(session('user_detail')->username, 0, 3)) }}</text>
                                        </g>
                                    </svg>
                                </div>
                                <div class="dropdown-menu py-0 border-0">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <h5>{{ session('user_detail')->username }}</h5>
                                            @if (isset(Session::get('user_detail')->role))
                                                <small class="d-block text-muted pb-1" style="font-size: 10px;">{{ join(', ', Session::get('user_detail')->role) }}</small>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            {{-- <img src="{{ URL::asset('assets/images/avatar-01.jpg') }}" class="card-img-top rounded-circle w-50 pb-2" alt="..." > --}}
                                            <div class="rounded-circle w-auto mx-auto pb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="mini_profile_img">
                                                    <g transform="translate(50, 50)">
                                                        <circle r="49" stroke="grey" stroke-width="2" fill="none" />
                                                        <text font-size="2em" stroke="grey" fill="grey" stroke-width="2px" dy=".2em" text-anchor="middle" alignment-baseline="middle">{{ strtoupper(substr(session('user_detail')->username, 0, 3)) }}</text>
                                                    </g>
                                                </svg>
                                            </div>
                                            <a href="/logout" class="list-group-item list-group-item-action">{{__('leftmenu.sign_out')}} <span class="oi oi-account-logout float-right"></span></a>
                                        </div>
                                        <div class="card-footer text-muted px-1">
                                            @if (isset(session('user_detail')->iat))
                                                <h5>Login Time : <span id="timecount">{{ date('H:i:s', session('user_detail')->iat) }}</span></h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            {{-- @if (Request::path() != 'welcome') --}}
            <div id="menu" class="menu-position nav-container theme-target" data-visible="visible">
                <div id="menu-content" class="d-flex px-4 pb-2">
                    <div class="w-100">
                        <img src="{{ URL::asset('assets/images/logo_blue.png') }}" width="40">
                        <a class="text-black align-middle pl-2 font-24px" href="{{ url('/') }}">{{__('leftmenu.main_title')}}</a>
                    </div>
                    <!-- <div class="flex-shrink-1">
                        <button class="btn-nav" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-menu"></span>
                        </button>
                    </div> -->
                </div>
                <div class="d-flex align-content-around flex-wrap justify-content-start pb-3">
                    <div class="col-12 col-xl-12 py-2">
                        <div class="card text-center border-0">
                            <div class="card-body p-1">
                                {{-- <img src="{{ URL::asset('assets/images/avatar-01.jpg') }}" class="card-img-top rounded-circle w-50 pb-2" alt="..." > --}}
                                <div class="rounded-circle w-auto mx-auto pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="mini_profile_img">
                                        <g transform="translate(50, 50)">
                                            <circle r="49" stroke="grey" stroke-width="2" fill="none" />
                                            <text font-size="2em" stroke="grey" fill="grey" stroke-width="2px" dy=".2em" text-anchor="middle" alignment-baseline="middle">{{ strtoupper(substr(session('user_detail')->username, 0, 3)) }}</text>
                                        </g>
                                    </svg>
                                </div>
                                <h5 class="username mb-1">{{ session('user_detail')->username }}</h5>
                                <a href="/logout" class="text-style-3">{{__('leftmenu.login_time')}}</a>
                            </div>
                        </div>
                    </div>

                    @include('layouts.leftside_menu')
                </div>
            </div>
            {{-- @endif --}}
        </nav>
    </header>

    <!-- Begin page content -->
    <main role="main">

        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert" style="margin-top: 55px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get('message') }}
            </div>
        @elseif ($errors->any())
            <div class="alert alert-danger" role="alert" style="margin-top: 55px;">
                <div class="mb-2">
                    <span>{{ (__('validation.custom.input_invalid')) }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><small>{{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
    <div class="portal-footer py-3">
        <div class="d-flex justify-content-end pr-5">
            <div class="text-center">
                <span>{{__('leftmenu.footer')}}</span>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <section>
        <div id="global_modal_alert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div id="global_modal_alert_header" class="modal-header">

                    </div>
                    <div id="global_modal_alert_body" class="modal-body">

                    </div>
                    <div id="global_modal_alert_footer" class="modal-footer justify-content-center border-0">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <footer id="footer" class="login-footer theme-target" style="margin-top: 60px;">
        <div class="text-center">
            <span>©2019 All Rights Reserved. Powered by Digio and PCC. |  Version 1.0 </span>
        </div>
        <div class="clearfix"></div>
    </footer> -->

    <!-- Jquery JS-->
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
    <!-- <script src="{{ URL::asset('assets/js/frameworks/jquery-1.11.0.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/jquery.mask.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/addComma.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/keyboard_detect.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/mainFunction.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/ajaxWatcher.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('assets/js/extensions/request.min.js') }}"></script>
    <!-- <link rel="preload" href="{{ URL::asset('assets/js/extensions/leftMenu.js') }}" as="script"> -->

    <script type="text/javascript">
        var usedLaterScript = document.createElement('script');
        usedLaterScript.src = "{{ URL::asset('assets/js/extensions/leftMenu.js') }}";
        document.body.appendChild(usedLaterScript);
    </script>

    @yield('script')

</body>

</html>
