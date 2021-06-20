@if (Request::path() != 'welcome')
    <div id="menu" class="menu-position nav-container theme-target" data-visible="visible">
        <div id="menu-content" class="d-flex px-4 pt-2 justify-content-center">
            <div class="w-100 text-center pt-2">
                <a class="text-black align-middle pl-2 font-24px" href="{{ url('/') }}">
                    <img src="{{ URL::asset('assets/images/logo_blue.png') }}" width="40">
                </a>
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
                        @if (isset(Session::get('user_detail')->role))
                            <small class="d-block text-muted pb-2" style="font-size: 10px;">{{ join(', ', Session::get('user_detail')->role) }}</small>
                        @endif
                        <a href="/logout" class="text-style-3">{{__('leftmenu.sign_out')}}</a>
                    </div>
                </div>
            </div>

            <div id="menu-group" class="col-12 col-xl-12 px-0">
                <div class="list-group no-border border-bottom">
                    @Permission(DASHBOARD.*)
                        <a href="{{ url('/dashboard')}}" class="list-group-item list-group-item-action menu-items" data-menu="Dashboard">
                            <span class="icon icon-dashboard align-middle"></span>
                            <span class="pl-2">{{__('leftmenu.dashboard')}}</span>
                        </a>
                    @EndPermission
                    @Permission(CORPORATE_MANAGEMENT.*)
                    <a href="{{ url('Corporate')}}" class="list-group-item list-group-item-action menu-items" data-menu="CorporateManagement">
                        <span class="icon icon-bank align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.corporate')}}</span>
                    </a>
                    @EndPermission
                    @Permission(USER_MANAGEMENT.*)
                    <a href="{{ url('UserManagement/Index')}}" class="list-group-item list-group-item-action menu-items" data-menu="UserManagement">
                        <span class="icon icon-Photostream align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.user_management')}}</span>
                    </a>
                    @EndPermission

                    @Permission(ROLE_MANAGEMENT.*)
                    <a href="{{ url('RoleManagement/Index')}}" class="list-group-item list-group-item-action menu-items" data-menu="RoleManagement">
                        <span class="icon icon-Photostream align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.role_management')}}</span>
                    </a>
                    @EndPermission

                    @Permission(SYS_AGENT_MANAGE.*)
                    <a href="{{ url('Manage/Agents')}}" class="list-group-item list-group-item-action menu-items" data-menu="RoleManagement">
                        <span class="icon icon-Photostream align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.agents_management')}}</span>
                    </a>
                    @EndPermission

                    @Permission(ETAX.*)
                    <div class="list-group no-border border-bottom">
                        <a class="list-group-item list-group-item-action menu-items" data-menu-parent="etax" data-toggle="collapse" href="#menu_etax" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <ul class="list-inline mb-0"> 
                                <li class="list-inline-item mx-0">
                                    <span class="icon icon-Photostream align-middle"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="pl-2">{{__('leftmenu.etax')}}</span>
                                </li>
                                <li class="list-inline-item float-right mx-0">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </li>
                            </ul>          
                        </a>
                        <div class="collapse" id="menu_etax">
                            <div class="card card-body px-0 py-0">
                                <div class="list-group pl-3">
                                    <a href="{{ url('ETax')}}" class="list-group-item list-group-item-action menu-items" data-menu="Builder">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.invoice')}}</span>
                                    </a>
                                    <a href="{{ url('FieldMapping')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="etax">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.file_mapping')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @EndPermission

                    @Permission(LINE.*)
                    <div class="list-group no-border border-bottom">
                        <a class="list-group-item list-group-item-action menu-items" data-menu-parent="line" data-toggle="collapse" href="#menu_line" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <ul class="list-inline mb-0"> 
                                <li class="list-inline-item mx-0">
                                    <span class="icon icon-Photostream align-middle"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="pl-2">{{__('leftmenu.line')}}</span>
                                </li>
                                <li class="list-inline-item float-right mx-0">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </li>
                            </ul>
                        </a>
                        <div class="collapse" id="menu_line">
                            <div class="card card-body px-0 py-0">
                                <div class="list-group pl-3">
                                    @Permission(LINE.BROADCAST)
                                    <a href="{{ url('Line/Broadcast')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="line">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.broadcast')}}</span>
                                    </a>
                                    @EndPermission
                                    @Permission(LINE.NEWS)
                                    <a href="{{ url('Line/News')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="line">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.news')}}</span>
                                    </a>
                                    @EndPermission
                                    @Permission(LINE.RICH_MENU)
                                    <a href="{{ url('Line/Richmenu')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="line">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.richmenu')}}</span>
                                    </a>
                                    @EndPermission
                                </div>
                            </div>
                        </div>
                    </div>
                    @EndPermission

                    @Permission(LOAN_MANAGEMENT.*)
                    <div class="list-group no-border border-bottom">
                        <a class="list-group-item list-group-item-action menu-items" data-menu-parent="loan_management" data-toggle="collapse" href="#menu_loan" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <ul class="list-inline mb-0"> 
                                <li class="list-inline-item mx-0">
                                    <span class="icon icon-Photostream align-middle"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="pl-2">{{__('leftmenu.loan')}}</span>
                                </li>
                                <li class="list-inline-item float-right mx-0">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </li>
                            </ul>
                        </a>
                        <div class="collapse" id="menu_loan">
                            <div class="card card-body px-0 py-0">
                                <div class="list-group pl-3">
                                    <a href="{{ url('Loan/Contract')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="loan_management">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('loan_contract.menu')}}</span>
                                    </a>
                                    {{-- <a href="{{ url('Loan/Report/Transaction')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="loan_management">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.repayment_transaction')}}</span>
                                    </a> --}}
                                    @if (isset(Session::get('CORP_CURRENT')['corp_code']))
                                    @Permission(CORPORATE_MANAGEMENT.LOAN_SCHEDULE)
                                    <a href="{{ url('Corporate').'/'.Session::get('CORP_CURRENT')['corp_code'] }}/Setting" data-menu-child="loan_management"  class="list-group-item list-group-item-action menu-items">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.corpsetting-loan_schedule')}}</span>
                                    </a>
                                    @EndPermission
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @EndPermission

                    @Permission(RECIPIENT.*)
                    <div class="list-group no-border border-bottom">
                        <a class="list-group-item list-group-item-action menu-items" data-menu-parent="recipient" data-toggle="collapse" href="#menu_recipient" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <ul class="list-inline mb-0"> 
                                <li class="list-inline-item mx-0">
                                    <span class="icon icon-Photostream align-middle"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="pl-2">{{__('leftmenu.recipient')}}</span>
                                </li>
                                <li class="list-inline-item float-right mx-0">
                                    <i class="zmdi zmdi-chevron-down"></i>
                                </li>
                            </ul>
                        </a>
                        <div class="collapse" id="menu_recipient">
                            <div class="card card-body px-0 py-0">
                                <div class="list-group pl-3">
                                    @Permission(RECIPIENT.VIEW_INDIVIDUAL_CUSTOMER_INFORMATION)
                                    <a href="{{ url('Recipient')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="recipient">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.list')}}</span>
                                    </a>
                                    @EndPermission
                                    @Permission(RECIPIENT.VIEW_GROUP_RECIPIENT)
                                    <a href="{{ url('Recipient/Group')}}" class="list-group-item list-group-item-action menu-items" data-menu-child="recipient">
                                        <span class="icon icon-Photostream align-middle"></span>
                                        <span class="pl-2">{{__('leftmenu.group')}}</span>
                                    </a>
                                    @EndPermission
                                </div>
                            </div>
                        </div>
                    </div>
                    @EndPermission

                    @Permission(BILL.*)
                    <a href="{{ url('Bill')}}" class="list-group-item list-group-item-action menu-items" data-menu="bill">
                        <span class="icon icon-Photostream align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.bill')}}</span>
                    </a>
                    @EndPermission

                    @Permission(PAYMENT_TRANSACTION.VIEW)
                    <a href="{{ url('PaymentTransaction')}}" class="list-group-item list-group-item-action menu-items" data-menu="PaymentTransaction">
                        <span class="icon icon-Photostream align-middle"></span>
                        <span class="pl-2">{{__('leftmenu.payment_transaction')}}</span>
                    </a>
                    @EndPermission

                </div>
            </div>
        </div>
    </div>
@endif
