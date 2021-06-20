<?php

namespace App\Repositories\Loan;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Repositories\Helper;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use File;
use GuzzleHttp\Client;
use App\Http\Requests\LoanApplicationUpload;

class Flash
{
    public function __construct()
    {
        $this->helper               = new Helper();
        $this->client               = new Client([
            'base_uri'  => env('API_URL'),
            'headers'   => ['Authorization' => 'Bearer '.Session::get('token')]
        ]);

        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
    }

    public function file_upload(LoanApplicationUpload $request)
    {
        $file = $request->file('file');
        $real_name = $file->getClientOriginalName();
        $type_file = File::extension($real_name);

        if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
            return response()->json([
                'success'   => false,
                'message'   => 'ไฟล์ที่อัพโหลดไม่รองรับ'
            ], 200);
        }
            
        try {
            $corporate_id = $this->CORP_CURRENT;

            if (!$corporate_id) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'กรุณาเลือกบริษัทก่อนทำการอัพโหลด'
                ], 200);
            }

            $arrObj = [];
            $__key = null;

            //read file excel
            $result = Excel::load($file);
            $data = $result->toArray();

            array_walk_recursive($data, function (&$input) {
                $input = htmlentities($input);
            });

            foreach($data as $key => $value) {

                // State
                $UPLOAD_STATUS = true;
                $ERROR = '';
                $remark_status = '';

                // Contract
                $contract_reference			= isset($value['contract_reference']) && !blank($value['contract_reference']) ? $value['contract_reference'] : null;
                
                $effective_date				= isset($value['effective_date']) && !blank($value['effective_date']) ? $value['effective_date'] : null;
                $submit_date				= isset($value['submit_date']) && !blank($value['submit_date']) ? $value['submit_date'] : null;
                $contract_name				= isset($value['contract_name']) && !blank($value['contract_name']) ? $value['contract_name'] : null;

                // สลับกันตาม template csv
                $contract_period			= isset($value['contract_period']) && !blank($value['contract_period']) ? $value['contract_period'] : null;
                $total_amount				= isset($value['total_amount']) && !blank($value['total_amount']) ? $value['total_amount'] : null;

                $contract_installment		= isset($value['contract_installment']) && !blank($value['contract_installment']) ? $value['contract_installment'] : null;

                // Product
                $product_reference			= isset($value['product_reference']) && !blank($value['product_reference']) ? $value['product_reference'] : null;
                $product_name				= isset($value['product_name']) && !blank($value['product_name']) ? $value['product_name'] : null;
                $product_price				= isset($value['product_price']) && !blank($value['product_price']) ? $value['product_price'] : null;

                // Customer
                $customer_code              = isset($value['customer_code']) && !blank($value['customer_code']) ? $value['customer_code'] : null;
                $customer_name			    = isset($value['customer_name']) && !blank($value['customer_name']) ? $value['customer_name'] : null;
                $customer_email				= isset($value['customer_email']) && !blank($value['customer_email']) ? $value['customer_email'] : null;
                $customer_telephone			= isset($value['customer_telephone']) && !blank($value['customer_telephone']) ? $value['customer_telephone'] : null;
                $customer_citizen_id		= isset($value['customer_citizen_id']) && !blank($value['customer_citizen_id']) ? $value['customer_citizen_id'] : null;
                $invoice_address			= isset($value['invoice_address']) && !blank($value['invoice_address']) ? $value['invoice_address'] : null;
                $country_code               = isset($value['country_code']) && !blank($value['country_code']) ? $value['country_code'] : null;
                $currency                   = isset($value['currency']) && !blank($value['currency']) ? $value['currency'] : null;

                // Document
                $document_url				= isset($value['document_url']) && !blank($value['document_url']) ? $value['document_url'] : null;
                $document_name				= isset($value['document_name']) && !blank($value['document_name']) ? $value['document_name'] : null;
                $occupation					= isset($value['occupation']) && !blank($value['occupation']) ? $value['occupation'] : null;
                $occupation_type			= isset($value['occupation_type']) && !blank($value['occupation_type']) ? $value['occupation_type'] : null;
                $work_address				= isset($value['work_address']) && !blank($value['work_address']) ? $value['work_address'] : null;
                $work_telephone				= isset($value['work_telephone']) && !blank($value['work_telephone']) ? $value['work_telephone'] : null;

                // Not use
                $interest_rate		        = isset($value['interest_rate']) && !blank($value['interest_rate']) ? $value['interest_rate'] : null;
                $interest_amount	        = isset($value['interest_amount']) && !blank($value['interest_amount']) ? $value['interest_amount'] : null;
                $fee_amount				    = isset($value['fee_amount']) && !blank($value['fee_amount']) ? $value['fee_amount'] : null;
                $fee_rate				    = isset($value['fee_rate']) && !blank($value['fee_rate']) ? $value['fee_rate'] : null;
                $contract_signed_date		= isset($value['contract_signed_date']) && !blank($value['contract_signed_date']) ? $value['contract_signed_date'] : null;
                $remark				        = isset($value['remark']) && !blank($value['remark']) ? $value['remark'] : null;                    
                $promptpay				    = isset($value['promptpay']) && !blank($value['promptpay']) ? $value['promptpay'] : null;                    
                $internet_banking		    = isset($value['internet_banking']) && !blank($value['internet_banking']) ? $value['internet_banking'] : null;                    

                //validation
                $validator = Validator::make($value, [
                    // Contract
                    'contract_reference'                  	=>  'nullable|alpha_num|max:20',
                    'customer_reference'                  	=>  'nullable|alpha_num|max:20',
                    'effective_date'                        =>  'nullable|date_format:d/m/Y',
                    'submit_date'                  			=>  'nullable|date_format:d/m/Y',
                    'contract_name'                    		=>  'required',
                    'contract_period'                    	=>  'required|numeric',
                    'contract_installment'                  =>  'required|numeric',
                    'total_amount'                   		=>  'required|numeric',

                    // Product
                    'product_reference'                   	=>  'nullable',
                    'product_name'                   		=>  'required',
                    'product_price'                    		=>  'required|numeric',

                    // Customer
                    'currency'                              =>  'nullable|max:3|in:THB',
                    'country_code'                          =>  'nullable|max:2|in:TH',
                    'customer_code'                         =>  'nullable|alpha_num',
                    'customer_name'                         =>  'required|max:100',
                    'customer_email'                    	=>  'required|email',
                    'customer_telephone'                    =>  'required|numeric',
                    'customer_citizen_id'                   =>  'required|digits:13',
                    'invoice_address'                   	=>  'required',
                    'occupation_type'                     	=>  'nullable',
                    'work_address'                         	=>  'nullable',
                    'work_telephone'                   		=>  'nullable',

                    // Document
                    'document_url'                   		=>  'nullable|url',
                    'document_name'                    		=>  'nullable',
                ]);

                $exclude = ['document_name', 'document_url', 'contract_reference'];
                $check_all_null = $this->helper->is_all_equal($value, $exclude, function($result) { 
                    return blank($result); 
                });

                if (!blank($document_url) && !blank($__key) && $check_all_null) {
                
                    array_push($arrObj[$__key]['document'], [
                        'url'       => $document_url,
                        'name'      => $document_name,
                    ]);
                    continue;

                } else if ($validator->fails()) {

                    Log::error("[loan_import] error: validation fail, record: ".json_encode($value));
                    $UPLOAD_STATUS = false;

                    $ERROR = $validator->messages()->toJson();

                    $ERROR = join( " | ", collect( json_decode($ERROR, true) )->flatten()->all() );
                }

                if ( !blank($contract_reference) ) {
                    // Service validating
                    $response = $this->helper->PostRequest($this->client, 'api/loan/contract/search',
                        [
                            'code'			=> $contract_reference,
                            'corporate_id'	=> $this->CORP_CURRENT
                        ]
                    );

                    if ( $response->success && $response->data ) {
                        $msg = 'เลขที่สัญญานี้มีอยู่ในระบบแล้ว.';
                        $UPLOAD_STATUS = false;
                        $remark_status = $remark_status != ''
                            ? $remark_status.' | '.$msg
                            : $msg;

                        $ERROR = blank($ERROR) ? $msg : $ERROR.' | '.$msg;
                    } else if ( !$response->success ) {
                        $msg = $response->message;
                        $UPLOAD_STATUS = false;
                        $remark_status = $remark_status != ''
                            ? $remark_status.' | '.$msg
                            : $msg;

                        $ERROR = blank($ERROR) ? $msg : $ERROR.' | '.$msg;
                    }
                }

                $__key = $this->helper->generateSalt(6);
                $push_arr = [];
                $push_arr['contract_reference']               	= $contract_reference;
                $push_arr['submit_date']                   		= $submit_date;
                $push_arr['effective_date']                     = $effective_date;
                $push_arr['contract_name']                     	= $contract_name;
                $push_arr['contract_period']                	= $contract_period;
                $push_arr['contract_installment']               = $contract_installment;
                $push_arr['total_amount']                       = $total_amount;
                $push_arr['product_reference']                  = $product_reference;
                $push_arr['product_name']                  		= $product_name;
                $push_arr['product_price']                      = $product_price;
                $push_arr['currency']                           = $currency;
                $push_arr['country_code']                       = $country_code;
                $push_arr['customer_code']                      = $customer_code;
                $push_arr['customer_name']                      = $customer_name;
                $push_arr['customer_email']                     = $customer_email;
                $push_arr['customer_telephone']                 = $customer_telephone;
                $push_arr['customer_citizen_id']                = $customer_citizen_id;
                $push_arr['invoice_address']                    = $invoice_address;

                $push_arr['remark']                     	    = $remark;
                $push_arr['occupation_type']                    = $occupation_type;
                $push_arr['occupation']                         = $occupation;
                $push_arr['work_address']                       = $work_address;
                $push_arr['work_telephone']                     = $work_telephone;
                $push_arr['promptpay']                          = $promptpay;
                $push_arr['internet_banking']                   = $internet_banking;

                $push_arr['error_message']                      = $ERROR;
                $push_arr['upload_status']						= $UPLOAD_STATUS;

                $push_arr['fee_amount']                         = $fee_amount;
                $push_arr['fee_rate']                           = $fee_rate;
                $push_arr['contract_signed_date']             	= $contract_signed_date;
                $push_arr['interest_amount']                    = $interest_amount;
                $push_arr['interest_rate']                      = $interest_rate;
                $push_arr['document']                           = [];

                if (!blank($document_url)) {
                    array_push($push_arr['document'], [
                        'url'       => $document_url,
                        'name'      => $document_name,
                    ]);
                } 
                                
                $arrObj[$__key] = $push_arr;
            }

            Session::put('loan_import_data', $arrObj);
            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
