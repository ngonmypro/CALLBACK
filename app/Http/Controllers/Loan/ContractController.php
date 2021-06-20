<?php

namespace App\Http\Controllers\Loan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditContractRequest;
use \PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Redirect;
use GuzzleHttp;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use QrCode;
use Validator;
use finfo;
use UnexpectedValueException;
use App\Http\Requests\LoanRepaymentRequest;

class ContractController extends Controller
{
    private $helper;
    private $reportURL;
    private $paymentURL;

    private $CORP_CURRENT;
    private $CORP_CODE;

    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper				= parent::Helper();

        $this->paymentURL           = env('PAYMENT_URL');
        $this->reportURL           	= env('REPORT_URL');

        $this->CORP_CURRENT			= Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE			= Session::get('CORP_CURRENT')['corp_code'] ?? null;
        $this->BANK_CURRENT			= Session::get('BANK_CURRENT')['id']        ?? null;
    }

    public function index()
    {
        return view('Loan.Contract.index');
    }

    public function contractObjectData(Request $request)
    {
        try {
            $request->request->add([
                'corporate_id'  => $this->CORP_CURRENT
            ]);

            $response = $this->api_client->post('api/loan/contract/objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = json_decode($response->getBody()->getContents());

            return response()->json($data_response->object ?? null);

        } catch (Exception $e) {
            report($e);
            return DataTables::of([]);
        }
    }

    public function DatatableCountStatus(Request $request)
    {
        try {

            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/get/status_count', [
                'corporate_id'      => $this->CORP_CURRENT
            ]);

            if ($response->success) {
                return response()->json([
                    'success'       => true,
                    'data'          => $response->count
                ]);
            } else {
                return response()->json([
                    'success'       => false,
                    'message'       => $response->message
                ]);
            }
        } catch (Exception $e) {
            report($e);
            
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function createContract()
    {
        return view('Loan.Contract.Create.index');
    }

    public function createContractSave(Request $request)
    {
        try {
            $res = $this->helper->PostRequest($this->api_client, 'api/loan/contract/create', $request->all());

            if ( $res->success ) {

                return redirect()->action('Loan\ContractController@index')->withInput()->with([
                    'alert-class'   => 'alert-success',
                    'message'       => trans('loan_contract.create_success')
                ]);

            } else {

                return redirect()->back()->withInput()->with([
                    'alert-class'   => 'alert-danger',
                    'message'       => $res->message ?? trans('errors.99999')
                ]);

            }
        } catch (Exception $e) {
            report($e);
        
            return redirect()->back()->withInput()->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function ContractInfo($contract_code)
    {
        try {

            if (blank($contract_code) || strtolower($contract_code) === 'null') {
                Log::warning("[".__FUNCTION__."] contract code equal to null");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'ไม่สามารถนำข้อมูลสัญญานี้มาแสดงได้');
                return redirect()->back();
            }

            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/info', [
                'contract_code'		=>	$contract_code,
                'corporate_id'		=>  $this->CORP_CURRENT,
                'corp_code'			=>  $this->CORP_CODE,
            ]);

            $contract = $response->data;

            return view('Loan.Contract.info', compact('contract_code', 'contract'));

        } catch (\Exception $e) {

            report($e);

            return redirect()
                ->back()
                ->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => 'ไม่สามารถนำข้อมูลสัญญานี้มาแสดงได้ กรุณาติดต่อผู้ดูแลระบบ',
                ]);

        }
    }

    public function create_pending_item(Request $request)
    {
        $this->validate($request, [
            'contract_code'      => 'required|alpha_num',
            'item_type'          => 'required',
            'description'        => 'nullable|max:100',
            'item_price'         => 'required|numeric|min:1',
        ]);

        try  {
            $response = $this->helper->PostRequest($this->api_client, 'api/loan/create/pending/item', $request->except('_token'));

            if ( $response->success ) {
                return response()->json([
                    'success' => true
                ]);
            } else {
                throw new Exception( $response->message ?? trans('common.system_error_1') );
            }

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'message' => $e->getMessage(), 
                'success' => false
            ], 400);
        }
    }

    public function GetDocument($code)
    {
        try {
            $json = $this->helper->GetRequest($this->api_client, 'api/loan/contract/document/'.$code);

            if (isset($json->url)) {
                return redirect()->to($json->url);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            report($e);
            return redirect()->back();
        }
    }

    public function get_product_list(Request $request)
    {
        try {

            $data = $this->helper->PostRequest($this->api_client, 'api/loan/contract/get_product_list', $request->all());

            $product = $data->data;

            return response()->json($product);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success'		=> false,
                'message'		=> $e->getMessage()
            ]);
        }
    }

    public function get_recipient_list(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/get_recipient_list', [
                'corp_id' => $this->CORP_CURRENT
            ]);
            $data = $response->data;

            return response()->json($data);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success'		=> false,
                'message'		=> $e->getMessage()
            ]);
        }
    }

    public function UpdateContract(Request $request, $contract_code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/info', [
                'contract_code'		=>	$contract_code,
                'corporate_id'		=>  $this->CORP_CURRENT,
                'corp_code'			=>  $this->CORP_CODE,
            ]);
            
            if ($response->success !== true) {
                throw new Exception($response->message ?? 'something goes wrong.');
            }

            $contract = $response->data;
            return view('Loan.Contract.edit', compact('contract_code', 'contract'));

        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $e->getMessage(),
                ])
                ->withInput();
        }
    }

    public function UpdateContractSave(EditContractRequest $request, $contract_code)
    {
        try {

            $request->merge([
                'contract_code' => $contract_code
            ]);

            $this->helper->PostRequest($this->api_client, 'api/loan/contract/update', $request->except('_token'));

            return redirect()->action('Loan\ContractController@ContractInfo', [
                    'contract_code' => $contract_code
                ])
                ->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Application is updated successfully.',
                ]);
            
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $e->getMessage(),
                ])
                ->withInput();
        }
    }

    public function download($id)
    {
        $pdf = PDF::loadView('Loan.Contract.bill', array());
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->setPaper(array(0, 0, 450,650.89), 'portrait');

        return $pdf->stream('Bill.pdf');
    }

    public function bill_download($contract_code, $ref)
    {
        try {
            $url = $this->reportURL.'/api/loan/contract/bill/generate';

            $result = $this->helper->PostRequest($this->api_client, $url, [
                'bill_ref'		    => $ref,
                'corporate_id'	    => $this->CORP_CURRENT,
                'corp_code'		    => $this->CORP_CODE,
            ]);
            Log::debug("[".__FUNCTION__."] response: ".json_encode($result));

            if ($result->success !== true) {
                Log::error("[".__FUNCTION__."] Error: requesting to get bill report, but response failed url: {$url}, message: {$result->message}");
                return abort(404);
            } else if (isset($result->url)) {

                $decoded = file_get_contents($result->url);
                $response = \Response::make($decoded);
                $response->header('Content-Type', 'application/pdf')->header('Content-Disposition', 'inline');
                return $response;

            } else if (isset($result->data)) {
                $decoded = base64_decode($result->data);
                $response = \Response::make($decoded);
                $response->header('Content-Type', 'application/pdf')->header('Content-Disposition', 'inline');
                return $response;
            } else {
                echo 'Bill is in generating process, Please try again later.';
            }

        } catch (Exception $e) {
            report($e);
            return abort(404);
        }
    }

    public function loan_approve($contract_code)
    {
        try {
            $corp_id = isset($this->CORP_CURRENT) ? $this->CORP_CURRENT : '';
            $response = $this->helper->PostRequest($this->api_client, "api/loan/contract/{$contract_code}/approve", [
                'corporate_id'	=> $corp_id
            ]);

            if ($response->success !== true) {
                Log::error("[".__FUNCTION__."] Error: {$response->message}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', trans('loan_contract.error.status_failed', ['status' => 'approved']));

                return response()->json([
                    'success'		=> true,
                    'message'		=> ''
                ]);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', trans('loan_contract.error.status_success', ['status' => 'approved']));

                return response()->json([
                    'success'		=> true,
                    'message'		=> ''
                ]);
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', trans('loan_contract.error.status_failed', ['status' => 'approved']));

            report($e);
            return response()->json([
                'success'		=> false,
                'message'		=> $e->getMessage()
            ]);
        }
    }

    public function loan_reject($contract_code)
    {
        try {
            $corp_id = isset($this->CORP_CURRENT) ? $this->CORP_CURRENT : '';
            $response = $this->helper->PostRequest($this->api_client, "api/loan/contract/{$contract_code}/reject", [
                'corporate_id'	=> $corp_id
            ]);

            if ($response->success !== true) {
                Log::error("[".__FUNCTION__."] Error: {$response->message}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', trans('loan_contract.error.status_failed', ['status' => 'rejected']));

                return response()->json([
                    'success'		=> true,
                    'message'		=> ''
                ]);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', trans('loan_contract.error.status_success', ['status' => 'rejected']));

                return response()->json([
                    'success'		=> true,
                    'message'		=> ''
                ]);
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', trans('loan_contract.error.status_failed', ['status' => 'rejected']));

            report($e);
            return response()->json([
                'success'		=> false,
                'message'		=> $e->getMessage()
            ]);
        }
    }

    public function UploadDocument(Request $request, $contract_code)
    {
        $this->validate($request, [
            'document_file'      => 'required_without:document_url|mimes:jpg,jpeg,bmp,png,pdf,doc,docx',
            'document_url'       => 'required_without:document_file|url',
        ]);

        $file = $request->file('document_file');
        $url = $request->input('document_url');

        try {

            if ($file) {
                $ext = $file->getClientOriginalExtension();
                $content = file_get_contents($file);
                $document_name = $file->getClientOriginalName();
    
                $response = $this->helper->PostRequest($this->api_client, "api/loan/contract/UploadDocument/{$contract_code}", [
                    'corporate_id'	    => $this->CORP_CURRENT,
                    'base64'            => base64_encode($content),
                    'extension'         => $ext,
                    'document_name'     => $document_name
                ]);
    
                if (isset($response->message) && !$response->success) {
                    $msg = blank($response->message) ? 'เกิดข้อผิดพลาดบางอย่าง กรุณาติดต่อผู้ดูแลระบบ' : $response->message;
                    Log::error("[".__FUNCTION__."] Error: response error from web service, {$msg}");
                    throw new Exception($msg);
                }
            } else if (!blank($url)) {
                $content = @file_get_contents($url);
                if (!$content) {
                    throw new UnexpectedValueException('Could not open the file from URL, that you have provided.');
                }
    
                $file_info = new finfo(FILEINFO_MIME_TYPE);
                $mime_type = $file_info->buffer($content);
                if (!in_array($mime_type, ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'])) {
                    Log::error("[".__FUNCTION__."] Error: file type not support, mime_type: {$mime_type} from {$url}");
                    throw new Exception('Unable to upload a file, this file type is not supported');
                }
    
                // Get File Extension
                $ext_split = array_pad(explode('/', $mime_type), 2, '');
                $extension = end($ext_split);
    
                // Get Filename
                $name_split = explode('/', $url);
                $document_name = end($name_split);
    
                $response = $this->helper->PostRequest($this->api_client, "api/loan/contract/UploadDocument/{$contract_code}", [
                    'corporate_id'	    => $this->CORP_CURRENT,
                    'base64'            => base64_encode($content),
                    'extension'         => $extension,
                    'document_name'     => $document_name
                ]);
    
                if (isset($response->message) && $response->success !== true) {
                    $msg = blank($response->message) ? 'เกิดข้อผิดพลาดบางอย่าง กรุณาติดต่อผู้ดูแลระบบ' : $response->message;
                    Log::error("[".__FUNCTION__."] Error: response error from web service, {$msg}");
                    throw new Exception($msg);
                }
            } else {
                $msg = blank($response->message) ? 'เกิดข้อผิดพลาดบางอย่าง กรุณาติดต่อผู้ดูแลระบบ' : $response->message;
                Log::error("[".__FUNCTION__."] Error: input invalid, {$msg}");
                throw new Exception($msg);
            }
    
            return response()->json([
                'success'   => true
            ], 200);

        } catch (Exception $e) {
            report($e);
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ], 400);
        }
    }

    public function Repayment(LoanRepaymentRequest $request)
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
            'bill_type'         => 'LOAN',
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

    public function loadBills(Request $request)
    {
        $this->validate($request, [
            'contract_code'     => 'required'
        ]);

        try {

            $request->merge([
                'corporate_id' => $this->CORP_CURRENT
            ]);

            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/bills', $request->all());

            return response()->json([
                'success'   => true,
                'bills'     => $response->bills ?? []
            ]);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                'success'   => false,
                'message'   => 'something went wrong.'
            ]);
        }
    }

    public function loadTransactions(Request $request)
    {
        $this->validate($request, [
            'contract_code'     => 'required'
        ]);

        try {

            $request->merge([
                'corporate_id' => $this->CORP_CURRENT,
                'corp_code'    => $this->CORP_CODE,
            ]);

            $response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/transactions', $request->all());

            return response()->json([
                'success'           => true,
                'transactions'      => $response->transactions ?? []
            ]);

        } catch (Exception $e) {
            report($e);

            return response()->json([
                'success'   => false,
                'message'   => 'something went wrong.'
            ]);
        }
    }
}
