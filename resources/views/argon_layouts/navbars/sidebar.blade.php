<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="/">
                @if(isset(Session::get('BANK_CURRENT')['name_en']) && Session::get('BANK_CURRENT')['name_en'] == 'TMB')
                    <img src="{{ URL::asset('argon/img/brand/Logo.png') }}">
                @else
                    <h1> E-Tax Demo</h1>
                @endif
            </a>
            <div class="ml-auto">
                <!-- <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main"> -->
                <div class="sidenav-toggler d-none d-xl-block active p-1 pt-4" data-action="sidenav-unpin" data-target="#sidenav-main"> 
                
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                
                <ul class="navbar-nav">
                </ul>
                
                <hr class="my-3">
                
                <h6 class="navbar-heading p-0 text-muted">{{__('common.menu')}}</h6>
                
                <ul class="navbar-nav mb-md-3">


                    <li class="nav-item" menu-group="dashboard">
                        <a class="nav-link" href="{{ url('/')}}" robot="sidebar-link-dashboard">
                            <i class="ni ni-chart-bar-32"></i>
                            <span class="nav-link-text">{{__('leftmenu.dashboard')}}</span>
                        </a>
                    </li>

                    <li class="nav-item" menu-group="Callback">
                        <a class="nav-link" href="{{ url('log/callback')}}" robot="sidebar-link-dashboard">
                            <i class="ni ni-chart-bar-32"></i>
                            <span class="nav-link-text">Callback</span>
                        </a>
                    </li>
                    @Permission(CORPORATE_MANAGEMENT.VIEW)
                        <li class="nav-item" robot="sidebar-link-corp-manage" menu-group="corporates">
                            <a class="nav-link" href="{{ url('/Corporate')}}">
                                <i class="ni ni-building"></i>
                                <span class="nav-link-text">{{__('leftmenu.corporate')}}</span>
                            </a>
                        </li>
                    @EndPermission

                    
                    @if ( isset( Session::get('user_detail')->user_type ) && Session::get('user_detail')->user_type === 'USER' )
                        @Permission(CORPORATE_MANAGEMENT.*)
                            <li class="nav-item" menu-group="corporates">
                                <a class="nav-link" href="#navbar-corporate" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-corporate">
                                    <i class="ni ni-building"></i>
                                    <span class="nav-link-text">{{__('leftmenu.corporate')}}</span>
                                </a>
                                <div class="collapse" id="navbar-corporate" style="">
                                    <ul class="nav nav-sm flex-column">

                                        @Permission(CORPORATE_MANAGEMENT.CORPORATE_SETTING|CORPORATE_MANAGEMENT.FEE|CORPORATE_MANAGEMENT.PAYMENT_ACC|CORPORATE_MANAGEMENT.RD_SCHEDULE|CORPORATE_MANAGEMENT.ETAX_JOB|CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE|CORPORATE_MANAGEMENT.LOAN_SCHEDULE|CORPORATE_MANAGEMENT.PAYMENT_SETTING|CORPORATE_MANAGEMENT.BRANCH_CONFIG)
                                            <li class="nav-item">
                                                <a href="{{ action('CorporateSettingController@index')}}" class="nav-link">{{__('leftmenu.corporate_setting')}}</a>
                                            </li>
                                        @EndPermission

                                    </ul>
                                </div>
                            </li>
                        @EndPermission
                    @endif

                    @Permission(CORPORATE_USER_MANAGEMENT.*|AGENT_USER_MANAGEMENT.*)
                        <li class="nav-item" menu-group="user">
                            <a class="nav-link" href="#navbar-usermanagement" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-usermanagement">
                                <i class="ni ni-single-02"></i>
                                <span class="nav-link-text">{{__('leftmenu.user_management')}}</span>
                            </a>
                            <div class="collapse" id="navbar-usermanagement" style="">
                                <ul class="nav nav-sm flex-column">
                                    
                                    @Permission(CORPORATE_USER_MANAGEMENT.*)
                                        <li class="nav-item">
                                            <a href="{{ action('Corporate\UserManagementController@index') }}" class="nav-link">{{ __('leftmenu.corporate_usermanagement') }}</a>
                                        </li>
                                    @EndPermission

                                    @Permission(AGENT_USER_MANAGEMENT.*)
                                        <li class="nav-item">
                                            <a href="{{ action('Agent\UserManagementController@index') }}" class="nav-link">{{ __('leftmenu.agent_usermanagement') }}</a>
                                        </li>
                                    @EndPermission
                                </ul>
                            </div>
                        </li>
                    @EndPermission

                    @Permission(CORPORATE_ROLE_MANAGEMENT.*|AGENT_ROLE_MANAGEMENT.*)
                        <li class="nav-item" menu-group="role">
                            <a class="nav-link" href="#navbar-role" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-role">
                                <i class="ni ni-circle-08"></i>
                                <span class="nav-link-text">{{__('leftmenu.role_management')}}</span>
                            </a>
                            <div class="collapse" id="navbar-role" style="">
                                <ul class="nav nav-sm flex-column">

                                    @Permission(CORPORATE_ROLE_MANAGEMENT.*)
                                        <li class="nav-item">
                                            <a href="{{ action('Corporate\RoleManagementController@corporate_role_page_index')}}" class="nav-link">{{__('leftmenu.corporate_role')}}</a>
                                        </li>
                                    @EndPermission

                                    @Permission(AGENT_ROLE_MANAGEMENT.*)
                                        <li class="nav-item">
                                            <a href="{{ action('Agent\RoleManagementController@agent_role_page_index')}}" class="nav-link">{{__('leftmenu.agent_role')}}</a>
                                        </li>
                                    @EndPermission

                                </ul>
                            </div>
                        </li>
                    @EndPermission

                    @Permission(SYS_AGENT_MANAGE.*)
                        <li class="nav-item" menu-group="agent">
                            <a class="nav-link" href="{{ url('/Manage/Agents')}}" robot="sidebar-link-system-manage-agent">
                                <i class="ni ni-shop"></i>
                                <span class="nav-link-text">{{__('leftmenu.agents_management')}}</span>
                            </a>
                        </li>
                    @EndPermission

                    @Permission(SUPPORT.*)
                    <li class="nav-item active" menu-group="support">
                        <a class="nav-link" href="#navbar-support" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-support">
                            <i class="ni ni-collection text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.support')}}</span>
                        </a>
                        <div class="collapse" id="navbar-support" style="">
                            <ul class="nav nav-sm flex-column">

                                @Permission(SUPPORT.BILL_PAYMENT)
                                <li class="nav-item ">
                                    <a href="{{ url('Support/Bill')}}" class="nav-link" robot="sidebar-link-support-bill">{{__('leftmenu.search_bill')}}</a>
                                </li>
                                @EndPermission

                                @Permission(SUPPORT.BILL_ACTIVITY_LOGS)
                                <li class="nav-item">
                                    <a href="{{ action('Bill\LogsController@index')}}" class="nav-link" robot="sidebar-link-support-bill-activity">{{__('leftmenu.manage.bill.log_activity')}}</a>
                                </li>
                                @EndPermission

                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(ETAX.*)
                    <li class="nav-item active" menu-group="etax">
                        <a class="nav-link" href="#navbar-etax" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-etax">
                            <i class="ni ni-collection text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.etax')}}</span>
                        </a>
                        <div class="collapse" id="navbar-etax" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item ">
                                    <a href="{{ url('ETax')}}" class="nav-link" robot="sidebar-link-etax-mapping">{{__('leftmenu.invoice')}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="collapse" id="navbar-etax" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item ">
                                    <a href="{{ url('FieldMapping')}}" class="nav-link" robot="sidebar-link-etax-mapping">{{__('leftmenu.file_mapping')}}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(LINE.*)
                    <li class="nav-item active" menu-group="line">
                        <a class="nav-link" href="#navbar-line" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-line" robot="sidebar-collapse-line">
                            <i class="ni ni-mobile-button text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.line')}}</span>
                        </a>
                        <div class="collapse" id="navbar-line" style="">
                            <ul class="nav nav-sm flex-column">
                                @Permission(LINE.BROADCAST)
                                    <li class="nav-item">
                                        <a href="{{ url('Line/Broadcast')}}" class="nav-link" robot="sidebar-link-line-broadcast">{{__('leftmenu.broadcast')}}</a>
                                    </li>
                                @EndPermission

                                @Permission(LINE.NEWS)
                                    <li class="nav-item">
                                        <a href="{{ url('Line/News')}}" class="nav-link" robot="sidebar-link-line-news">{{__('leftmenu.news')}}</a>
                                    </li>
                                @EndPermission

                                @Permission(LINE.RICHMENU)
                                    <li class="nav-item">
                                        <a href="{{ url('Line/Richmenu')}}" class="nav-link" robot="sidebar-link-line-rich-menu">{{__('leftmenu.richmenu')}}</a>
                                    </li>
                                @EndPermission
                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(LOAN_MANAGEMENT.*)
                    <li class="nav-item active" menu-group="loan">
                        <a class="nav-link" href="#navbar-loan" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-loan" robot="sidebar-collapse-loan">
                            <i class="ni ni-paper-diploma text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.loan')}}</span>
                        </a>
                        <div class="collapse" id="navbar-loan" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('Loan/Contract')}}" class="nav-link" robot="sidebar-link-loan-contract">{{__('loan_contract.menu')}}</a>
                                </li>
                                @if (isset(Session::get('CORP_CURRENT')['corp_code']))
                                    @Permission(CORPORATE_MANAGEMENT.LOAN_SCHEDULE)
                                    <li class="nav-item">
                                        <a href="{{ url('Corporate').'/'.Session::get('CORP_CURRENT')['corp_code'] }}/Setting" class="nav-link" robot="sidebar-link-loan-schedule">{{__('leftmenu.corpsetting-loan_schedule')}}</a>
                                    </li>
                                    @EndPermission
                                @endif
                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(RECIPIENT.*)
                    <li class="nav-item active" menu-group="recipient">
                        <a class="nav-link" href="#navbar-recipient" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-recipient" robot="sidebar-collapse-recipient">
                            <i class="ni ni-bullet-list-67 text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.recipient')}}</span>
                        </a>
                        <div class="collapse" id="navbar-recipient" style="">

                            <ul class="nav nav-sm flex-column">
                                
                                @Permission(RECIPIENT.VIEW_INDIVIDUAL_CUSTOMER_INFORMATION)
                                <li class="nav-item">
                                    <a href="{{ url('Recipient')}}" class="nav-link" robot="sidebar-link-recipient-list">{{__('leftmenu.list')}}</a>
                                </li>
                                @EndPermission

                                {{-- @Permission(RECIPIENT.VIEW_GROUP_RECIPIENT)
                                <li class="nav-item ">
                                    <a href="{{ url('Recipient/Group')}}" class="nav-link">{{__('leftmenu.group')}}</a>
                                </li>
                                @EndPermission --}}

                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(BILL.*)
                    <li class="nav-item active" menu-group="bill">
                        <a class="nav-link" href="#navbar-bill-payment" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-report">
                            <i class="ni ni-money-coins text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.bill.title')}}</span>
                        </a>

                        <div class="collapse" id="navbar-bill-payment" style="">
                            <ul class="nav nav-sm flex-column">

                                @Permission(BILL.*)
                                <li class="nav-item">
                                    <a href="{{ action('Bill\UploadController@index')}}" class="nav-link" robot="sidebar-link-bill-payment">{{__('leftmenu.bill.listpage')}}</a>
                                </li>
                                @EndPermission

                            </ul>
                        </div>

                    </li>
                    @EndPermission

                    @Permission(BILL.ITEM_SETTING)
                    <li class="nav-item active" menu-group="item">
                        <a class="nav-link" href="#navbar-item_product" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-item_product">
                            <i class="ni ni-basket text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.item_product')}}</span>
                        </a>
                        <div class="collapse" id="navbar-item_product" style="">
                            <ul class="nav nav-sm flex-column">
                                @Permission(BILL.ITEM_SETTING)
                                <li class="nav-item">
                                    <a href="{{ action('ItemProductSettingController@index')}}" class="nav-link" robot="sidebar-link-item_product">{{__('leftmenu.item_product_setting')}}</a>
                                </li>
                                @EndPermission
                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @Permission(PAYMENT_TRANSACTION.VIEW)
                    <li class="nav-item" menu-group="payment">
                        <a class="nav-link" href="{{ url('/PaymentTransaction')}}" robot="sidebar-link-payment-txn">
                            <i class="ni ni-money-coins"></i>
                            <span class="nav-link-text">{{__('leftmenu.payment_transaction')}}</span>
                        </a>
                    </li>
                    @EndPermission
                    
                    @Permission(REPORT.*)
                    <li class="nav-item active" menu-group="report">
                        <a class="nav-link" href="#navbar-report" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-report">
                            <i class="ni ni-collection text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.report.title')}}</span>
                        </a>

                        <div class="collapse" id="navbar-report" style="">
                            <ul class="nav nav-sm flex-column">

                                @Permission(REPORT.SUMMARY_PAYMENT_RECONCILE_REPORT|REPORT.SUMMARY_BILL_PAYMENT_REPORT|REPORT.SUMMARY_CORPORATE_REPORT|REPORT.SUMMARY_PAYMENT_TRANSACTION_REPORT|REPORT.CORPORATE)
                                <li class="nav-item">
                                    <a href="{{ url('report/inquiry')}}" class="nav-link" robot="sidebar-link-corp-report">{{__('leftmenu.report.inquiry')}}</a>
                                </li>
                                @EndPermission


                                @Permission(REPORT.BILL_PAYMENT)
                                <li class="nav-item ">
                                    <a href="{{ url('report/bill')}}" class="nav-link" robot="sidebar-link-bill-report">{{__('leftmenu.report.bill_payment')}}</a>
                                </li>
                                @EndPermission

                                @Permission(REPORT.PAYMENT_TRANSACTION)
                                <li class="nav-item">
                                    <a href="{{ url('report/payment')}}" class="nav-link" robot="sidebar-link-txn-report">{{__('leftmenu.report.payment_transaction')}}</a>
                                </li>
                                @EndPermission

                            </ul>
                        </div>

                    </li>
                    @EndPermission

                    @Permission(VISA.VIRTUAL_CARD)
                    <li class="nav-item active" menu-group="visa">
                        <a class="nav-link" href="#navbar-visa-virtual" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-visa" robot="sidebar-collapse-report">
                            <i class="ni ni-money-coins text-default"></i>
                            <span class="nav-link-text">Visa Virtual</span>
                        </a>

                        <div class="collapse" id="navbar-visa-virtual" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('/Visa/VirtualCard')}}" class="nav-link" robot="sidebar-visa-virtualcard"> Visa VirtualCard</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/Visa/VirtualCard/transaction')}}" class="nav-link" robot="sidebar-visa-transaction"> Visa Transaction</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @EndPermission

                    @if(!blank(@Session::get('payment_recurring')) && in_array('recurring', @Session::get('payment_recurring')) && session('user_detail')->user_type !== 'USER')
                    <li class="nav-item active" menu-group="recurring">
                        <a class="nav-link" href="#navbar-recurring" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-recurring">
                            <i class="ni ni-collection text-default"></i>
                            <span class="nav-link-text">{{__('leftmenu.recurring_title')}}</span>
                        </a>
                        <div class="collapse" id="navbar-recurring" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('Recurring')}}" class="nav-link" robot="sidebar-link-corp-recurring">Card Store</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Recurring/Bill')}}" class="nav-link" robot="sidebar-link-corp-recurring">Bill Store</a>
                                </li>
                              
                                <li class="nav-item">
                                    <a href="{{ url('Recurring/Transaction')}}" class="nav-link" robot="sidebar-link-corp-recurring">Transaction</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(Session::has('BANK_CURRENT') && strpos(Session::get('BANK_CURRENT')['name_en'], 'Digio') !== false)
                    <li class="nav-item active" menu-group="product">
                        <a class="nav-link" href="#navbar-product" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-etax" robot="sidebar-collapse-product">
                            <i class="ni ni-collection text-default"></i>
                            <span class="nav-link-text">{{__('settlementbill.settlement_title')}}</span>
                        </a>
                        <div class="collapse" id="navbar-product" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('Settlement/Product')}}" class="nav-link" robot="sidebar-link-corp-product">{{__('settlementbill.product')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('Settlement/Product/Upload')}}" class="nav-link" robot="sidebar-link-corp-product">Import</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif


                    
                    @Permission(BAAC.*)
                    <li class="nav-item active" menu-group="baac">
                        <a class="nav-link" href="#navbar-baac" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-baac" robot="sidebar-collapse-report">
                            <i class="ni ni-money-coins text-default"></i>
                            <span class="nav-link-text">BAAC</span>
                        </a>

                        <div class="collapse" id="navbar-baac" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('/BAAC/Product')}}" class="nav-link" robot="sidebar-baac-product">Product</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="collapse" id="navbar-baac" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('/BAAC/Recipient/Bookstate')}}" class="nav-link" robot="sidebar-link-baac-recipient-bookstate">Redeem</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="collapse" id="navbar-baac" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ url('/BAAC/Recipient/Activity')}}" class="nav-link" robot="sidebar-link-baac-recipient-activity">Recipient Activity</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @EndPermission
                    
                    @Permission(SYS_FUNCTION_MANAGE.VIEW)
                    <li class="nav-item" menu-group="function">
                        <a class="nav-link" href="{{ url('/Function')}}" robot="sidebar-link-function">
                            <i class="ni ni-atom"></i>
                            <span class="nav-link-text">{{__('function.function')}}</span>
                        </a>
                    </li>
                    @EndPermission

                </ul>
            </div>
        </div>
    </div>
</nav>