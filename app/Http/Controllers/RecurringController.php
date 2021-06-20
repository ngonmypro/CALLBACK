<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use GuzzleHttp;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateRecipientRequest;
use App\Http\Requests\EditRecipientRequest;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use File;
use PDF;
use Exception;

class RecurringController extends Controller
{
    private $helper;
    private $api_client;
    private $logger;

    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
        $this->logger               = parent::Logger();

        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
    }

    public function index()
    {
        return view('Recurring.index');
    }

    public function objectData(Request $request)
    {
        try {
            if (!blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            
            $response = $this->api_client->post('api/recipient/cardstore/objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ExportCard(Request $request)
    {
        Log::info(json_encode($request->all()));
        try {
            $start_date = $end_date = null;
            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($e[0]))) );
                $end_date 	= date('Y-m-d', strtotime(str_replace('/', '-', trim($e[1]))) );
            }
            $json = $this->helper->PostRequest($this->api_client, 'api/recipient/cardstore/export',
                [
                    'start_date'    => $start_date,
                    'end_date'      => $end_date,
                    'customer_code' => $request->status,
                    'corp_code'     => $request->corp_code
                ]
            );

            if ( isset($json->resCode) && $json->resCode == '00') {

                return response()->json([
                    'success' => true
                ]);

            } else {

                return response()->json([
                    'success' => false,
                    'message' => $json->message ?? '',
                ]);
            }

        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'something went wrong.',
            ]);
        }
    }

    public function DownloadCard($request) 
    {
        try {
            $request = json_decode(\base64_decode($request), true);
            if (!blank($request['daterange'])) {
                $e = explode('-', $request['daterange']);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            $request['corp_code']   = $request['corp_code'] == 'null' ? '' : $request['corp_code'];

            $data_response = $this->helper->PostRequest($this->api_client,'api/recipient/cardstore/download', $request);
            if ($data_response->success) {
                $file = base64_decode($data_response->data);
                $file_name = 'RECIPIENT_RECURRING_CARD_'.date('Ymd');
                $response = \Response::make($file);
                $response->header('Content-Type', 'text/csv');
                $response->header('Content-disposition',"attachment; filename=$file_name.xlsx");
                return $response;
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'Empty Card Data!');
                return view('Exception.Close');
            }
        } catch (\Exception $e) {
            report($e);
            return redirect('/Exception/InternalError');
        }
    }

    public function DeleteCard(Request $request) 
    {
        try {
            if (!blank($request['daterange'])) {
                $e = explode('-', $request['daterange']);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));
                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            $response = $this->helper->PostRequest($this->api_client,'api/recipient/cardstore/delete', $request->all());
            if ($response->success) {
                return response()->json([
                    'success' => true,
                    'message' => $response->message
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response->message ?? '',
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function recurring_import (Request $request) 
    {
        return view('Recurring..Upload.import');
    }

    public function upload_page (Request $request) 
    {
        request()->validate([
            'file' => 'required|mimes:txt'
        ]);

        try 
        {
            $path = request()->file('file')->getRealPath();
            $file = file($path);
            $recurring = [];
            $upload_type = null;
            $count = 0;
            $exist_recurring_code = $this->helper->PostRequest($this->api_client, 'api/recurring/check_exist_code', [
                'bank_id'       => $this->BANK_CURRENT,
                'upload_type'   => $request->upload_type 
            ]);

            $type_file = substr($file[0], 7 ,9);
            $type_file = str_replace(' ',null ,$type_file);

            for($x = 4; $x < count($file)-3; $x++) 
            {
                if(!blank($file[$x])) 
                { 
                    if($request->upload_type == 'approved')
                    {
                            $number_no = substr($file[$x], 4 ,2);
                            $reference_no = substr($file[$x], 7 , 20);
                            // $cut = substr($file[$x],26 , 56);
                            $amount = substr($file[$x],84 , 10);
                            $approval = substr($file[$x],106, 6 );
                            $retrieval = substr($file[$x],115, 12 );
        
        
                            //  convert number_no
                            $number_no = str_replace(' ',null ,$number_no);
        
                            //  convert reference_no
                            $reference_no = str_replace(' ',null ,$reference_no);
        
                            //  convert amount
                            $amount = str_replace(',',null ,$amount);
                            $amount = str_replace(' ',null ,$amount);
                            $cut_amount = floatval($amount);

                            $cutamount = str_replace('.00',null ,$amount);
                            $cutamount = intval($cutamount);
        
                            $_list = [];
                            $_list['number_no']                 = isset($number_no) ? $number_no : '';
                            $_list['reference_no']              = isset($reference_no) ? $reference_no : '';
                            $_list['amount']                    = isset($amount) ? $amount : '';
                            $_list['approval']                  = isset($approval) ? $approval : '';
                            $_list['retrieval']                 = isset($retrieval) ? $retrieval : '';
                            // $_list['upload_type']               = $request->upload_type;
                            $_list['remarks']                   = [];
                            $_list['status']                    = [];
        
                            //validation
                            $validator = Validator::make(
                            $_list,
                            [
                                'number_no'                 => 'required',
                                'reference_no'              => 'required',
                                'amount'                    => 'required',
                                'approval'                  => 'required',
                                'retrieval'                 => 'required',
                            ]);

                            $_list['remarks'] = [];
                            $_list['status'] = '';

                                if($validator->fails())
                                {
                                    $_list['remarks'] = $validator->messages()->toArray();
                                    $_list['status'] = 'unmatch';
                                }
                                else if(!blank($reference_no))
                                {
                                
                                    // $duplicate_invoice_no = [];
                                    // $duplicate_invoice_no = $exist_recurring_code->code;
            
                                    // $duplicate_amount = [];
                                    // $duplicate_amount = $exist_recurring_code->price;
    

                                    $recurring_code = $this->helper->PostRequest($this->api_client, 'api/recurring/check_exist_code2', [
                                        'bank_id'       => $this->BANK_CURRENT,
                                        'reference_no'  => $_list['reference_no'],
                                        'bill_total_amount'   => $cut_amount
                                    ]);



                                    if($type_file == "APPROVED")
                                    {

                                        if($recurring_code->success  && !in_array($_list['retrieval'], $exist_recurring_code->tranId, true))
                                        {
                                            $_list['remarks'] = 'PASS';
                                            $_list['status'] = 'success';
                                        }
                                        else if(in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) {
                                            $_list['remarks'] = 'Retrieval has already in used.';
                                            $_list['status'] = 'fail';
                                        }
                                        else{
                                            $_list['remarks'] = 'Reference code and amount does not exist in the database.';
                                            $_list['status'] = 'unmatch';
                                        }

                                        // if (in_array($_list['reference_no'],json_encode($duplicate_invoice_no[$x]), true) &&
                                        //     in_array($cut_amount, json_encode($duplicate_amount[$x]), true) && !in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) 
                                        // { 
                                        //     $_list['remarks'] = 'PASS';
                                        //     $_list['status'] = 'success';
                                        // }
                                   
                                        // else if (in_array($_list['reference_no'],json_encode($duplicate_invoice_no[$x]), true) &&
                                        //     in_array($cutamount, json_encode($duplicate_amount[$x]), true) && !in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) 
                                        // { 
                                  
                                            
                                        //     $_list['remarks'] = 'PASS';
                                        //     $_list['status'] = 'success';
                                        // }
                                        // else if(in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) {
                                        //             $_list['remarks'] = 'Retrieval has already in used.';
                                        //     $_list['status'] = 'fail';
                                        // }
                                        // else
                                        // {
                                        
                                        //     $_list['remarks'] = 'Reference code and amount does not exist in the database.';
                                        //     $_list['status'] = 'unmatch';
                                        // }
                                    }
                                    else
                                    {
                                        $_list['remarks'] = 'The file prototype is not valid.';
                                        $_list['status'] = 'error';
                                    }
                                }
                           
                            array_push($recurring, $_list);
                    

                    }
                    else if($request->upload_type == 'declined')
                    {
                        $number_no = substr($file[$x], 4 ,2);
                        $reference_no = substr($file[$x], 23 , 26);
                        $amount = substr($file[$x],100 , 11);
                        $retrieval = substr($file[$x],120, 17 );
                        $response = substr($file[$x],7, 17 );

                       
                         //  convert number_no
                         $number_no = str_replace(' ',null ,$number_no);
    
                         //  convert reference_no
                         $reference_no = str_replace(' ',null ,$reference_no);
     
                         //  convert amount
                        $amount = str_replace(',',null ,$amount);
                        $amount = str_replace(' ',null ,$amount);
                        $cut_amount = floatval($amount);
                        $cutamount = str_replace('.00',null ,$amount);
                        $cutamount = intval($cutamount);


                        $response = str_replace(' ',null ,$response);
                        //  convert retrieval
                        $retrieval = str_replace(' ',null ,$retrieval);


                        $_list = [];
                        $_list['number_no']                 = isset($number_no) ? $number_no : '';
                        $_list['reference_no']              = isset($reference_no) ? $reference_no : '';
                        $_list['amount']                    = isset($amount) ? $amount : '';
                        $_list['retrieval']                 = isset($retrieval) ? $retrieval : '';
                        $_list['response']                 = isset($response) ? $response : '';


                        // $_list['upload_type']               = $request->upload_type;
                        $_list['remarks']                   = [];
                        $_list['status']                    = [];
                        //validation
                        $validator = Validator::make(
                        $_list,
                        [
                            'number_no'                 => 'required',
                            'reference_no'              => 'required',
                            'amount'                    => 'required',
                            'retrieval'                 => 'required',
                        ]);

                        $_list['remarks'] = [];
                        $_list['status'] = '';
                        $count_invoice = array_count_values($exist_recurring_code->reject);
                        if($validator->fails())
                        {
                            $_list['remarks'] = $validator->messages()->toArray();
                            $_list['status'] = 'unmatch';
                        }
                        else if(!blank($reference_no))
                        {
                           
                            $duplicate_invoice_no = [];
                            $duplicate_invoice_no = $exist_recurring_code->code;
    
                            $duplicate_amount = [];
                            $duplicate_amount = $exist_recurring_code->price;

                            if($type_file == "DECLINED")
                            {
                                $recurring_code = $this->helper->PostRequest($this->api_client, 'api/recurring/check_exist_code2', [
                                    'bank_id'       => $this->BANK_CURRENT,
                                    'reference_no'  => $_list['reference_no'],
                                    'bill_total_amount'   => $cut_amount
                                ]);

                                if($recurring_code->success  && !in_array($_list['retrieval'], $exist_recurring_code->tranId, true))
                                {
                                    if(!in_array($_list['reference_no'],$exist_recurring_code->paid, true))
                                    {
                                        $reference_no = isset($count_invoice[$_list['reference_no']]) ? $count_invoice[$_list['reference_no']] : '';
                                        if($reference_no < 3)
                                        {
                                            $_list['remarks'] = 'PASS';
                                        } else{
                                            $_list['remarks'] = 'Retrieval over quantitytr.';
                                        }
                                        $_list['status'] = 'success';
                                    }
                                    else
                                    {
                                        $_list['remarks'] = 'Reference has already been paid.';
                                        $_list['status'] = 'success';
                                    }
                                }
                                else if(in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) {
                                    $_list['remarks'] = 'Retrieval has already in used.';
                                    $_list['status'] = 'fail';
                                }
                                else{
                                    $_list['remarks'] = 'Reference code and amount does not exist in the database.';
                                    $_list['status'] = 'unmatch';
                                }


                                // if (in_array($_list['reference_no'],$duplicate_invoice_no, true) && 
                                // in_array($cut_amount, $duplicate_amount, true)  &&  !in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) 
                                // {
                                //     if(!in_array($_list['reference_no'],$exist_recurring_code->paid, true))
                                //     {
                                //         $reference_no = isset($count_invoice[$_list['reference_no']]) ? $count_invoice[$_list['reference_no']] : '';
                                //         if($reference_no < 3)
                                //         {
                                //             $_list['remarks'] = 'PASS';
                                            
                                //         } else{
                                //             $_list['remarks'] = 'Retrieval over quantitytr.';
                                //         }
                                //         $_list['status'] = 'success';
                                //     }
                                //     else
                                //     {
                                //         $_list['remarks'] = 'Reference has already been paid.';
                                //         $_list['status'] = 'success';
                                //     }
                                // }
                                // else if(in_array($_list['reference_no'],$duplicate_invoice_no, true) &&
                                //     in_array($cutamount, $duplicate_amount, true) && !in_array($_list['retrieval'], $exist_recurring_code->tranId, true))
                                // {
                                //     if(!in_array($_list['reference_no'],$exist_recurring_code->paid, true))
                                //     {
                                //         $reference_no = isset($count_invoice[$_list['reference_no']]) ? $count_invoice[$_list['reference_no']] : '';
                                //         if($reference_no < 3)
                                //         {
                                            
                                //             $_list['remarks'] = 'PASS';
                                //         } else{
                                //             $_list['remarks'] = 'Retrieval over quantitytr.';
                                //         }
                                //         $_list['status'] = 'success';
                                //     } 
                                //     else
                                //     {
                                //         $_list['remarks'] = 'Reference has already been paid.';
                                //         $_list['status'] = 'success';
                                //     }
                                    
                                // }
                                    
                                // else if(in_array($_list['retrieval'], $exist_recurring_code->tranId, true)) {
                                //         $_list['remarks'] = ' Retrieval has already in used.';
                                //         $_list['status'] = 'fail';
                                // }
                                // else{
                                
                                //     $_list['remarks'] = 'Reference code and amount does not exist in the database.';
                                //     $_list['status'] = 'unmatch';
                                // }
                            }
                            else
                            {
                                $_list['remarks'] = 'The file prototype is not valid.';
                                $_list['status'] = 'error';
                            }
                              
                        }
                        array_push($recurring, $_list);
                    
                    }
                    //-------------------
                }
            }
        
            Session::put('import_data', $recurring);
            Session::put('upload_type', $request->upload_type);
        
            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {
            report($e);
            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show () 
    {

        if (!Session::has('import_data')) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return redirect('Recurring');
        }
       
        $testdi       = Session::get('import_data');

        $total      =   count($testdi);
        $column     =   array_column($testdi, 'reference_no');
        $total      =   count($testdi);
        $status     =   array_column($testdi, 'status');

        $approval     =   array_column($testdi, 'approval');

        
        $approval = isset($approval) ? $approval : '';


        $success    =   count(array_filter($status, function ($item) {
            return $item == 'success';
        }));

        $fail    =   count(array_filter($status, function ($item) {
            return $item == 'fail';
        }));

        $unmatch    =   count(array_filter($status, function ($item) {
            return $item == 'unmatch';
        }));

        $error    =   count(array_filter($status, function ($item) {
            return $item == 'error';
        }));



        if ($success == '' && $success == null) {
            $success = 0;
        }
        if ($unmatch == '' && $unmatch == null) {
            $unmatch = 0;
        }
        if ($fail == '' && $fail == null) {
            $fail = 0;
        }

        return view('Recurring.Upload.confirm', compact('total' , 'success' , 'fail' ,'unmatch' ,'approval' , 'error'));
    }

    public function confirmCancel() 
    {
        return view('Recurring.Upload.import');
    }

    public function confirm_obj(Request $request)
    {
        $all_bill = Session::get('import_data') != null
            ? Session::get('import_data')
            : [];
      
        return Datatables::of($all_bill)
            ->escapeColumns([])
            ->make(true);

    }

    public function submitConfirm(Request $request)
    {
       
        if (!Session::has('import_data')) {
            return redirect()->to('Recipient')->with([
                'alert-class'  => 'alert-danger',
                'message'      => 'Data dose not exist!'
            ]);
        }

        try {
                
            $import_data = Session::get('import_data');
            $upload_type = Session::get('upload_type');

            $response = $this->helper->PostRequest($this->api_client, 'api/recurring/recurring_import', [
                'data'                => $import_data,
                'upload_type'         => $upload_type,
                'bank_id' => Session::get('BANK_CURRENT')['id']
            ]);

            if ($response->success == true)
            {
                Session::forget('import_data');
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', $response->message);

                return response()->json([
                    'message' => 'success',
                    'success' => true
                ], 200);
            } 
            else 
            {
                return response()->json([
                    'success' => false,
                    'message' => $response->message
                ], 200);
            }
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function RecurringTransaction()
    {
        return view('Recurring.transaction');
    }

    public function TransactionObjectData(Request $request)
    {
        try {
            $request->request->add([
                'corp_code' => $this->CORP_CODE,
                'corporate_id' => $this->CORP_CURRENT
            ]);
            
            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }

            if ( !blank($request->transaction_time) ) {
                $t = explode('-', $request->transaction_time);
                $start_time = date('H:i:s', strtotime(str_replace("/", "-", trim($t[0]))));
                $end_time = date('H:i:s', strtotime(str_replace("/", "-", trim($t[1]))));
                $request['start_time']    = $start_time;
                $request['end_time']    = $end_time;

            }

            $response = $this->api_client->post('api/recurring/transaction/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            // report($e);

            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }

    public function download_template_approve($template_type)
    {
        try
        {
            $path = '';
            $file_name = 'RECIPIENT_TEMPLATE';
            if($template_type == 'txt') {
                $path = storage_path('template/RptApproved_69947_20200615.txt');
                $file_name .= '.txt';
            } 
            
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=$file_name");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            
            return redirect('/Exception/InternalError');
        }
    }

    public function download_template_declined($template_type)
    {
        try
        {
            $path = '';
            $file_name = 'RECIPIENT_TEMPLATE';
            if($template_type == 'txt') {
                $path = storage_path('template/RptDeclined_69947_20200615.txt');
                $file_name .= '.txt';
            } 
            
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=$file_name");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            
            return redirect('/Exception/InternalError');
        }
    }

    public function bill()
    {
        return view('Recurring.Bill.index');
    }

    public function bill_objectdata(Request $request)
    {
        try {
            if (!blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            
            // $response = $this->api_client->post('api/recipient/cardstore/objectData', [
            //     'form_params' => $request->all()
            // ]);
            $formdata = $request->all();
            $formdata['bank_id'] = $this->BANK_CURRENT;

            $response = $this->api_client->post('api/recurring/bill/objectData', [
                'form_params' => $formdata,
                // 'form_params' => $request->all(),
                // 'bank_id' => Session::get('BANK_CURRENT')['id']
            ]);

          

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function bill_detail($reference_code)
    {
        try {
            // $data_response = $this->helper->PostRequest($this->api_client, 'api/support/bill/detail', [
            //     'reference_code' => $reference_code
            // ]);
            $data_response = $this->helper->PostRequest($this->api_client, 'api/support/bill/detail', [
                'reference_code' => $reference_code
            ]);

            if ($data_response->success) {
                $data = $data_response->data;
                return view('Support.Bill.detail', compact('data'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back();
            }
        } catch (\Exception $e) {
            report($e);
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
       
    }


    public function select2_company(Request $request)
    {
        try {
            
            // $response = $this->helper->PostRequest($this->api_client, 'api/corporate/request/select2_texid', [
                $response = $this->helper->PostRequest($this->api_client, 'api/recurring/company_name', [
                'corporate_id'      => $this->CORP_CURRENT,
                'bank_id'           => $this->BANK_CURRENT,
                'search'            => $request->search,
            ]);

            return response()->json([
                'items' => $response->data ?? null
            ]);

        } catch (\Exception $e) {
            report($e);

            return response()->json(null);
        }
    }

    
    

    

    
}
