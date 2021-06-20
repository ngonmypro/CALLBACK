<?php

namespace App\Http\Controllers\Loan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;

use Log;
use Redirect;
use GuzzleHttp;
use Exception;
use Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    private $helper;
    private $CORP_CODE;

    public function __construct()
    {
        $this->api_client           = parent::APIClient();
        $this->helper				= parent::Helper();
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->reportURL			= env('REPORT_URL');
    }

    //demo for dev
    public function transaction_report()
    {
        return view('Loan.Report.transaction_report');
    }

    public function recipient_report()
    {
        return view('Loan.Report.recipient_report');
    }

    public function contract_report()
    {
        return view('Loan.Report.contract_report');
    }

    public function transactionObjectData(Request $request)
    {
        try {
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

            $request['corp_code'] = $this->CORP_CODE;
            $request['start_date'] = $start_date;
            $request['end_date'] = $end_date;
            $request['status'] = $request->status;

            $response = $this->api_client->post('api/loan/report/transaction/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return DataTables::of([]);
        }
    }

    public function transactionExport(Request $request)
    {
        try {
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));
            $json = $this->helper->PostRequest(
                $this->api_client,
                $this->reportURL.'/api/loan/report/payment',
                [
                    'corp_code'  => $this->CORP_CODE,
                    'start_date' => $start_date,
                    'end_date'   => $end_date,
                    'status'     => $request->status,
                    'username'   => Session::get('user_detail')->email
                ]
            );
            if ($json->resCode == '00') {
                return response()->json(['success' => true]);
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $json->message);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function recipientObjectData(Request $request)
    {
        try {
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

            $request['corporate_id'] = $this->CORP_CURRENT;
            $request['start_date'] = $start_date;
            $request['end_date'] = $end_date;
            $request['status'] = $request->status;

            $response = $this->api_client->post('api/loan/report/recipient/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return DataTables::of([]);
        }
    }

    public function recipientExport(Request $request)
    {
        try {

            $payload = [
                'corporate_id'          => $this->CORP_CURRENT,
                'start_date' 	        => null,
                'end_date'   	        => null,
                'status'     	        => $request->bill_status,
                'customer_code'         => $request->customer_code,
                'batch_name'            => $request->batch_name,
                'username'              => Session::get('user_detail')->email ?? null,
                'inv_no'                => $request->inv_no,
            ];
            
            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);

                if ( isset($e[0]) && isset($e[1]) ) {
                    $payload['start_date']  = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                    $end_date['end_date'] 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));
                }
            }    
            
            $json = $this->helper->PostRequest(
                $this->api_client,
                $this->reportURL.'/api/loan/report/recipient',
                $payload
            );
           
            if ( isset($json->resCode) && $json->resCode == '00' ) {
                return response()->json([
                    'success' => true
                ]);
            } else {
                Log::error('error response: '. $json->message ?? '' );
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $json->message ?? '');
                return redirect()->back()->withInput();
            }

        } catch (\Exception $e) {
            report($e);
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function contractObjectData(Request $request)
    {
        try {
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

            $request['corporate_id'] = $this->CORP_CURRENT;
            $request['start_date'] = $start_date;
            $request['end_date'] = $end_date;
            $request['status'] = $request->status;

            $response = $this->api_client->post('api/loan/report/contract/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return DataTables::of([]);
        }
    }

    public function contractExport(Request $request)
    {
        try {
            // Log::debug($request->all());
            Log::info(json_encode($request->all()));
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

            $response = $this->helper->PostRequest(
                $this->api_client,
                $this->reportURL.'/api/loan/report/contract',
                [
                    'corporate_id' => $this->CORP_CURRENT,
                    'start_date'   => $start_date,
                    'end_date'     => $end_date,
                    'status'       => $request->status,
                    'username'     => Session::get('user_detail')->username
                ]
            );
            // Log::debug(json_encode($response));

            if ($response->resCode == '00') {
                return response()->json(['success' => true]);
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $response->message);
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
