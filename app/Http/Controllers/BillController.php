<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Http\Requests\ManualRepaymentBillRequest;

class BillController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
        $this->REPORT_URL           = env('REPORT_URL');
    }

    public function index()
    {
        return view('Bill.index');
    }

    public function detail($reference)
    {
        try {

            $response = $this->helper->PostRequest($this->api_client, 'api/bill/detail', [
                'reference_code'	=> $reference,
                'corporate_id'      => $this->CORP_CURRENT
            ]);

            $data = $this->getBillDetail($reference);

            return view('Bill.detail', compact('data'));

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
            $request->request->add(['corporate_id' => $this->CORP_CURRENT]);

            if ($request->has('daterange') && !blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }

            $response = $this->api_client->post('api/bill/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if (!!$data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ResendNotifyBill(Request $request)
    {
        $this->validate($request, [
            'channel'                 => 'required|in:SMS,EMAIL,LINE'
        ]);

        if ($request->channel === 'EMAIL') {
            $this->validate($request, [
                'billReference'           => 'required|alpha_num',
                'customerNo'              => 'required',
                'value'                   => 'email',
                'branchCode'              => 'digits:5'
            ]);
        } else if ($request->channel === 'SMS') {
            $this->validate($request, [
                'billReference'           => 'required|alpha_num',
                'customerNo'              => 'required',
                'value'                   => 'required|numeric',
                'branchCode'              => 'digits:5'
            ]);
        } else if ($request->channel === 'LINE') {
            $this->validate($request, [
                'billReference'           => 'required|alpha_num'
            ]);
        }

        try {

            // GET BILL DETAIL FOR CHECK DOCUMENT TYPE
            $bill = $this->getBillDetail($request->billReference);

            $document_type = null;
            if ( !isset($bill->bill_status) && !isset($bill->payment_status) ) {
                throw new Exception('Could not get bill detail.');
            } else if ( $bill->bill_status === 'INACTIVE' ) {
                throw new Exception('Current bill has been inactve.');
            } else if ( $bill->bill_status === 'PAID' && $bill->payment_status === 'PAID' ) {
                $document_type = 'RECEIPT';
            } else {
                $document_type = 'INVOICE';
            }
            
            if ( $request->channel === 'SMS' ) {
                $response = $this->helper->PostRequest($this->api_client, env('REPORT_URL').'/api/v1/generate/pdf', [
                    'corporate_id'      => $this->CORP_CURRENT,
                    'branch_code'       => $request->branchCode,
                    'document_type'     => $document_type,
                    'customer_list'     => [
                        [
                            'reference_code'    => $request->billReference,
                            'customer_code'     => $request->customerNo,
                            'mobile_number'     => $request->value
                        ]
                    ],
                    'notify_channel'    => $request->channel,
                ]);
    
                if ( !$response->success ) {
                    Log::error("[".__FUNCTION__."] Error: {$response->message}");
                    throw new Exception($response->message ?? '');
                }

            } else if ( $request->channel === 'EMAIL' ) {
                $response = $this->helper->PostRequest($this->api_client, env('REPORT_URL').'/api/v1/generate/pdf', [
                    'corporate_id'      => $this->CORP_CURRENT,
                    'branch_code'       => $request->branchCode,
                    'document_type'     => $document_type,
                    'customer_list'     => [
                        [
                            'reference_code'    => $request->billReference,
                            'customer_code'     => $request->customerNo,
                            'email'             => $request->value
                        ]
                    ],
                    'notify_channel'    => $request->channel,
                ]);
    
                if ( !$response->success ) {
                    Log::error("[".__FUNCTION__."] Error: ".$response->message ?? '');
                    throw new Exception($response->message ?? '');
                }

            } else if ( $request->channel === 'LINE' ) {

                $response = $this->helper->PostRequest($this->api_client, $this->REPORT_URL.'/api/loan/notify/line/bill-resend', [
                    'corporate_id'      => $this->CORP_CURRENT,
                    'reference_code'    => $request->billReference,
                    'notify_channel'    => $request->channel,
                ]);
    
                if ( !$response->success ) {
                    throw new Exception($response->message ?? '');
                }

            } else {
                throw new Exception(ucwords(strtolower(($request->channel ?? ''))).' notify channel not support');
            }
            
            return response()->json([
                'success'       => true
            ]);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function BillExport(Request $request)
    {
        try {

            if ( !isset(Session::get('user_detail')->email) ) {
                throw new Exception('current user doesn\'t have email.');
            }
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));
            $email = Session::get('user_detail')->email;

            $response = $this->helper->PostRequest(
                $this->api_client,
                $this->reportURL.'/api/loan/report/recipient',
                [
                    'corporate_id'  => $this->CORP_CURRENT,
                    'start_date' 	=> $start_date,
                    'end_date'   	=> $end_date,
                    'status'     	=> $request->status,
                    'username'      => $email
                ]
            );

            if ($response->resCode === '00') {
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success'   => false, 
                    'message'   => $response->message
                ]);
            }
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'success'   => false, 
                'message'   => $e->getMessage()
            ]);
        }
    }

    public function Repayment(ManualRepaymentBillRequest $request)
    {
        if ( !blank($_FILES['file']['error'] ?? null) && $_FILES['file']['error'] !== 0 ) {
            throw new \App\Exceptions\UploadException($_FILES['file']['error']);
        }

        $image = [];
        if ( $request->file !== null ) {
            $file = $request->file('file');
            $image['filename']      = $file->getClientOriginalName();
            $image['extension']     = $file->getClientOriginalExtension();
            $image['content']       = base64_encode( file_get_contents($file) );
            $image['requester'] = [
                'user_agent'        => $request->server->getHeaders()['USER_AGENT'] ?? null,
                'ip'                => $request->ip(),
            ];
        }
                
        $response = $this->helper->PostRequest($this->api_client, '/api/bill/repayment', [
            'corp_code'         => $this->CORP_CODE,
            'corporate_id'      => $this->CORP_CURRENT,
            'reference_code'    => $request->reference_code,
            'bill_type'         => !blank($request->bill_type) ? $request->bill_type : 'INVOICE',
            'data'              => $request->except(['file', '_token']),
            'image'             => $image
        ]);

        if ( !$response->success ) {
            return response()->json([
                'success'   => false,
                'message'   => $response->message
            ]);
        }

        return response()->json([
            'success'   => true
        ]);
    }

    public function InactiveBill(Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, '/api/bill/inactive', [
            'corp_code'         => $this->CORP_CODE,
            'corporate_id'      => $this->CORP_CURRENT,
            'reference_code'    => $request->reference_code,
            'bill_type'         => 'INVOICE'
        ]);

        if ( !$response->success ) {
            return response()->json([
                'success'   => false,
                'message'   => $response->message
            ]);
        }

        return response()->json([
            'success'   => true
        ]);
    }

    private function getBillDetail(string $reference_code)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/bill/detail', [
            'reference_code'	=> $reference_code,
            'corporate_id'      => $this->CORP_CURRENT
        ]);

        if ( !isset($response->success) || $response->success !== true ) {
            throw new Exception($response->message ?? 'ไม่พบข้อมูล BILL');
        }

        return $response->data ?? null;
    }
}
