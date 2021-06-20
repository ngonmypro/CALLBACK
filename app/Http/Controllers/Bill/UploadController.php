<?php

namespace App\Http\Controllers\BILL;

use App\Http\Controllers\Controller;
use \App\ExcelSkuBinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Validator;
use App\Http\Middleware\AuthToken;
use Exception;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    private $api_client;
    private $CORP_CURRENT;
    private $CORP_CODE;
    private $BANK_CURRENT;

    public function __construct()
    {   
        $this->helper               = parent::Helper();
        $this->api_client           = parent::APIClient();
        $this->PAYMENT_URL          = env('PAYMENT_URL');
        $this->CORP_CURRENT         = Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE            = Session::get('CORP_CURRENT')['corp_code'] ?? null;
        $this->BANK_CURRENT         = Session::get('BANK_CURRENT')['id']        ?? null;
    }

    public function index()
    {
        $response = $this->helper->PostRequest($this->api_client, $this->PAYMENT_URL.'/v1/api/gateway/payment_channel', [
            'corporate_id'    => $this->CORP_CURRENT,
            'bank_id'         => $this->BANK_CURRENT
        ]);

        $data = $response->data ?? null;

        // hardcord delete channel `BANK_TRANSFER`
        $this->removeChannel('BANK_TRANSFER', $data);

        return view('Bill.index',compact('data'));
    }

    private function removeChannel($channel, array &$data = null) : void
    {
        if ( blank($data) ) {
            return;
        }

        $filter = array_filter($data, function($item) use ($channel) {
            if ( is_object($item) ) {
                return ($item->channel_type ?? null) === $channel;
            } else if ( is_array($item) ) {
                return ($item['channel_type'] ?? null) === $channel;
            }
        });

        if ( count($filter) !== 0 ) {
            foreach($filter as $key => $value) {
                unset($data[$key]);
            }
        }
    }

    public function detail($reference)
    {

        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/bill/detail', [
                'reference_code'    => $reference,
                'corporate_id'      => $this->CORP_CURRENT
            ]);

            if ($response->success == true) {
                $data = $response->data;

                return view('Bill.detail', compact('data'));
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => "ไม่พบข้อมูล BILL"
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function call_verify(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, $this->PAYMENT_URL.'/v1/api/gateway/verify_transaction', [
                'corporate_id'      => $this->CORP_CURRENT,
                'corp_code'         => $this->CORP_CODE,
                'bank_id'           => $this->BANK_CURRENT,
                'payment_channel'   => $request->payment_channel,
                'reference_code'    => $request->reference_code
            ]);

            if ($response->success == true) {
                return  response()->json([
                    'success' => true
                ]);
            } else {
                return  response()->json([
                    'success' => false
                ]);
            }
        } catch (\Exception $e) {
            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function objectData(Request $request)
    {
        try {
            $request->request->add(['corporate_id' => $this->CORP_CURRENT]);

            $response = $this->helper->PostRequest($this->api_client, 'api/bill/objectData', 
                $request->all()
            );

            if ($response->success == true) {
                return response()->json($response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function import()
    {
        $doc_type = [];
        
        $current_corporate  = Session::get('CORP_CURRENT')['id'];
        try {
            $mapping = $this->helper->PostRequest($this->api_client, 'api/field_mapping/get/invoice_mapping', [
                'cur_corp_id'   => $current_corporate,
                'doc_type'      => 'b2c_invoice'
            ]);

            $branch = $this->helper->PostRequest($this->api_client, 'api/bill/get_branch', [
                'corporate_id'   => $current_corporate,
            ]);

            if ($mapping->success && $branch->success) {
                $mapping    = json_decode(json_encode($mapping->data), true);
                $branch     = json_decode(json_encode($branch->data), true);
                $payment_channel = Session::get('payment_recurring');
                return view('Bill.import', compact('mapping','branch', 'payment_channel'));
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => trans('common.system_error_1')
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function import_save(Request $request)
    {
        if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);
      
            if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
                return  response()->json(['success' => false]);
            }

            $arrObj = [];
            $mapping_field_list = [];
            $_rule = [];
            try {
                $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/get/mapping_field', [
                    'mapping_id'        => $request->mapping_id,
                    'document_type'     => $request->document_type,
                    'corporate_id'      => $this->CORP_CURRENT
                ]);
    
                if ($response->success) {
                    #Field Mpa
                    $mapping_field_list = $response->data->mapping_field;

                    #Field Rule
                    $field_map = $response->data->data_mapping_field;
                    foreach($field_map as $_field_map)
                    {
                        $_rule[$_field_map->field_name] = $_field_map->rule;
                    }
                } 
                else {
                    return  response()->json(['success' => false, 'message' => $response->message]);
                }

                $myValueBinder = new \App\ExcelSkuBinder;
                $data = Excel::setValueBinder($myValueBinder)->load($file)->toArray();

                $_invoice = [];
                $_customer_code = [];
                foreach ($data as $value) {  //Read data from each column.
                    $field = [];
                    foreach ($mapping_field_list as $map_field_key){
                        $field[$map_field_key->field_key] = isset($value[$map_field_key->field_data]) ? $value[$map_field_key->field_data] : "";
                        if($map_field_key->field_key === 'invoice_number'){
                            array_push($_invoice, $field[$map_field_key->field_key]);
                        }
                        else {
                            array_push($_customer_code, $field[$map_field_key->field_key]);
                        }
                    }
                    array_push($arrObj, $field);
                }

                $response = $this->helper->PostRequest($this->api_client, 'api/bill/duplicate', [
                    'corporate_id'           => $this->CORP_CURRENT,
                    'document_type'          => $request->document_type,
                    'invoice_number'         => $_invoice,
                    'recipient_code'         => $_customer_code,
                    'upload_type'            => $request->upload_type,
                    'payment_type'           => $request->payment_type
                ]);

                $duplicate_invoice_no = [];
                if ($response->success) {
                    $duplicate_invoice_no = $response->data->duplicate_invoice;
                    $has_recipient = $response->data->has_recipient;
                    $no_recurring  = $response->data->no_recurring;
                } 
                else {
                    return  response()->json(['success' => false, 'message' => $response->message]);
                }

                # VALIDATE DATA FORMAT
                $bill_to_preview = [];
                foreach($arrObj as $key => $_bill)
                {
                    $_bill['status'] = [];
                    $_bill['remark'] = [];


                    $validator = Validator::make($_bill, $_rule);

                    if ($validator->fails()) {
                        $_bill['status'] = 'fail';
                        $remark = $validator->messages()->toArray();
                        $_bill['remark'] = $remark;
                    }
                    else
                    {
                        $_bill['status'] = 'success';
                    }

                    if($request->upload_type == 'new') {
                        if(in_array($_bill['invoice_number'], $duplicate_invoice_no)) {
                            $_bill['status'] = 'fail';
                            $_bill['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number has already been specified." : "มี invoice number ".$_bill['invoice_number']." อยู่ในระบบแล้ว";
                        }
                    }
                    else {
                        foreach($duplicate_invoice_no as $inv_value) {
                            if($_bill['invoice_number'] == $inv_value->inv) {
                                $_bill['status'] = 'fail';
                                if($inv_value->msg == 'paid') {
                                    $_bill['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number is paid." : "เลขใบแจ้งหนี้นี้ ".$_bill['invoice_number']." ถูกชำระแล้ว";
                                }
                                else if($inv_value->msg == 'dont') {
                                    $_bill['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number dose not exist on the system." : "ไม่มีเลขใบแจ้งหนี้นี้ ".$_bill['invoice_number']." อยู่ในระบบ";
                                }
                            }
                        }
                    }
                    $customer_code = $_bill['customer_code'];

                    if($request->payment_type == 'recurring') {
                        $export_date = $_bill['export_date'] ?? null;
                        if($export_date == null) {
                            $_bill['status'] = 'fail';
                            $_bill['remark']['export_date'][] = Session::get('locale') == 'en' ? "This upload is Recurring type. Please insert export_date." : "การนำเข้าไฟล์แบบเรียกเก็บอัตโนมัติจำเป็นต้องระบุ export_date";    
                        }
                        else if (strtotime($_bill['export_date']) <= strtotime(date("Y-m-d")) && $request->upload_type == 'new') {
                            $_bill['status'] = 'fail';
                            $_bill['remark']['export_date'][] = Session::get('locale') == 'en' ? "Export date cannot be today and past date." : "export_data ไม่สามารถเป็นวันนี้และวันที่ผ่านมาได้";
                        }
                        if(preg_grep("/$customer_code/i", $no_recurring)) {
                            $_bill['status'] = 'fail';
                            $_bill['remark']['customer_code'][] = Session::get('locale') == 'en' ? "This customer dose not card store for recurring on system." : "รหัสลูกค้า ".$_bill['customer_code']." ยังไม่สนับสนุนการชำระแบบเรียกเก็บอัตโนมัติ";
                        }
                    }
                    else {
                        $_bill['export_date'] = NULL;
                    }

                    
                    if(preg_grep("/$customer_code/i", $has_recipient)) {
                        $_bill['status'] = 'fail';
                        $_bill['remark']['customer_code'][] = Session::get('locale') == 'en' ? "This customer dose not exist on system." : "ระบบยังไม่มีรหัสลูกค้า ".$_bill['customer_code']." นี้";
                    }

                    if($_bill['status'] === 'success')
                    {
                        $_bill['remark'] = 'PASS';
                    }

                    $bill_to_preview[] = $_bill;
                }

                Session::put('bill_import', $bill_to_preview);
                Session::put('upload_template', [
                    'document_type' => $request->document_type,
                    'mapping_id'    => $request->mapping_id,
                    'branch_code'   => $request->branch_code,
                    'upload_type'   => $request->upload_type,
                    'payment_type'  => $request->payment_type
                ]);
            
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

    public function confirm()
    {
        if (!Session::has('bill_import')) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return view('Bill.index');
        }

        $bill       = Session::get('bill_import');
        $template   = Session::get('upload_template');
        $template   = $template['document_type'];

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

        return view('Bill.import_confirm', compact('total', 'success', 'fail', 'template'));
    }

    public function objectDataConfirm()
    {
        if (!Session::has('bill_import')) {
            Datatables::of([]);
        }

        $all_bill = Session::get('bill_import') != null ? Session::get('bill_import') : [];



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
        $batch_detail = $request->all();
        if (Session::has('bill_import')) {
            $all_bill           = Session::get('bill_import');
            $template_upload    = Session::get('upload_template');
            $current_corporate  = Session::get('CORP_CURRENT')['id'];

            try {
                unset($request ['_token']);
                $response = $this->helper->PostRequest($this->api_client, 'api/bill/import', [
                        'bill'              => $all_bill,
                        'template_upload'   => $template_upload,
                        'cur_corp_id'       => $current_corporate,
                        'batch_detail'      => $request->all()
                ]);

                if ($response->success == true) {
                    Session::flash('alert-class', 'alert-success');
                    Session::flash('message', 'Add bill data to queue for upload to system.');
                    return response()->json([
                        'message' => $response->message, 
                        'success' => true
                    ]);
                } else {
                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('message', $response->message);
                    return  response()->json([
                        'success' => false,
                        'message' => $response->message
                    ]);
                }
            } catch (\Exception $e) {
                report($e);
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $e->getMessage());
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

    public function create() 
    {
        $current_corporate  = Session::get('CORP_CURRENT')['id'];
        try {
            $mapping = $this->helper->PostRequest($this->api_client, 'api/field_mapping/get/corp_mapping', [
                'cur_corp_id'   => $current_corporate,
                'doc_type'      => 'b2c_invoice'
            ]);

            $branch = $this->helper->PostRequest($this->api_client, 'api/bill/get_branch', [
                'corporate_id'   => $current_corporate,
            ]);

            if ($mapping->success == true && $branch->success == true) {
                $mapping    = $mapping->data;
                $branch     = $branch->data;

                return view('Bill.create', compact('mapping','branch'));
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => trans('common.system_error_1')
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function create_post (Request $request)
    {
   
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/bill/create', [
                'bill_detail'   => $request->except(['_token']),
                'corp_code'     => $this->CORP_CODE,
                'corporate_id'  => $this->CORP_CURRENT
            ]);

            if ($response->success === true) {
                return redirect()->to('Bill')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Create bill is successful.'
                ]);
            } else {

                $bill_item = $request->bill_payment_item;
                Session::flash('bill_item', json_encode($bill_item));
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function download_template($document_type,$mapping_id)
    {
        try 
        {
            $path = storage_path('template/bill_template.csv');
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=BILL_TEMPLATE.xlsx");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function download_invoice(Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/bill/download_invoice', [
            'reference_code'	=> $request['data'] ,
            'corporate_id'      => $this->CORP_CURRENT
        ]);

        if($response->success && $response->data != null){
            return  response()->json([
                'success'   =>  true,
                'data'    =>  $response->data
            ]);
        }else{
            return  response()->json([
                'success'   =>  false,
                'message'    =>  $response->message
            ]);
        }
    }

    public function download_receipt(Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/bill/download_receipt', [
            'reference_code'	=> $request['data'] ,
            'corporate_id'      => $this->CORP_CURRENT
        ]);

        if($response->success && $response->data != null){
            return  response()->json([
                'success'   =>  true,
                'data'    =>  $response->data
            ]);
        }else{
            return  response()->json([
                'success'   =>  false,
                'message'    =>  $response->message
            ]);
        }
    }

    public function download_full_template($document_type,$mapping_id)
    {
        try 
        {
            $path = storage_path('template/bill_full_template.csv');
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=BILL_FULL_TEMPLATE.csv");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function download_bill_template($template_type)
    {
        try 
        {
            $path = '';
            $file_name = 'Invoice_Template';
            if($template_type == 'xlsx') {
                $path = storage_path('template/invoice_master_file.xlsm');
                $file_name .= '.xlsm';
            } else if($template_type == 'short') {
                $path = storage_path('template/bill_template.csv');
                $file_name .= '.csv';
            } else if($template_type == 'full') {
                $path = storage_path('template/bill_full_template.csv');
                $file_name .= '_Full.csv';
            }
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=$file_name");
            return $response;
        }
        catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function BillReportExport(Request $request)
    {
        try {
            $e = explode('-', $request->daterange);
            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
            $end_date 	= date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));
            $username = Session::get('user_detail')->username ?? null;

            $json = $this->helper->PostRequest(
                $this->api_client,
                $this->reportURL.'/api/loan/report/recipient',
                [
                    'corporate_id'  => $this->CORP_CURRENT,
                    'start_date' 	=> $start_date,
                    'end_date'   	=> $end_date,
                    'status'     	=> $request->status,
                    'username'      => $username
                ]
            );

            if ($json->resCode == '00') {
                return response()->json(['success' => true]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $json->message
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
}
