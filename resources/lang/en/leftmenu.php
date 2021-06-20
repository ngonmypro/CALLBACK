<?php
return 
    [
        'dashboard'       => 'Dashboard',
        'corporate'       => 'Corporate',
        'user_management'       => 'User Management',
        'corporate_usermanagement'  => 'Corporate User Management',
        'agent_usermanagement'  => 'Agent User Management',
        'role_management'       => 'Role Management',
        'agents_management'       => 'Agents',
        'invoice'           => 'Invoice',
        'support'       => 'Support',
        'search_bill'       => 'Search Bill',
        'etax'       => 'E-Tax',
        'file_mapping'       => 'Field mapping',
        'main_title'       => 'E-Tax Demo',
        'sign_out'       => 'Sign out',
        'login_time'       => 'Login time',
        'footer'  => '©2019 All Rights Reserved. Powered by Digio and PCC. |  Version 1.0',
        'broadcast' => 'Broadcast',
        'news' => 'News',
        'richmenu' => 'Richmenu',
        'loan' => 'Loan Management',
        'loan_application'  => 'All Applications',
        'payment_transaction' => 'Payment Transaction',
        'repayment_transaction' => 'Manual Payment',
        'recipient' => 'Recipient',
        'list' => 'Individual',
        'group' => 'Group',
        'edit_profile' => 'Edit Profile',
        'my_profile' => 'My Profile',
        'item_product' => 'Item Product',
        'item_product_setting' => 'Item Setting',
        'bill' => [
            'title'             => 'Bill',
            'listpage'          => 'List of bill'
        ],
        'all_bill' => 'All',
        'line' => 'LINE',
        'corpsetting-loan_schedule' => 'Schedule',
        'corporate_role'            => 'Corporate Roles',
        'agent_role'                => 'Agent Roles',
        'report'    => [
            'title'                 => 'Report',
            'corporate'             => 'Corporate',
            'bill_payment'          => 'Bill Payment',
            'payment_transaction'   => 'Payment Transaction',
            'inquiry'               => 'Inquiry Report',
        ],
        'manage'    => [
            'bill'          => [
                'log_activity'      => 'Bill Activity Logs'
            ]
        ],
        'corporate_setting'       => 'Setting',
        'corp_current_name' =>  Session::get('CORP_CURRENT')['name_en'] ?? '',
        'recurring_title'                 => 'Recurring',
        'recurring' =>  'Recurring'
        
    ];
