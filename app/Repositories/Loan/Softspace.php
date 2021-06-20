<?php

namespace App\Repositories\Loan;

use App\Http\Requests\LoanApplicationUpload;
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

class Softspace
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
        $func = __FUNCTION__;
    
        try {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);

            if (!$this->CORP_CURRENT) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'invalid request user'
                ], 200);
            }

            $arrObj = [];
            $__key = null;

            //read file excel
            $result = Excel::load($file);
            $data = $result->toArray();

            // 1. name
            // 2. ic
            // 3. email
            // 4. mobile_no
            // 5. duitnow_user
            // 6. delivery_address
            // 7. postcode
            // 8. state
            // 9. product_name
            // 10.product_price
            // 11.installment
            // 12.tenure

            array_walk_recursive($data, function (&$input) {
                $input = htmlentities($input);
            });

            foreach($data as $key => $value) {
                $UPLOAD_STATUS = true;
                $ERROR = '';               
                
                //validation
                $validator = Validator::make($value, [
                    'name'                  =>  'required|max:100',
                    'ic'                    =>  'required|digits:12',
                    'email'                 =>  'required|email',
                    'mobile_no'             =>  'required|digits_between:8,11',
                    'duitnow_user'          =>  'required|max:3',
                    'delivery_address'      =>  'required',
                    'postcode'              =>  'required|digits:5',
                    'state'                 =>  'required',
                    'product_name'          =>  'required|max:100',
                    'product_price'         =>  'required|numeric',
                    'installment'           =>  'required|numeric',
                    'tenure'                =>  'required|numeric|min:1,max:99',
                    'document_name'         =>  'nullable',
                    'document_url'          =>  'nullable|url',
                ]);

                $exclude = ['document_name', 'document_url'];
                $check_all_blank = $this->helper->is_all_equal($value, $exclude, function($result) { 
                    return blank($result); 
                });

                if (isset($value['document_url']) && isset($value['document_name']) && !blank($value['document_url']) && !blank($__key) && $check_all_blank) {
                
                    array_push($arrObj[$__key]['document'], [
                        'url'       => $value['document_url'],
                        'name'      => $value['document_name'],
                    ]);
                    continue;

                } else if ($validator->fails()) {

                    Log::error("[{$func}] error: validation fail, record: ".json_encode($value));
                    $UPLOAD_STATUS = false;

                    $fail_validate = $validator->messages()->all();
                    $error = $validator->messages()->toJson();

                    foreach ($fail_validate as $key => $val) {
                        $ERROR = blank($ERROR) 
                            ? $val 
                            : "{$ERROR} | {$val}";
                    }
                }
                
                $value['error_message']  = $ERROR;
                $value['upload_status']  = $UPLOAD_STATUS;
                $value['document']       = [];
                $push_arr = $value;
                
                $__key = md5($this->helper->generateSalt(6));

                if (isset($value['document_url']) && $value['document_name'] && !blank($value['document_url'])) {
                    array_push($push_arr['document'], [
                        'url'       => $value['document_url'],
                        'name'      => $value['document_name'],
                    ]);
                } 
                                
                $arrObj[$__key] = $push_arr;
            }

            // Log::debug('array: ', $arrObj);
            Session::put('loan_import_data', $arrObj);

            return response()->json([
                'success' => true
            ]);

        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
