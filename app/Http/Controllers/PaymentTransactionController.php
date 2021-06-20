<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Exception;
use File;
use Validator;

class PaymentTransactionController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : 5;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
        $this->reportURL			= env('REPORT_URL');

    }

    public function index()
    {
        Session::forget('preview_data');

        return view('PaymentTransaction.index');
    }

    public function detail($request_id)
    {
        try {
            $response = $this->api_client->post('api/payment_transaction/detail', [
                'json' => [
                    'request_id'    => $request_id,
                    'corp_code'     => $this->CORP_CODE
                ]
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                $data = $data_response->data;

                return view('payment_transaction.detail', compact('data'));
            } else {

                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => "ไม่พบข้อมูล BILL"
                ]);
            }
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function objectData(Request $request)
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


            $response = $this->api_client->post('api/payment_transaction/objectData', [
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

    public function create()
    {
        try {
            return view('PaymentTransaction.create');
        } catch (\Exception $e) {

            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function create_save(Request $request)
    {
        if ($request->file !== null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);
      
            if ( !in_array($type_file, ['csv', 'xls', 'xlsx']) ) {
                return  response()->json(['success' => false]);
            }

            try {

                if( blank($request->bank_payment) ) {
                    return  response()->json(['success' => false, 'message' => 'Please select payment channel']);
                }

                if ($request->bank_payment == 'DUITNOW') {
                    $row        = 1;
                    $header     = [];
                    $row_data   = [];

                    if (($handle = fopen($file, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                            array_walk_recursive($data, function (&$input) {
                                $input = htmlentities($input);
                            });
                            
                            $row++;
                            // HEADER
                            if($row == 8) { 
                                foreach ($data as $k => $v) {
                                    $h = strtolower(preg_replace('/\s+/', '_', $v));
                                    array_push($header, $h);
                                }
                            }
                            // ROWS
                            if($row > 8) {
                                foreach ($data as $k => $v) {
                                    $row_data[$row][$header[$k]] = $v;
                                    if($header[$k] == 'transaction_code_description') {
                                        $row_data[$row]['status'] = $v != '' ? 'success' : 'fail';
                                    }
                                }
                            }
                        }
                        fclose($handle);
                    }

                    $row_data = array_values($row_data);

                    Session::put('preview_data', $row_data);
                    Session::put('payment_type', $request->bank_payment);

                    return  response()->json([
                                'success' => true
                            ]);
                } else if ($request->bank_payment === 'CASH') {
                    //
                    $row        = 0;
                    $header     = [];
                    $row_data   = [];
                    $transaction_in_file   = [];
                    if (($handle = fopen($file, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                            array_walk_recursive($data, function (&$input) {
                                $input = htmlentities($input);
                            });

                            // HEADER
                            if ($row === 0) { 
                                foreach ($data as $k => $v) {
                                    $h = strtolower(preg_replace('/\s+/', '_', $v));
                                    array_push($header, $h);
                                }
                            } else {
                                foreach ($data as $k => $v) {
                                    $row_data[$row][$header[$k]] = $v;
                                }

                                $headColumn = ['invoice_number', 'customer_code', 'payment_date', 'payment_time', 'from_name', 'transaction_id' , 'from_bank', 'ref_1', 'ref_2', 'ref_3', 'payment_channel', 'account_no', 'remarks'];
                                foreach($headColumn as $key) {
                                    if ( !isset($row_data[$row][$key]) ) {
                                        $row_data[$row][$key] = null;
                                    }
                                }

                                // VALIDATE RECORD
                                $validator = Validator::make($row_data[$row], [
                                    'invoice_number'        => 'required',
                                    'customer_code'         => 'required',
                                    'payment_date'          => 'required|date_format:Y-m-d',
                                    'payment_time'          => 'nullable|date_format:H:i:s',
                                    'from_name'             => 'max:100',
                                    'transaction_id'        => 'max:100',
                                    'from_bank'             => 'max:100',
                                    'ref_1'                 => 'required',
                                    'ref_2'                 => 'nullable|alpha_num',
                                    'ref_3'                 => 'nullable|alpha_num',
                                    'payment_channel'       => 'required',
                                    'account_no'            => 'nullable',
                                    'remarks'               => 'nullable',
                                ]);
            
                                $row_data[$row]['status_reason'] = [];
                                $row_data[$row]['status'] = 'success';

                                if ( $validator->fails() ) {

                                    Log::error('validate error: ', $validator->messages()->toArray());
                                    $row_data[$row]['status_reason'] = $validator->messages()->toArray();
                                    $row_data[$row]['status'] = 'fail';
                                    
                                    $row++;

                                    continue;

                                } else {
                                    $response = $this->helper->PostRequest($this->api_client, 'api/payment_transaction/get/detail', [
                                        'corp_code'         => $this->CORP_CODE,
                                        'corporate_id'      => $this->CORP_CURRENT,
                                        'invoice_number'    => $row_data[$row]['invoice_number'] ?? '',
                                        'transaction_id'    => $row_data[$row]['transaction_id']
                                    ]);

                                    if ( isset($response->data->bill_payment_status) && $response->data->bill_payment_status === 'PAID' ) {

                                        if ( !isset($row_data[$row]['status_reason']['invoice_number']) ) {
                                            $row_data[$row]['status_reason']['invoice_number'] = [];
                                        }
                                        array_push($row_data[$row]['status_reason']['invoice_number'], 'invoice number is already paid.');
                                        $row_data[$row]['status'] = 'fail';

                                    } else if ( isset($response->data->bill->recipient_code) && $response->data->bill->recipient_code !== $row_data[$row]['customer_code'] ) {

                                        if ( !isset($row_data[$row]['status_reason']['customer_code']) ) {
                                            $row_data[$row]['status_reason']['customer_code'] = [];
                                        }
                                        array_push($row_data[$row]['status_reason']['customer_code'], 'wrong customer code with current invoice number.');
                                        $row_data[$row]['status'] = 'fail';

                                    } else if ( blank($response->data->bill ?? null) ) {

                                        if ( !isset($row_data[$row]['status_reason']['warning']) ) {
                                            $row_data[$row]['status_reason']['warning'] = [];
                                        }
                                        array_push($row_data[$row]['status_reason']['warning'], 'bill payment not found, invoice number might be wrong.');
                                        $row_data[$row]['status'] = 'fail';

                                    }
                                    
                                    if ( !blank($row_data[$row]['transaction_id']) ) {
                                        if(!blank($response->data->has_transaction)) {
                                            $row_data[$row]['status_reason']['transaction_id'] = ['The transaction_id is repeated in the system.'];
                                            $row_data[$row]['status'] = 'fail';
                                        }

                                        if(in_array($row_data[$row]['transaction_id'], $transaction_in_file)) {
                                            $row_data[$row]['status_reason']['transaction_id'] = ['The transaction_id is repeated in cvs file.'];
                                            $row_data[$row]['status'] = 'fail';
                                        }
                                        array_push($transaction_in_file, $row_data[$row]['transaction_id']);
                                    }
                                }     

                                if ( $row_data[$row]['status'] === 'success') {
                                    $row_data[$row]['status_reason'] = '';
                                }
                            }
                            
                            $row++;
                        }
                        fclose($handle);
                    }

                    $row_data = array_values($row_data);

                    Session::put('preview_data', $row_data);
                    Session::put('payment_type', $request->bank_payment);

                    return  response()->json([
                        'success'       => true,
                        'redirectTo'    => url('PaymentTransaction/Import/Confirm/Repayment-Cash')
                    ]);

                } else {

                    return  response()->json(['success' => false, 'message' => 'Invalid bank payment']);

                }

            } catch (\Exception $e) {
                report($e);

                return  response()
                    ->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
            }
        }
    }

    public function confirm()
    {
        if (!Session::has('preview_data')) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return view('PaymentTransaction.index');
        }

        $bill       = Session::get('preview_data');

        $column     =   array_column($bill, 'status');
        $total      =   count($bill);
        $success    =   count(array_filter($column, function ($item) {
            return $item == 'success';
        }));
        $fail    =   count(array_filter($column, function ($item) {
            return $item == 'fail';
        }));

        if ($success == '' && $success == null) {
            $success = 0;
        }
        if ($fail == '' && $fail == null) {
            $fail = 0;
        }

        return view('PaymentTransaction.create_confirm', compact('total', 'success', 'fail'));
    }

    public function ConfirmPageRepaymentCash()
    {
        if ( !Session::has('preview_data') ) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return view('PaymentTransaction.index');
        }

        $bill       = Session::get('preview_data');
        $column     = array_column($bill, 'status');
        $total      = count($bill);
        $success    = count(array_filter($column, function ($item) {
            return $item == 'success';
        }));
        $fail       = count(array_filter($column, function ($item) {
            return $item == 'fail';
        }));

        if ( blank($success) ) {
            $success = 0;
        }
        if ( blank($fail) ) {
            $fail = 0;
        }
        return view('PaymentTransaction.repayment_cash.create_confirm', compact('total', 'success', 'fail'));
    }

    public function objectDataConfirm()
    {
        if ( !Session::has('preview_data') ) {
            return Datatables::of([]);
        }
        $all_bill = Session::get('preview_data') != null ? Session::get('preview_data') : [];

        return Datatables::of($all_bill)
            ->addColumn('status_label', function ($data) {
                if ($data['status'] == 'fail') {
                    return '<span class="role badge-danger">Fail</span>';
                } else {
                    return '<span class="role badge-success">Sucess</span>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function confirm_upload(Request $request)
    {
        if (Session::has('preview_data')) {
            $payment_data   = Session::get('preview_data');
            $payment_type   = Session::get('payment_type');

            try {
                $response = $this->helper->PostRequest($this->api_client, 'api/payment_transaction/import', [
                    'payment_data'  => $payment_data,
                    'payment_type'  => $payment_type,
                    'corp_code'     => $this->CORP_CODE,
                    'corporate_id'  => $this->CORP_CURRENT,
                ]);

                if ($response->success) {
                    Session::forget('preview_data');
                    Session::flash('alert-class', 'alert-success');
                    Session::flash('message', $response->message);

                    return response()->json([
                        'message' => $response->message, 'success' => true
                    ]);
                } else {
                    return  response()->json([
                        'success' => false,
                        'message' => $response->message
                    ]);
                }
            } catch (Exception $e) {
                report($e);

                return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            return  response()->json([
                'success' => false,
                'message' => 'Data dose not exist!'
            ]);
        }
    }

    public function download_template($template)
    {
        $file_name = $template === "DUITNOW" 
            ? '01Sep19_to_12Sep19.csv' 
            : 'eipp-repayment-cash.csv';
     
        try
        {
            $path = storage_path('template/'.$file_name);
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=$file_name");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            return redirect()->back()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function transactionExport(Request $request)
    {
        try {
            $start_date = $end_date = null;

            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($e[0]))) );
                $end_date 	= date('Y-m-d', strtotime(str_replace('/', '-', trim($e[1]))) );
            }

            $json = $this->helper->PostRequest(
                $this->api_client,
                Str::finish($this->reportURL, '/').'api/report/payment/export',
                [
                    'corp_code'  => $this->CORP_CODE,
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'status'     => $request->status,
                    'username'   => Session::get('user_detail')->email,
                    'inv_no'     => $request->inv_no,
                    'txn_id'     => $request->txn_id
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
}
