<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand border-bottom navbar-dark bg-primary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center ml-md-auto">
                <li class="nav-item d-xl-none">
                <!-- Sidenav toggler -->
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
                <!-- <li class="nav-item d-sm-none">
                    <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                        <i class="ni ni-zoom-split-in"></i>
                    </a>
                </li> -->
                <li class="nav-item d-none d-lg-block ml-lg-4 ml-auto">
                    <ul class="nav">
                        <li class="nav-item px-1" robot-test="navbar-switch-corp">
                            
                            <!-- ******************* SWITCH CORPORATE ******************* -->

                        </li>
                        <li class="nav-item px-1">
                            <ul class="list-inline pt-2 mx-2">
                                <li class="list-inline-item cursor-pointer {{app()->getLocale() == 'th' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ app()->getLocale() == 'th' ?  ''  : url('/locale/th') }}'" robot-test="navbar-lang-th">
                                    <img src="{{ URL::asset('assets/images/region/thailand.png') }}" class="img-fluid" alt="...">
                                </li>
                                <li class="list-inline-item cursor-pointer {{app()->getLocale() == 'en' ?  'lang-active'  : 'lang-inactive'}}" onclick="window.location.href='{{ app()->getLocale() == 'en' ?  ''  : url('/locale/en') }}'" robot-test="navbar-lang-en">
                                    <img src="{{ URL::asset('assets/images/region/united-states.png') }}" class="img-fluid" alt="...">
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item px-1" robot-test="navbar-profiles">
                            {{-- <div class="dropdown d-inline-block dropleft">
                                <div class="card-img-top d-inline rounded-circle wh-profile cursor-pointer" data-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" id="mini_profile_img">
                                        <g transform="translate(20, 20)">
                                            <circle r="19" stroke="white" stroke-width="2" fill="none" />
                                            <text font-size=".8em" stroke="white" fill="white" stroke-width="2px" dy=".2em" text-anchor="middle" alignment-baseline="middle">{{ strtoupper(substr(session('user_detail')->username, 0, 3)) }}</text>
                                        </g>
                                    </svg>
                                </div>
                                <div class="dropdown-menu py-0 border-0">
                                    <div class="card text-center">
                                        <div class="card-header">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" id="mini_profile_img">
                                              <g transform="translate(50, 50)">
                                                  <circle r="49" stroke="grey" stroke-width="2" fill="none" />
                                                  <text font-size="2em" stroke="grey" fill="grey" stroke-width="2px" dy=".2em" text-anchor="middle" alignment-baseline="middle">{{ strtoupper(substr(session('user_detail')->username, 0, 3)) }}</text>
                                              </g>
                                          </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="rounded-circle w-auto mx-auto pb-2">
                                                <a href="/User/Profile" class="list-group-item list-group-item-action" robot-test="navbar-signout-button" data-toggle="tooltip" data-placement="top" title="{{__('leftmenu.edit_profile')}}">
                                                    <h5>{{__('leftmenu.my_profile')}}</h5>
                                                    @if (isset(Session::get('user_detail')->role))
                                                        <small class="d-block text-muted pb-1" style="font-size: 10px;">{{ join(', ', Session::get('user_detail')->role) }}</small>
                                                    @endif
                                                
                                                    <!-- <i class="ni ni-settings"></i> -->
                                                    <span class="ni ni-settings"></span>
                                                </a>
                                            </div>
                                            <a href="/logout" class="list-group-item list-group-item-action" robot-test="navbar-signout-button">{{__('leftmenu.sign_out')}} <span class="oi oi-account-logout float-right"></span></a>
                                        </div>
                                        @if (isset(session('user_detail')->iat))
                                            <div class="card-footer text-muted px-1">
                                                    <h5>Login Time : <span id="timecount">{{ date('H:i:s', session('user_detail')->iat) }}</span></h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                        </li>

                    </ul>
                </li>
            </ul>
            
        </div>
    </div>
</nav>
