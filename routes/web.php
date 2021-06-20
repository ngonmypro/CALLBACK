<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'EtaxDemo\ETaxDemoController@index');
Route::post('get_etax', 'EtaxDemo\ETaxDemoController@etax_object_data');

Route::get('Create', 'EtaxDemo\ETaxDemoController@create');
Route::post('Create_post', 'EtaxDemo\ETaxDemoController@create_post');

Route::post('get_province', 'EtaxDemo\ETaxDemoController@get_province');

Route::post('download_pdf', 'EtaxDemo\ETaxDemoController@download_PDF');
Route::get('download_pdf/{id}', 'EtaxDemo\ETaxDemoController@download_PDF');
Route::get('download_xml/{id}', 'EtaxDemo\ETaxDemoController@download_XML');

// Route::post('callback', 'EtaxDemo\CallBackController@call_back');
Route::get('callback', 'EtaxDemo\CallBackController@index');


Route::get('log/callback', 'EtaxDemo\CallBackController@Log_call_back');
Route::post('callback', 'EtaxDemo\CallBackController@callBackEtax');
Route::post('log_etax_data', 'EtaxDemo\CallBackController@log_etax_data');

// Route::group(['middleware' => ['prevent-back-history']], function () {
//     Route::get('/', 'AuthController@index');
// });


    // // LOGIN
    // Route::post('/login', 'AuthController@postLogin');
    // Route::get('/login', 'AuthController@index');

    // // LOGOUT
    // Route::get('logout', 'AuthController@LogOut');

    // // ACCOUNT ACTIVATION
    // Route::get('/verify/activate', 'AuthController@UserActivatePage');
    // Route::post('/verify/activate', 'AuthController@UserActivateConfirm');
    // Route::post('/verify/activate/getotp', 'AuthController@UserActivate_GetOTP');

    // // FORGET PASSWORD
    // Route::get('user/forgot-password', 'ForgotPasswordController@index');
    // Route::post('user/forgot-password', 'ForgotPasswordController@submit');

    // //setLanguage
    Route::get('locale/{locale}', 'UserManagementController@change_lang');

    //return exception
    Route::get('/Exception/NotFound', function () {
        return view('Exception/NotFound');
    });
    Route::get('/Exception/MethodNotAllowed', function () {
        return view('Exception/MethodNotAllowed');
    });
    Route::get('/Exception/InternalError', function () {
        return view('Exception/InternalError');
    });
    Route::get('/AccessDenied', function () {
        return view('Exception/AccessDenied');
    });
/*
    Route::group(['prefix' => 'app'], function () {
        Route::get('/{app_name}/line/auth', 'Line\AuthController@auth');
        Route::post('/{app_name}/line/inquiry', 'Line\AuthController@post_inquiry');
        Route::post('/{app_name}/line/auth', 'Line\AuthController@post_auth');
        Route::post('/line/profile', 'Line\AuthController@recipient_profile');


        Route::get('/{app_name}/line/payment', 'Line\PaymentController@payment');
        Route::get('/{app_name}/line/payment_confirm/{bill_reference}', 'Line\PaymentController@payment_confirm');
        Route::get('/{app_name}/line/payment_history', 'Line\PaymentController@payment_history');

        Route::post('/{app_name}/line/payment', 'Line\PaymentController@post_payment');
        Route::post('/{app_name}/line/payment_confirm/{bill_reference}', 'Line\PaymentController@post_payment_confirm');
        Route::post('/{app_name}/line/payment_history', 'Line\PaymentController@post_payment_history');
        

    });





    Route::group(['middleware' => ['xss', 'auth_token', 'prevent-back-history']], function () {
        Route::get('home', 'DashboardController@index');
        Route::get('dashboard', 'DashboardController@index');
        Route::post('getMaxChange', 'DashboardController@getMaxChange');
        Route::post('getMaxBillPaid', 'DashboardController@getMaxBillPaid');

        Route::get('short_cut', 'DashboardController@short_cut');

        Route::group(['prefix' => 'Manage/Apps', 'middleware'   => 'permission:SYS_APP_MANAGE.*'], function () {
            Route::get('/', 'AppManageController@index')->middleware('permission:SYS_APP_MANAGE.VIEW');
            Route::post('/objectData', 'AppManageController@objectData')->middleware('permission:SYS_APP_MANAGE.VIEW');
        });

        Route::group(['middleware' => ['permission:SYS_AGENT_MANAGE.*']], function () {
            #BankManagement
            Route::group(['prefix' => 'Manage/Agents'], function () {
                Route::get('/', 'AgentManageController@Index')->middleware('permission:SYS_AGENT_MANAGE.VIEW');
                Route::post('/objectData', 'AgentManageController@GetBankList')->middleware('permission:SYS_AGENT_MANAGE.VIEW');
                Route::get('/Create', 'AgentManageController@Create')->middleware('permission:SYS_AGENT_MANAGE.CREATE');
                Route::get('/Detail/{agent_code}', 'AgentManageController@detail')->middleware('permission:SYS_AGENT_MANAGE.UPDATE');
                Route::post('/SubmitBank', 'AgentManageController@SubmitBank')->middleware('permission:SYS_AGENT_MANAGE.UPDATE,SYS_AGENT_MANAGE.CREATE');
                Route::post('request/select2', 'AgentManageController@select2_agent');

                Route::get('/{agent_code}/Setting', 'AgentManageController@bank_setting')->middleware('permission:SYS_AGENT_MANAGE.UPDATE');
                Route::post('Setting/Notify2', 'AgentManageController@notify');
                Route::post('Setting/Payment2', 'AgentManageController@payment');
                Route::post('Permission', 'AgentManageController@Permissions');
                Route::post('listpermissions', 'AgentManageController@list_Permissions');
                Route::post('getitempermissions', 'AgentManageController@getItemPermissions');
                Route::post('postpermissions', 'AgentManageController@postPermissions');

                Route::get('Payment/Create/{bank_code}', 'AgentManageController@PaymentCreate');
                Route::get('Setting/Update/Payment2/{channel_name}/{bank_code}', 'AgentManageController@update_payment');
                Route::post('Setting/Function/Update', 'AgentManageController@PostUpdatePayment');
                Route::post('Setting/Function/Create', 'AgentManageController@PostCreatePayment');
                Route::post('Payment/objectData', 'AgentManageController@PaymentList');
                
            });
        });
        

        Route::group(['middleware' => []], function () {

            Route::post('/switch/corporate', 'CorporateController@SwitchCorporate');

            Route::group(['prefix' => 'Corporate'], function () {

                // MANAGE
                Route::get('/', 'CorporateController@index')->middleware('permission:CORPORATE_MANAGEMENT.VIEW');
                Route::post('objectData', 'CorporateController@objectData')->middleware('permission:CORPORATE_MANAGEMENT.VIEW');
                Route::get('Create', 'CorporateController@CorporateCreate')->middleware('permission:CORPORATE_MANAGEMENT.CREATE');
                Route::post('Create', 'CorporateController@CorporateCreatePost')->middleware('permission:CORPORATE_MANAGEMENT.CREATE');
                Route::post('Create/ZipcodeAddress', 'CorporateController@ZipcodeAddress')->middleware('permission:CORPORATE_MANAGEMENT.CREATE');
                Route::get('Detail/{code}', 'CorporateController@CorporateDetail')->middleware('permission:CORPORATE_MANAGEMENT.VIEW');
                Route::get('Edit/{code}', 'CorporateController@CorporateEdit')->middleware('permission:CORPORATE_MANAGEMENT.UPDATE');
                Route::post('EditData', 'CorporateController@CorporateEditPost')->middleware('permission:CORPORATE_MANAGEMENT.UPDATE');

                // CORPORATE SETTING ADD HERE
                $CorpSetting = [
                    'CORPORATE_MANAGEMENT.CORPORATE_SETTING',
                    'CORPORATE_MANAGEMENT.FEE',
                    'CORPORATE_MANAGEMENT.PAYMENT_ACC',
                    'CORPORATE_MANAGEMENT.RD_SCHEDULE',
                    'CORPORATE_MANAGEMENT.ETAX_JOB',
                    'CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE',
                    'CORPORATE_MANAGEMENT.LOAN_SCHEDULE',
                    'CORPORATE_MANAGEMENT.PAYMENT_SETTING',
                    'CORPORATE_MANAGEMENT.BRANCH_CONFIG',
                ];
                Route::group(['middleware' => 'permission:'.join(',', $CorpSetting) ], function () {
                    // SETTING
                    Route::get('Setting', 'CorporateSettingController@index');
                    Route::get('{corp_code?}/Setting', 'CorporateSettingController@setting');
                });

                // FEE MANAGEMENT
                Route::get('{corp_code}/Fee', 'CorporateSettingController@FeeManage')->middleware('permission:CORPORATE_MANAGEMENT.FEE');
                Route::post('Setting/FeeUsage', 'CorporateSettingController@fee_usage_objectData')->middleware('permission:CORPORATE_MANAGEMENT.FEE');
                Route::get('Setting/Create/{corp_code}', 'CorporateSettingController@AddMoreFeeUsage')->middleware('permission:CORPORATE_MANAGEMENT.FEE');
                Route::post('Setting/CreateFeeUsage', 'CorporateSettingController@create_fee_usage')->middleware('permission:CORPORATE_MANAGEMENT.FEE');
                Route::post('Setting/Fee', 'CorporateSettingController@fee')->middleware('permission:CORPORATE_MANAGEMENT.FEE');

                // WORKFLOW
                Route::post('Setting/Workflow', 'CorporateSettingController@workflow')->middleware('permission:CORPORATE_MANAGEMENT.WORKFLOW');

                // PAYMENT ACCOUTN
                Route::post('Setting/PaymentAccount', 'CorporateSettingController@bank_acc')->middleware('permission:CORPORATE_MANAGEMENT.PAYMENT_ACC');

                // ETAX RD SCHEDULE
                Route::post('Setting/RD_Schedule', 'CorporateSettingController@rd_schedule')->middleware('permission:CORPORATE_MANAGEMENT.RD_SCHEDULE');

                // ETAX JOB
                Route::post('Setting/ETaxJob', 'CorporateSettingController@etax_job')->middleware('permission:CORPORATE_MANAGEMENT.ETAX_JOB');

                // CUSTOMER FEE
                Route::post('Setting/CustomerFee', 'CorporateSettingController@customer_fee_setting')->middleware('permission:CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE');

                // LOAN BILL GENERATE SCHEDULE
                Route::post('Setting/LoanSchedule', 'CorporateSettingController@loan_schedule')->middleware('permission:CORPORATE_MANAGEMENT.LOAN_SCHEDULE');

                // PAYMENT GATEWAY CONFIG
                Route::post('Setting/Payment', 'CorporateSettingController@payment')->middleware('permission:CORPORATE_MANAGEMENT.PAYMENT_SETTING');

                // CORPORATE BRANCE IMAGE LOGO
                Route::post('Setting/ImgLogo', 'CorporateSettingController@img_logo')->middleware('permission:CORPORATE_MANAGEMENT.BRANCH_CONFIG');

                // SHEET CONFIG
                Route::post('Setting/Sheet', 'CorporateSettingController@sheet');

                # PDF TEMPLATE
                Route::post('Setting/PDF/Object', 'CorporateSettingController@get_obj_pdf_template');
                Route::get('Setting/PDF/Create/{corp_code}', 'CorporateSettingController@create_pdf_tempate');
                Route::post('Setting/PDF/Confirm', 'CorporateSettingController@pdf_template_confirm');
                Route::get('Setting/PDF/View/{corp_code}/{ref}', 'CorporateSettingController@pdf_tempate');

                Route::post('request/select2', 'CorporateController@select2_corporate');
                Route::post('request/select2_branch', 'CorporateController@select2_branch');
                Route::post('request/select2_textid', 'CorporateController@select2_textid');

                Route::group([ 'middleware' => ['permission:CORPORATE_MANAGEMENT.NOTIFY_CONFIG'] ], function () {
                    Route::post('Setting/Notify', 'CorporateSettingController@notify');
                    Route::post('Setting/Email', 'CorporateSettingController@email');
                });

                
                Route::group([ 'middleware' => ['permission:CORPORATE_MANAGEMENT.LINE_APP_CONFIG'] ], function () {
                    Route::post('Setting/Line', 'CorporateSettingController@line');
                });


                Route::group([ 'middleware' => ['permission:CORPORATE_MANAGEMENT.ETAX_CONFIG'] ], function () {
                    #Jobs
                    Route::post('Setting/ETax/RD', 'CorporateSettingController@etax_rd');
                    Route::post('Setting/ETax/Create', 'CorporateSettingController@etax_create_job');
                    Route::post('Setting/ETax/Detail', 'CorporateSettingController@job_detail');
                    Route::post('Setting/ETax/Inactive', 'CorporateSettingController@inactive_job');
                });
                
                Route::post('Setting/Function', 'CorporateSettingController@function')->middleware('permission:CORPORATE_MANAGEMENT.FUNCTION_SETTING');

            });
        });

        Route::group([], function () {

            // Role Management
            Route::group(['prefix' => 'RoleManagement', 'middleware' => ['permission:CORPORATE_ROLE_MANAGEMENT.*,AGENT_ROLE_MANAGEMENT.*']], function () {
                
                Route::group(['prefix' => 'Agent', 'middleware' => ['permission:AGENT_ROLE_MANAGEMENT.*']], function () {
                    Route::get('/', 'Agent\RoleManagementController@agent_role_page_index');
                    Route::post('objectData', 'Agent\RoleManagementController@objectData_agent_role');
                    Route::post('Get/ObjectType', 'Agent\RoleManagementController@GetObjectType');

                    Route::get('Create', 'Agent\RoleManagementController@CreateRole')->middleware('permission:AGENT_ROLE_MANAGEMENT.CREATE_ROLE');
                    Route::post('Create', 'Agent\RoleManagementController@SubmitCreateRole')->middleware('permission:AGENT_ROLE_MANAGEMENT.CREATE_ROLE');
                    Route::post('Get/Permission', 'Agent\RoleManagementController@GetPermissions')->middleware('permission:AGENT_ROLE_MANAGEMENT.CREATE_ROLE,AGENT_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                    Route::get('View/RoleAndPermission/{code}', 'Agent\RoleManagementController@RoleAndPermission')->middleware('permission:AGENT_ROLE_MANAGEMENT.VIEW_ROLE_DETAIL');
                    Route::get('Edit/{code}', 'Agent\RoleManagementController@EditRolePermission')->middleware('permission:AGENT_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                    Route::post('Update', 'Agent\RoleManagementController@UpdateRoleAndPermission')->middleware('permission:AGENT_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                });
                
                Route::group(['prefix' => 'Corporate', 'middleware' => ['permission:CORPORATE_ROLE_MANAGEMENT.*']], function () {
                    Route::get('/', 'Corporate\RoleManagementController@corporate_role_page_index');
                    Route::post('objectData', 'Corporate\RoleManagementController@objectData_corporate_role');
                    Route::post('Get/ObjectType', 'Corporate\RoleManagementController@GetObjectType');

                    Route::get('Create', 'Corporate\RoleManagementController@CreateRole')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.CREATE_ROLE');
                    Route::post('Create', 'Corporate\RoleManagementController@SubmitCreateRole')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.CREATE_ROLE,');
                    Route::post('Get/Permission', 'Corporate\RoleManagementController@GetPermissions')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.CREATE_ROLE,CORPORATE_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                    Route::get('View/RoleAndPermission/{code}', 'Corporate\RoleManagementController@RoleAndPermission')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.VIEW_ROLE_DETAIL');
                    Route::get('Edit/{code}', 'Corporate\RoleManagementController@EditRolePermission')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                    Route::post('Update', 'Corporate\RoleManagementController@UpdateRoleAndPermission')->middleware('permission:CORPORATE_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL');
                });

            });

            //User Management
            Route::group(['prefix' => 'UserManagement'], function () {
                Route::get('/', 'UserManagementController@index')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::get('Create', 'UserManagementController@create')->middleware('permission:USER_MANAGEMENT.CREATE_USERS,USER_MANAGEMENT.CREATE_USERS');
                Route::post('Create', 'UserManagementController@create_submit')->middleware('permission:USER_MANAGEMENT.CREATE_USERS,USER_MANAGEMENT.CREATE_USERS');
                Route::get('/Detail/{code}', 'UserManagementController@detail')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::post('objectData', 'UserManagementController@objectData')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::post('Get/Corp', 'CorporateController@objectData')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::get('Edit/{code}', 'UserManagementController@edit')->middleware('permission:USER_MANAGEMENT.EDIT_USERS');
                Route::post('Edit', 'UserManagementController@edit_submit')->middleware('permission:USER_MANAGEMENT.EDIT_USERS');
                Route::post('Request/Suspend', 'UserManagementController@RequestSuspend')->middleware('permission:USER_MANAGEMENT.EDIT_USERS');

                Route::post('ResetPassword', 'UserManagementController@ResetPassword')->middleware('permission:USER_MANAGEMENT.EDIT_USERS');
                Route::post('ResetLoginAttempt', 'UserManagementController@ResetLoginAttempt')->middleware('permission:USER_MANAGEMENT.EDIT_USERS');
                Route::post('Corps/objectData', 'UserManagementController@objectData_AllCorpUser')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::post('Corp/{corp_code}/objectData', 'UserManagementController@objectData_CorpUser')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::get('Profile/{code}', 'UserManagementController@GetUsersInfo')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::post('Get/Agents', 'UserManagementController@GetAgents')->middleware('permission:USER_MANAGEMENT.CREATE_USERS');
                Route::post('Get/Roles', 'UserManagementController@GetRoles')->middleware('permission:CORPORATE_USER_MANAGEMENT.*,AGENT_USER_MANAGEMENT.*');
                Route::post('Get/Users/Count', 'UserManagementController@CountUsersStatus')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
                Route::get('Create/{corp_code}/Corporate', 'UserManagementController@CreateCorporateUser')->middleware('permission:USER_MANAGEMENT.CREATE_USERS,USER_MANAGEMENT.CREATE_USERS');
                Route::post('Corporate/Create', 'UserManagementController@CreateUserCorporateSubmit')->middleware('permission:CORPORATE_MANAGEMENT.CREATE,CORPORATE_MANAGEMENT.CREATE');
                
                Route::group(['prefix' => 'Corporate', 'middleware' => ['permission:CORPORATE_USER_MANAGEMENT.*'] ], function () {
                    Route::get('/', 'Corporate\UserManagementController@index');
                    Route::post('/', 'Corporate\UserManagementController@objectData');

                    Route::get('Create', 'Corporate\UserManagementController@default_create')->middleware('permission:CORPORATE_USER_MANAGEMENT.CREATE_USER');
                    Route::get('{corp_code?}/Create', 'Corporate\UserManagementController@create')->middleware('permission:CORPORATE_USER_MANAGEMENT.CREATE_USER');
                    Route::post('Create', 'Corporate\UserManagementController@create_submit')->middleware('permission:CORPORATE_USER_MANAGEMENT.CREATE_USER');
                    Route::get('{user_code}/User', 'Corporate\UserManagementController@detail')->middleware('permission:CORPORATE_USER_MANAGEMENT.VIEW_USER_DETAIL');
                    Route::get('{user_code}/Edit', 'Corporate\UserManagementController@edit')->middleware('permission:CORPORATE_USER_MANAGEMENT.EDIT_USER_DETAIL');
                    Route::post('Edit', 'Corporate\UserManagementController@edit_submit')->middleware('permission:CORPORATE_USER_MANAGEMENT.EDIT_USER_DETAIL');
                    Route::post('Request/Suspend', 'Corporate\UserManagementController@requestSuspend')->middleware('permission:CORPORATE_USER_MANAGEMENT.SUSPEND_USER,CORPORATE_USER_MANAGEMENT.UNSUSPEND_USER');
                    Route::post('Get/Suspend', 'Corporate\UserManagementController@suspendList')->middleware('permission:CORPORATE_USER_MANAGEMENT.SUSPEND_USER,CORPORATE_USER_MANAGEMENT.UNSUSPEND_USER');
                    Route::post('Request/ResetPassword', 'Corporate\UserManagementController@resetPassword')->middleware('permission:CORPORATE_USER_MANAGEMENT.RESET_PASSWORD');
                });

                Route::group(['prefix' => 'Agent', 'middleware' => ['permission:AGENT_USER_MANAGEMENT.*'] ], function () {
                    Route::get('/', 'Agent\UserManagementController@index');
                    Route::post('/', 'Agent\UserManagementController@objectData');

                    Route::get('Create', 'Agent\UserManagementController@default_create');
                    Route::get('{agent_code?}/Create', 'Agent\UserManagementController@create');
                    Route::post('Create', 'Agent\UserManagementController@create_submit');
                    Route::get('{user_code}/User', 'Agent\UserManagementController@detail')->middleware('permission:AGENT_USER_MANAGEMENT.VIEW_USER_DETAIL');
                    Route::get('{user_code}/Edit', 'Agent\UserManagementController@edit')->middleware('permission:AGENT_USER_MANAGEMENT.EDIT_USER_DETAIL');
                    Route::post('Edit', 'Agent\UserManagementController@edit_submit')->middleware('permission:AGENT_USER_MANAGEMENT.EDIT_USER_DETAIL');
                    Route::post('Request/Suspend', 'Agent\UserManagementController@requestSuspend')->middleware('permission:AGENT_USER_MANAGEMENT.SUSPEND_USER,AGENT_USER_MANAGEMENT.UNSUSPEND_USER');
                    Route::post('Get/Suspend', 'Agent\UserManagementController@suspendList')->middleware('permission:AGENT_USER_MANAGEMENT.SUSPEND_USER,AGENT_USER_MANAGEMENT.UNSUSPEND_USER');
                    Route::post('Request/ResetPassword', 'Agent\UserManagementController@resetPassword')->middleware('permission:AGENT_USER_MANAGEMENT.RESET_PASSWORD');
                });

                Route::post('get/suspend', 'UserManagementController@SuspendList')->middleware('permission:USER_MANAGEMENT.VIEW_USERS');
            });

            Route::get('/User/Profile/', 'UserManagementController@UsersProfile');
            Route::post('/User/Update/Profile/', 'UserManagementController@edit_submit');

        });
        
        Route::group(['prefix' => 'Function'], function () {
            Route::group([ 'middleware' => 'permission:SYS_FUNCTION_MANAGE.*'], function () {
                Route::get('/', 'FunctionController@index');
                Route::post('objectData', 'FunctionController@objectData');
                Route::get('Create', 'FunctionController@create');
                Route::post('Create', 'FunctionController@create_save');
                Route::post('Get/Permission', 'FunctionController@get_permission');
                Route::get('Edit/{function_code}', 'FunctionController@edit');
                Route::post('Edit', 'FunctionController@edit_save');
            });
            Route::post('Get/Function', 'FunctionController@get_function');
        });

        // LINE
        Route::group(['prefix' => 'Line'], function () {

            // RICH MENU
            // Route::group(['prefix' => 'Richmenu', 'middleware'  => 'permission:LINE.RICH_MENU'], function () {
            //     Route::get('', 'Line\RichmenuController@index');
            //     Route::get('Create', 'Line\RichmenuController@show_create');
            //     Route::get('Update/{id}', 'Line\RichmenuController@show_edit');
            //     Route::post('Set/allUser', 'Line\RichmenuController@set_richmenu_all_user');
            //     Route::post('Unset/allUser', 'Line\RichmenuController@unset_richmenu_all_user');
            //     Route::post('Set/byUser', 'Line\RichmenuController@set_richmenu_by_user');
            //     Route::post('Unset/byUser', 'Line\RichmenuController@unset_richmenu_by_user');
            //     Route::post('Show/Richmenu', 'Line\RichmenuController@show_richmenu');
            //     Route::post('Delete', 'Line\RichmenuController@delete_richmenu');
            //     Route::post('Richmenu/Upload', 'Line\RichmenuController@upload');
            //     Route::post('Richmenu/Create', 'Line\RichmenuController@create_richmenu');
            //     Route::post('Richmenu/Update', 'Line\RichmenuController@update_richmenu');
            //     Route::post('Search', 'Line\RichmenuController@search');
            // });

            Route::group(['prefix' => 'Richmenu'], function () {
                Route::get('/', 'Line\RichmenuController@index');
                Route::post('/objectData', 'Line\RichmenuController@objectData');
                Route::get('/Create', 'Line\RichmenuController@create');
                Route::post('/Create', 'Line\RichmenuController@post_create');
                Route::get('Update/{id}', 'Line\RichmenuController@update');
                Route::post('Update/{id}', 'Line\RichmenuController@post_update');
            });

            // BROADCAST
            Route::group(['prefix' => 'Broadcast', 'middleware'  => 'permission:LINE.BROADCAST'], function () {
                Route::get('/', 'Line\BroadcastController@index');
                Route::get('Create', 'Line\BroadcastController@create');
                Route::get('Detail/{id}', 'Line\BroadcastController@detail');
                Route::post('objectData', 'Line\BroadcastController@objectData');
            });

            // NEWS
            Route::group(['prefix' => 'News', 'middleware'  => 'permission:LINE.NEWS'], function () {
                Route::get('/', 'Line\NewsController@index');
                Route::get('Create', 'Line\NewsController@create');
                Route::get('Detail/{id}', 'Line\NewsController@news_detail');
                Route::get('Edit/{id}', 'Line\NewsController@edit_news');
                Route::post('objectData', 'Line\NewsController@objectData');
                Route::post('Create', 'Line\NewsController@create_save');
                Route::post('Update_Status', 'Line\NewsController@update_status');
                Route::post('Update', 'Line\NewsController@edit_save');
            });
        });

        // LOAN
        Route::group(['prefix' => 'Loan', 'middleware'  => 'permission:LOAN_MANAGEMENT.*'], function () {
            
            Route::group(['prefix' => 'Contract'], function () {
                Route::get('/', 'Loan\ContractController@index');
                Route::get('Create', 'Loan\ContractController@createContract');
                Route::get('Info/{contract_code}', 'Loan\ContractController@ContractInfo');
                Route::get('Update/{contract_code}', 'Loan\ContractController@UpdateContract');
                Route::get('Download/{id}', 'Loan\ContractController@download');
                Route::get('Document/{code}', 'Loan\ContractController@GetDocument');
                Route::get('{contract_code}/Bill/{ref}', 'Loan\ContractController@bill_download');
                Route::post('objectData', 'Loan\ContractController@contractObjectData');
                Route::post('Create', 'Loan\ContractController@createContractSave');
                Route::post('get_product_list', 'Loan\ContractController@get_product_list');
                Route::post('get_recipient_list', 'Loan\ContractController@get_recipient_list');
                Route::post('Update/{contract_code}', 'Loan\ContractController@UpdateContractSave');
                Route::post('{contract_code}/Approve', 'Loan\ContractController@loan_approve');
                Route::post('{contract_code}/Reject', 'Loan\ContractController@loan_reject');
                Route::post('CreatePendingItem', 'Loan\ContractController@create_pending_item');
                Route::post('UploadDocument/{contract_code}', 'Loan\ContractController@UploadDocument');
                Route::post('Get/Status', 'Loan\ContractController@DatatableCountStatus');
                Route::post('repayment', 'Loan\ContractController@Repayment');
                Route::post('bills', 'Loan\ContractController@loadBills');
                Route::post('transactions', 'Loan\ContractController@loadTransactions');

            });

            Route::group(['prefix' => 'Upload', 'middleware' => 'permission:LOAN_MANAGEMENT.UPLOAD_APPLICATION'], function () {
                Route::get('/', 'Loan\ImportController@loan_upload_landing_page');
                Route::post('/', 'Loan\ImportController@loan_import');
                Route::get('Confirm', 'Loan\ImportController@confirm_page');
                Route::post('Confirm', 'Loan\ImportController@submitConfirm');
                Route::get('Cancel', 'Loan\ImportController@confirmCancel');
                Route::post('Obj', 'Loan\ImportController@loan_upload_obj');
                Route::get('Template/{function}', 'Loan\ImportController@loan_download_template');
            });
            
            Route::group(['prefix' => 'Report'], function () {
                Route::get('Transaction', 'Loan\ReportController@transaction_report')->middleware('permission:LOAN_MANAGEMENT.PAYMENT_TXN');
                Route::post('Transaction/objectData', 'Loan\ReportController@transactionObjectData')->middleware('permission:LOAN_MANAGEMENT.PAYMENT_TXN');
                Route::get('Bill', 'Loan\ReportController@recipient_report');
                Route::post('Bill/objectData', 'Loan\ReportController@recipientObjectData');
            });

            Route::get('ContractReport', 'Loan\ReportController@contract_report');
            Route::post('ContractReport/objectData', 'Loan\ReportController@contractObjectData');
            Route::post('ContractReport/Export/Excel', 'Loan\ReportController@contractExport');

            Route::group(['prefix' => 'CreditScore\{id}'], function () {
                Route::post('objectData', 'Loan\CreditScoreController@objectData');
                Route::post('add', 'Loan\CreditScoreController@add');
            });

        });

        Route::group(['prefix' => 'PaymentTransaction', 'middleware'  => 'permission:PAYMENT_TRANSACTION.*'], function () {
            Route::get('Download/Template/{template}', 'PaymentTransactionController@download_template')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::get('/', 'PaymentTransactionController@index')->middleware('permission:PAYMENT_TRANSACTION.VIEW');
            Route::get('Detail/{request_id}', 'PaymentTransactionController@detail')->middleware('permission:PAYMENT_TRANSACTION.VIEW');
            Route::post('objectData', 'PaymentTransactionController@objectData')->middleware('permission:PAYMENT_TRANSACTION.VIEW');
            Route::get('Import', 'PaymentTransactionController@create')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::get('Import/Confirm', 'PaymentTransactionController@confirm')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::get('Import/Confirm/Repayment-Cash', 'PaymentTransactionController@ConfirmPageRepaymentCash')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::post('Import', 'PaymentTransactionController@create_save')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::post('Import/objectData', 'PaymentTransactionController@objectDataConfirm')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::post('Import/CreateConfirm', 'PaymentTransactionController@confirm_upload')->middleware('permission:PAYMENT_TRANSACTION.IMPORT');
            Route::post('Export/Excel', 'PaymentTransactionController@transactionExport')->middleware('permission:PAYMENT_TRANSACTION.EXPORT');
        });

        Route::group(['prefix' => 'Bill', 'middleware'  => 'permission:BILL.*'], function () {
            Route::get('/', 'Bill\UploadController@index');
            Route::get('Import', 'Bill\UploadController@import')->middleware('permission:BILL.UPLOAD_CONSUMER_BILL'); //UPLOAD_CONSUMER_BILL
            Route::get('Create', 'Bill\UploadController@create');
            Route::post('Verify', 'Bill\UploadController@call_verify');
            Route::post('Create', 'Bill\UploadController@create_post');
            Route::get('Import/Confirm', 'Bill\UploadController@confirm');
            Route::post('Import', 'Bill\UploadController@import_save');
            Route::get('Detail/{reference}', 'Bill\UploadController@detail')->middleware('permission:BILL.VIEW');
            Route::post('objectData', 'BillController@objectData');
            Route::post('Import/objectData', 'Bill\UploadController@objectDataConfirm');
            Route::post('Import/CreateConfirm', 'Bill\UploadController@confirm_upload');
            Route::get('Get/Template/{document_type}/{mapping_id}', 'Bill\UploadController@download_template');
            Route::get('Get/Template/Full/{document_type}/{mapping_id}', 'Bill\UploadController@download_full_template');
            Route::get('Get/Template/XLSX', 'Bill\UploadController@download_xlsx_template');
            Route::get('Get/Bill/Template/{template_type}', 'Bill\UploadController@download_bill_template');
            Route::post('Export/Excel', 'Loan\ReportController@recipientExport');
            Route::post('request/notify-send', 'BillController@ResendNotifyBill');
            Route::post('request/repayment', 'BillController@Repayment');      
            Route::post('inactive', 'BillController@InactiveBill');  

            Route::get('create', 'Bill\SimpleCreateController@createNoCorporate');
            Route::group(['prefix' => '{corporate_code}'], function () {
                Route::get('create', 'Bill\SimpleCreateController@create');
                Route::post('create', 'Bill\SimpleCreateController@createSubmit');
            });

            Route::post('Get/download_invoice', 'Bill\UploadController@download_invoice');
            Route::post('Get/download_receipt', 'Bill\UploadController@download_receipt');
            
        });

        

        Route::group(['prefix' => 'Settlement'], function () 
        {
            Route::group(['prefix' => 'Product'], function () 
            {
                Route::get('/', 'SettlementController@index'); 
                Route::post('objectData', 'SettlementController@object_data_channel');  
                Route::get('/add_product/{channel_name}', 'SettlementController@add_product');  
                Route::get('/edit/{corp_code}/{channel_name}', 'SettlementController@edit'); 

                Route::group(['prefix' => 'Upload'], function () 
                {
                    Route::get('/', 'SettlementController@upload'); 
                    Route::post('', 'SettlementController@import_settlement');
                    Route::get('Confirm', 'SettlementController@confirm_page');
                    Route::post('Obj', 'SettlementController@confirm_obj');
                    Route::post('Confirm', 'SettlementController@submitConfirm');
                });
                

                Route::group(['prefix' => 'corporate'], function () 
                {
                    Route::post('edit_channell', 'SettlementController@edit_channell'); 
                    Route::post('update', 'SettlementController@update_corp'); 
                    Route::get('create/{channel_name}', 'SettlementController@create_product_corporate');  
                    Route::post('objectData', 'SettlementController@corporate_obj'); 
                    Route::post('create_corporate', 'SettlementController@corporate_create');  
                    Route::post('select2_corpid', 'SettlementController@select2_corpid');  
                    Route::post('select2_config', 'SettlementController@select2_config');  
                    
                });
            });
        });
        
            


        Route::group(['prefix' => 'Item', 'middleware'  => 'permission:BILL.*'], function () {
            Route::get('Setting', 'ItemProductSettingController@index'); 
            Route::post('objectData', 'ItemProductSettingController@objectData'); 
            Route::get('Product/Create', 'ItemProductSettingController@createItem'); 
            Route::post('Product/Detail', 'ItemProductSettingController@itemDetail'); 
            Route::post('manageItem', 'ItemProductSettingController@manageItem'); 
            Route::post('deleteItem', 'ItemProductSettingController@deleteItem');
            Route::post('Search', 'ItemProductSettingController@Search');
        });


        Route::group(['prefix' => 'Recipient', 'middleware'  => 'permission:RECIPIENT.*'], function () {
            Route::get('/', 'RecipientManageController@index');
            Route::get('Create', 'RecipientManageController@create');
            Route::post('Create', 'RecipientManageController@createSave');
            Route::post('objectData', 'RecipientManageController@objectData');
            Route::post('objectData/Count', 'RecipientManageController@objectDataCount');
            Route::get('Profile/{code}', 'RecipientManageController@profile');
            Route::get('Profile/Update/{code}', 'RecipientManageController@profileUpdate');
            Route::get('Profile/Invitation/{code}', 'RecipientManageController@profileInvitation');
            Route::post('Profile/Update/{code}', 'RecipientManageController@UpdateSave');
            Route::get('Contract/{code}', 'RecipientManageController@contract');
            Route::get('ContractInfo/{code}/{contact_code}', 'RecipientManageController@ContractInfo');
            Route::get('Create/ContractInfo/{code}', 'RecipientManageController@CreateContract');
            Route::post('Create/ContractInfo/{code}', 'RecipientManageController@CreateContractSave');
            Route::get('ContractInfo/UpdateContract/{recipient_code}/{contract_code}', 'RecipientManageController@UpdateContract');
            Route::post('ContractInfo/UpdateContract/{recipient_code}/{contract_code}', 'RecipientManageController@UpdateContractSave');
            Route::post('request/select2', 'RecipientManageController@select2_recipient');
            Route::post('select2_recipient2', 'RecipientManageController@check_code');
            Route::post('recipient/activity', 'RecipientManageController@recipient_activity');
            Route::post('request/cardstore', 'RecipientManageController@sendSMSCardStore');

            Route::group(['prefix' => 'Upload', 'middleware'  => 'permission:RECIPIENT.VIEW_INDIVIDUAL_CUSTOMER_INFORMATION'], function () {
                Route::get('/', 'RecipientManageController@upload_page');
                Route::get('Template/{template}', 'RecipientManageController@download_template');
                Route::get('Confirm', 'RecipientManageController@confirm_page');
                Route::get('Cancel', 'RecipientManageController@confirmCancel');
                Route::post('', 'RecipientManageController@import_recipient');
                Route::post('Confirm', 'RecipientManageController@submitConfirm');
                Route::post('Obj', 'RecipientManageController@confirm_obj');
            });

            // Route::group(['prefix' => 'Group', 'middleware'  => 'permission:RECIPIENT.VIEW_GROUP_RECIPIENT'], function () {
            //     Route::get('/', 'RecipientManageController@group');
            //     Route::get('Create', 'RecipientManageController@create_group');
            //     Route::post('Select', 'RecipientManageController@select_recipient');
            //     Route::post('Create/RecipientGroup', 'RecipientManageController@create_recipient_group');
            //     Route::get('Edit/{group_id}', 'RecipientManageController@edit_group');
            //     Route::post('Edit/RecipientGroup', 'RecipientManageController@edit_recipient_group');
            //     Route::post('Delete', 'RecipientManageController@delete_recipient_group');
            // });
        });

        Route::group(['prefix' => 'Recurring'], function () {
            Route::get('/', 'RecurringController@index');
            Route::post('objectData', 'RecurringController@objectData');
            Route::post('Export/Excel', 'RecurringController@ExportCard');
            Route::get('Download/{request}', 'RecurringController@DownloadCard');
            Route::post('Card/Delete', 'RecurringController@DeleteCard');

            
            Route::get('/Cancel', 'RecurringController@confirmCancel');


            
            Route::group(['prefix' => 'Bill'], function () {
                Route::get('/', 'RecurringController@bill');
                Route::get('/Detail', 'RecurringController@bill');
                Route::get('/Detail/{reference_code}', 'RecurringController@bill_detail');
                
                Route::post('objectData', 'RecurringController@bill_objectdata');

                
            });


            Route::group(['prefix' => 'Transaction'], function () {
                Route::get('/', 'RecurringController@RecurringTransaction');
                Route::post('/ObjectData', 'RecurringController@TransactionObjectData');
                Route::get('/DownloadTemplate/Approve/{template}', 'RecurringController@download_template_approve');
                Route::get('/DownloadTemplate/Declined/{template}', 'RecurringController@download_template_declined');
            });
            Route::group(['prefix' => 'Payment'], function () {
                Route::get('/import', 'RecurringController@recurring_import');
                Route::post('/upload', 'RecurringController@upload_page');
                Route::post('/Upload_Obj', 'RecurringController@confirm_obj');
                Route::get('/show', 'RecurringController@show');
                Route::post('/Upload/Confirm', 'RecurringController@submitConfirm');

            });

            // Route::post('/Recurring/Upload/Confirm', 'RecurringController@submitConfirm');

        });

        // Route::group(['prefix' => 'FieldMapping', 'middleware'  => 'permission:ETAX.MAPPING_VIEW'], function () {
        Route::group(['prefix' => 'FieldMapping'], function () {
            Route::get('/', 'FieldMappingController@index');
            Route::get('Detail/{code}', 'FieldMappingController@detail');
            Route::get('Import', 'FieldMappingController@import');
            Route::post('Import', 'FieldMappingController@importPost');
            Route::get('Create', 'FieldMappingController@create');
            Route::post('Create', 'FieldMappingController@createPost');
            Route::post('objectData', 'FieldMappingController@objectData');
            Route::get('Template/{doc_type}/{doc_code}', 'FieldMappingController@Get_Template');
            Route::get('New/Default', 'FieldMappingController@CreateNewDefault');
        });
        
        // ETAX
        Route::get('ETax', 'ETaxController@index');
        Route::get('ETax/Create', 'ETaxController@create');
        Route::post('ETax/get_corp_mapping_field', 'ETaxController@get_corp_mapping_field');
        Route::post('ETax/Create', 'ETaxController@create_save');
        Route::get('Etax/Create/Template', 'ETaxController@template');
        Route::get('ETax/Create/Confirm', 'ETaxController@confirm');
        Route::post('ETax/Upload/objectDataUpload', 'ETaxController@objectDataUpload');
        Route::post('ETax/Upload/CreateConfirm', 'ETaxController@confirm_upload');
        Route::get('ETax/Get/Template/{document_type}/{mapping_id}', 'ETaxController@download_template');
        Route::get('Download/Error/File', 'ETaxController@download_error_file');

        //downloadPDF && XML
        Route::get('ETax/Download/PDF/{invoice_number}', 'ETaxController@downloadPDF');
        Route::get('ETax/Download/XML/{invoice_number}', 'ETaxController@downloadXML');
        // Route::post('ETax/Download/PDF', 'ETaxController@downloadPDF');

        Route::post('Etax/objectData', 'ETaxController@EtaxobjectData');
        Route::post('Etax/batch/objectData', 'ETaxController@BatchobjectData');
        Route::post('Etax/ConfirmSign', 'ETaxController@confirm_sign');
        Route::post('Etax/Document/Logs', 'ETaxController@EtaxFileLogs');
        Route::post('Etax/Document/Txt', 'ETaxController@EtaxTXTDetail');
        Route::post('Etax/objectJobs', 'ETaxController@objectJobs');
        

        Route::group(['prefix' => 'Visa'], function () {
            Route::group(['prefix' => 'VirtualCard'], function () {
                Route::get('/', 'Visa\VirtualCardController@index');
                Route::get('/setting', 'Visa\VirtualCardController@setting');
                Route::get('/card_type', 'Visa\VirtualCardController@add_card_type');
                Route::get('/request/{reference_code}', 'Visa\VirtualCardController@request');
                Route::post('/card_type', 'Visa\VirtualCardController@post_card_type');
                Route::post('/request', 'Visa\VirtualCardController@post_request');
                Route::post('/post_perform', 'Visa\VirtualCardController@post_perform');
                Route::post('objectData', 'Visa\VirtualCardController@objectData');
                Route::get('transaction', 'Visa\VirtualCardController@visa_transaction');
                Route::post('Object_Transaction', 'Visa\VirtualCardController@object_transaction');
            });
        });
        
        Route::group(['prefix' => 'Support', 'middleware' => 'permission:SUPPORT.*'], function () {

            Route::group(['middleware' => 'permission:SUPPORT.BILL_PAYMENT'], function () {
                Route::get('Bill', 'SupportController@search_bill');
                Route::post('objectDataBill', 'SupportController@objectDataBill');
                Route::get('Bill/Detail/{reference_code}', 'SupportController@bill_detail');

                Route::group(['prefix' => 'Bill/Activity', 'middleware'  => 'permission:SUPPORT.BILL_ACTIVITY_LOGS'], function () {
                    Route::get('/', 'Bill\LogsController@index');
                    Route::post('/', 'Bill\LogsController@objectData');
                });

            });
            
        });
        
        Route::group(['prefix' => 'report', 'middleware' => 'permission:REPORT.*'], function () {

            Route::get('corporate', 'Report\DownloadController@corporate')
                ->middleware('permission:REPORT.CORPORATE');
                
            Route::get('bill', 'Report\DownloadController@bill_payment')
                ->middleware('permission:REPORT.BILL_PAYMENT');

            Route::get('payment', 'Report\DownloadController@payment_transaction')
                ->middleware('permission:REPORT.PAYMENT_TRANSACTION');

            Route::post('request/search', 'Report\DownloadController@get_list')
                ->middleware('permission:REPORT.PAYMENT_TRANSACTION,REPORT.BILL_PAYMENT,REPORT.CORPORATE');

            Route::post('request/search/corporate', 'Report\DownloadController@search_corporate')
                ->middleware('permission:REPORT.PAYMENT_TRANSACTION,REPORT.BILL_PAYMENT');


            // NEW --
            Route::get('download', 'Report\DownloadController@download')
                ->middleware('permission:REPORT.SUMMARY_AUDIT_LOG_REPORT,REPORT.PAYMENT_TRANSACTION,REPORT.BILL_PAYMENT,REPORT.CORPORATE');

            Route::group([ 'middleware' => 'permission:REPORT.SUMMARY_AUDIT_LOG_REPORT,REPORT.SUMMARY_PAYMENT_RECONCILE_REPORT,REPORT.SUMMARY_BILL_PAYMENT_REPORT,REPORT.SUMMARY_CORPORATE_REPORT,REPORT.SUMMARY_PAYMENT_TRANSACTION_REPORT,REPORT.CORPORATE' ], function () {
                Route::get('inquiry', 'Report\InquiryController@inquiry_page');
                Route::post('inquiry', 'Report\InquiryController@inquiry');
                Route::get('request/get/file-url', 'Report\InquiryController@single_download');
            });

        });
        
        Route::group(['prefix' => 'BAAC'], function () {
            Route::group(['prefix' => 'Product'], function () {
                Route::get('/', 'BAAC\ProductController@index');
                Route::post('/objectData', 'BAAC\ProductController@objectData');
                Route::get('/Upload', 'BAAC\ProductController@product_upload_page');
                Route::post('/Upload', 'BAAC\ProductController@import_product');
                Route::get('/Detail/{code}', 'BAAC\ProductController@product_detail');
                Route::post('/Update', 'BAAC\ProductController@product_update');
            });
            
            Route::group(['prefix' => 'Recipient'], function () {
                Route::get('/Activity', 'BAAC\RecipientController@recipient_activity');
                Route::post('/Activity/objectData', 'BAAC\RecipientController@activity_objectData');
                Route::get('/Bookstate', 'BAAC\RecipientController@recipient_bookstate');
                Route::post('/Bookstate/objectData', 'BAAC\RecipientController@bookstate_objectData');
                Route::get('/Bookstate/Tracking/{code}', 'BAAC\RecipientController@bookstate_tracking');
                Route::post('/Bookstate/Tracking/objectData', 'BAAC\RecipientController@tracking_objectData');
            });
        });
        
    });

    Route::group(['prefix' => 'customer/loan'], function () {
        Route::get('/', 'Loan\CustomerPortalController@index');
        Route::post('/auth', 'Loan\CustomerPortalController@objectData');
    });

    // ADFS TMB LOGIN
    Route::group(['middleware' => ['xss', 'prevent-back-history']], function () {
        Route::get('api/adfs/tmb', 'TMB\AdfsController@index');
        Route::post('api/adfs/tmb', 'TMB\AdfsController@login');
        Route::post('api/adfs/logout/tmb', 'TMB\AdfsController@logout');
    });

    Route::get('/visaregis', 'Visaregis\VisaregisController@index');
    Route::get('/visaregis/ลงทะเบียน', 'Visaregis\VisaregisController@regis');
    Route::get('/visaregis/success/{code?}', 'Visaregis\VisaregisController@create_success');
    Route::post('create_submit', 'Visaregis\VisaregisController@create_submit');
    Route::post('zipcode_address', 'Visaregis\VisaregisController@zipcode_address');
    Route::post('bank', 'Visaregis\VisaregisController@bank');

*/


