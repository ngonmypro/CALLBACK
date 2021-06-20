<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use File;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use \App\ExcelSkuBinder;

class EtaxController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->API_URL              = env('API_URL');
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
    }

    public function index()
    {
        Session::forget('etax_upload');
        Log::info('etax_index');
        try {

            
            $response = $this->helper->PostRequest($this->api_client, '/api/etax/corp_job',[
                'corporate_id'   => $this->CORP_CURRENT
            ]);

            if ($response->success == true) {
                if(!blank($response->data))
                {
                    $corp_job_setting = $response->data;
                }
                else
                {
                    $corp_job_setting = null;
                }
                
                Log::info('setting:'.json_encode($corp_job_setting));
            } else {
                return redirect('/Exception/InternalError');
            }
        } catch (\Exception $ex) {
            Log::info($ex);

            return redirect('/Exception/InternalError');
        }

        return view('ETax.index',compact('corp_job_setting'));
    }

    public function create()
    {
        $doc_type = [];
        try {
            // $response = $this->api_client->post('api/field_mapping/data/document_type');

            // $data_response = json_decode($response->getBody()->getContents());

            $data_response = $this->helper->PostRequest($this->api_client, '/api/field_mapping/data/document_type',[
                'corporate_id'   => $this->CORP_CURRENT
            ]);

            if ($data_response->success == true) {
                $doc_type = $data_response->data;
            } else {
                return redirect('/Exception/InternalError');
            }
        } catch (\Exception $ex) {
            Log::info($ex);
            return redirect('/Exception/InternalError');
        }

        return view('ETax.create', compact('doc_type'));
    }

    public function confirm_sign(Request $request)
    {
        // Log::debug('request: ', $request->all());
        try {
            $formdata = $request->all();
            $formdata['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->api_client->post('api/etax/process_file', [
                'form_params' => $formdata
            ]);

            $data_response = json_decode($response->getBody()->getContents());

            if ($data_response->success == true) {
                return response()
                        ->json([
                            'success' => true
                        ]);
            } else {
                return response()
                        ->json([
                            'success' => false,
                            'message' => $data_response->message
                        ]);
            }
        } catch (\Exception $e) {
            Log::info($e);
            return  response()
                ->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function get_corp_mapping_field(Request $request)
    {
        $current_corporate = Session::get('CORP_CURRENT')['id'];
        try {
            $response = $this->api_client->post('api/field_mapping/get/corp_mapping', [
                'form_params' => [
                    'cur_corp_id'   => $current_corporate,
                    'doc_type'      => $request->name_alias
                ]
            ]);

            $data_response = json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                $data = json_decode(json_encode($data_response->data), true);
                Log::info(json_encode($data));
                return response()
                        ->json([
                            'success'       => true,
                            'mapping_list'  => $data['mapping_field'],
                            'pdf_template'  => $data['pdf_template']
                        ]);
            } else {
                // return redirect('/Exception/InternalError');
                return response()
                        ->json([
                            'success' => false,
                            'message'    => 'get mapping list fail. please try again.'
                        ]);
            }
        } catch (\Exception $e) {
            Log::info($e);
            return  response()
                ->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function create_save(Request $request)
    {
        if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);
            Session::put('file_name_upload', $real_name);
      
            if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
                return  response()->json(['success' => false]);
            }

            $arrObj = [];
            $mapping_field_list = [];
            $_rule = [];
            $branch_code = [];
            try {
                $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/get/mapping_field',[
                        'mapping_id'        => $request->mapping_id,
                        'document_type'     => $request->document_type,
                        'corporate_id'      => $this->CORP_CURRENT
                ]);
    
                if ($response->success == true) {
                    #Field Mpa
                    $mapping_field_list = $response->data->mapping_field;

                    #Field Rule
                    $field_map = $response->data->data_mapping_field;
                    $req_branch = '';
                    foreach($field_map as $_field_map)
                    {
                        $_rule[$_field_map->field_name] = $_field_map->rule;
                        if($_field_map->field_name == 'branch_code')
                        {
                            $req_branch = $_rule[$_field_map->field_name];
                        }
                    }
                    
                    #Branch Code
                    $branch_code = $response->data->branch_code;
                } 
                else {
                    return  response()->json(['success' => false, 'message' => $response->message]);
                }

                $myValueBinder = new \App\ExcelSkuBinder;
                $data = Excel::setValueBinder($myValueBinder)->load($file)->toArray();

                $_invoice = [];
                foreach ($data as $value) {  //Read data from each column.
                    $field = [];
                    $additionnal = [];
                    foreach ($mapping_field_list as $map_field_key){
                        $field[$map_field_key->field_key] = isset($value[$map_field_key->field_data]) ? $value[$map_field_key->field_data] : "";
                        if($map_field_key->field_key === 'invoice_number'){
                            array_push($_invoice, $field[$map_field_key->field_key]);
                        }
                        
                        if($map_field_key->type === 'additional_field') {
                            foreach ($value as $key_value => $field_value) {
                                if($key_value == $map_field_key->field_data) {
                                    $additionnal[$map_field_key->field_key] = $field_value;
                                }
                            }
                            $field['additional'] = $additionnal;
                        }
                    }
                    array_push($arrObj, $field);
                }

                $response = $this->helper->PostRequest($this->api_client, 'api/etax/check/invoice', [
                        'corporate_id'           => $this->CORP_CURRENT,
                        'document_type'          => $request->document_type,
                        'invoice_number'         => $_invoice,
                        'upload_type'            => $request->upload_type
                ]);

                $duplicate_invoice_no = [];
                if ($response->success) {
                    $duplicate_invoice_no = $response->data;
                    Log::info('$duplicate_invoice_no '.json_encode($duplicate_invoice_no));
                } 
                else {
                    return response()->json(['success' => false, 'message' => $response->message]);
                }

                # VALIDATE DATA FORMAT
                $status_upload = 'true';
                $etax_to_preview = [];
                foreach($arrObj as $key => $_etax) {
                    $_etax['status'] = '';
                    $_etax['remark'] = [];

                    $validator = Validator::make($_etax, $_rule);

                    if ($validator->fails()) {
                        $_etax['status'] = 'fail';
                        $remark = $validator->messages()->toArray();
                        $_etax['remark'] = $remark;
                    }
                    else {
                        $_etax['status'] = 'success';
                    }

                    if(!in_array($_etax['branch_code'], $branch_code)) {
                        $_etax['status'] = 'fail';
                        $_etax['remark']['branch_code'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "There is no this branch number specified in the system." : "รหัสสาขาที่ระบุมา ไม่มีในระบบ";
                    }

                    if($request->upload_type == 'new') {
                        if(in_array($_etax['invoice_number'], $duplicate_invoice_no)) {
                            $_etax['status'] = 'fail';
                            $_etax['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number has already been specified." : "มี invoice number ".$_etax['invoice_number']." อยู่ในระบบแล้ว";
                        }
                    }
                    else {
                        foreach($duplicate_invoice_no as $inv_value) {
                            if($_etax['invoice_number'] == $inv_value->inv) {
                                $_etax['status'] = 'fail';
                                if($inv_value->msg == 'rd') {
                                    $_etax['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number is sended to RD." : "Invoice number ".$_etax['invoice_number']." ถูกส่งไปยังกรมสรรพากรแล้ว";
                                }
                                else if($inv_value->msg == 'dont') {
                                    $_etax['remark']['invoice_number'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? "This invoice number dose not exist on the system." : "ไม่มี invoice number ".$_etax['invoice_number']." อยู่ในระบบ";
                                }
                            }
                        }
                    }

                    //region #check buyer_type TXID NIDN CCPT OTHR

                    if(isset($_etax['buyer_type'])) {if($_etax['buyer_type'] == 'TXID') { # 18 digit
                            if(strlen($_etax['buyer_tax_id']) != 18 || !is_numeric($_etax['buyer_tax_id'])) {
                                $_etax['status'] = 'fail';
                                $_etax['remark']['buyer_tax_id'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'The buyer tax id is not correct according to the TXID format.' : 'รหัสภาษีผู้ซื้อไม่ถูกต้องตามรูปแบบ TXID';
                            }
                        }
                        else if($_etax['buyer_type'] == 'NIDN') { # 13 digit
                            if(strlen($_etax['buyer_tax_id']) != 13 || !is_numeric($_etax['buyer_tax_id'])) {
                                $_etax['status'] = 'fail';
                                $_etax['remark']['buyer_tax_id'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'The buyer tax id is not correct according to the NIDN format.' : 'รหัสภาษีผู้ซื้อไม่ถูกต้องตามรูปแบบ NIDN';
                            }
                        }
                        else if($_etax['buyer_type'] == 'CCPT') { # 9 - 18 digit
                            if(!(strlen($_etax['buyer_tax_id']) >= 9 && strlen($_etax['buyer_tax_id']) <= 18)) {
                                $_etax['status'] = 'fail';
                                $_etax['remark']['buyer_tax_id'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'The buyer tax id is not correct according to the CCPT format.' : 'รหัสภาษีผู้ซื้อไม่ถูกต้องตามรูปแบบ CCPT';
                            }
                        }
                        else if($_etax['buyer_type'] == 'OTHR') { # N/A
                            if($_etax['buyer_tax_id'] != 'N/A') {
                                $_etax['status'] = 'fail';
                                $_etax['remark']['buyer_tax_id'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'The buyer tax id is not correct according to the OTHR format.' : 'รหัสภาษีผู้ซื้อไม่ถูกต้องตามรูปแบบ OTHR';
                            }
                        }
                        else {
                            if((blank($_etax['buyer_type']) && !blank($_etax['buyer_tax_id'])) || (!blank($_etax['buyer_type']) && blank($_etax['buyer_tax_id']))) {
                                $_etax['status'] = 'fail';
                                $_etax['remark']['buyer_type'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'Buyer TAX ID and Buyer Type is both required or empty' : 'Buyer TAX ID และ Buyer Type ต้องระบุหรือไม่ระบุทั้งหมด';
                                $_etax['remark']['buyer_tax_id'][] = Session::get('locale') === 'en' || Session::get('locale') === '' ? 'Buyer TAX ID and Buyer Type is both required or empty' : 'Buyer TAX ID และ Buyer Type ต้องระบุหรือไม่ระบุทั้งหมด';
                            }
                        }
                    }
                    //endregion

                    //region Check Document Condition
                    if($request->document_type == 'debit_note' || $request->document_type == 'credit_note') { #80 Debit 81 Credit
                        $document_reference_code = ['80', '81', '388', 'T02', 'T03', 'T04'];
                        $document_reason_code = $request->document_type == 'debit_note' ? ['DBNG01', 'DBNG02', 'DBNG99', 'DBNS01', 'DBNS02', 'DBNS99'] : ['CDNG01', 'CDNG02', 'CDNG03', 'CDNG04', 'CDNG05', 'CDNG99', 'CDNS01', 'CDNS02', 'CDNS03', 'CDNS04', 'CDNS99'];

                        if(empty($_etax['document_reference_code'])) {
                            if(!empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason'])) {
                                $_etax['remark']['document_reason'][] = 'The document reason field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else {
                            if(in_array($_etax['document_reference_code'], $document_reference_code)) {
                                if(empty(['document_reference'])) {
                                    $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                    $_etax['status'] = 'fail';
                                }
                                if(empty($_etax['document_reason_code'])) {
                                    $_etax['remark']['document_reason_code'][] = 'The document reason code field is required.';
                                    $_etax['status'] = 'fail';
                                }
                                else {
                                    if(!in_array($_etax['document_reason_code'], $document_reason_code)){
                                        $_etax['remark']['document_reason_code'][] = 'The document reference code is not support this data.';
                                        $_etax['status'] = 'fail';
                                    }
                                }
                                if(empty($_etax['document_reason'])) {
                                    $_etax['remark']['document_reason'][] = 'The document reason field is required.';
                                    $_etax['status'] = 'fail';
                                }
                            }
                            else {
                                $_etax['remark']['document_reference_code'][] = 'The document reference code field support data is 80 81 388 T02 T03 T04 or empty.';
                                $_etax['status'] = 'fail';
                            }
                        }
                    }
                    else if($request->document_type == 'invoice') { #380 Invoice
                        if(empty($_etax['document_reference_code'])) {
                            if(!empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else if(in_array($_etax['document_reference_code'], ['380', 'IV', 'LC', 'LS', 'ON', 'SE', 'ALT', 'DL', 'CD', 'ZZZ'])) {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else
                        {
                            $_etax['remark']['document_reference_code'][] = 'The document reference code field support data is 380 IV LC LS ON SE ALT DL CD ZZZ or empty.';
                            $_etax['status'] = 'fail';
                        }
                    }
                    else if($request->document_type == 'tax_invoice') { #388 Tax Invoice
                        if(empty($_etax['document_reference_code'])) {
                            if(!empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else if(in_array($_etax['document_reference_code'], ['388', 'T02', 'T03', 'T04', 'T05', 'T06'])) {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                $_etax['status'] = 'fail';
                            }
                            if(empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is required.';
                                $_etax['status'] = 'fail';
                            }
                            else {
                                if(!in_array($_etax['document_reason_code'], ['TIVC01', 'TIVC02', 'TIVC99'])){
                                    $_etax['remark']['document_reason_code'][] = 'The document reference code field support data is TIVC01 TIVC02 TIVC99.';
                                    $_etax['status'] = 'fail';
                                }
                            }
                            if(empty($_etax['document_reason'])) {
                                $_etax['remark']['document_reason'][] = 'The document reason field is required.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else if(in_array($_etax['document_reference_code'], ['IV', 'LC', 'LS', 'ON', 'SE', 'ALT', 'DL', 'CD', 'ZZZ'])) {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason_code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else {
                            $_etax['remark']['document_reference_code'][] = 'The document reference code field support data is (388 T02 T03 T04 T05 T06) or (IV LC LS ON SE ALT DL CD ZZZ) and empty.';
                            $_etax['status'] = 'fail';
                        }
                    }
                    else if($request->document_type == 'receipt') { #T01 Receipt
                        if(empty($_etax['document_reference_code'])) {
                            if(!empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else if($_etax['document_reference_code'] == 'T01') {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                $_etax['status'] = 'fail';
                            }
                            if(empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason code field is required.';
                                $_etax['status'] = 'fail';
                            }
                            else {
                                if(!in_array($_etax['document_reason_code'], ['RCTC01', 'RCTC02', 'RCTC03', 'RCTC04', 'RCTC99'])){
                                    $_etax['remark']['document_reason_code'][] = 'The document reference code field support data is RCTC01 RCTC02 RCTC03 RCTC04 RCTC99.';
                                    $_etax['status'] = 'fail';
                                }
                            }
                            if(empty($_etax['document_reason'])) {
                                $_etax['remark']['document_reason'][] = 'The document reason field is required.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else if(in_array($_etax['document_reference_code'], ['IV', 'LC', 'LS', 'ON', 'SE', 'ALT', 'DL', 'CD', 'ZZZ'])) {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason_code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else {
                            $_etax['remark']['document_reference_code'][] = 'The document reference code field support data is T01 or (IV LC LS ON SE ALT DL CD ZZZ) and empty.';
                            $_etax['status'] = 'fail';
                        }
                    }
                    // else if($request->document_type == 'invoice_or_tax_invoice') { #T02
                    // }
                    // else if($request->document_type == 'receipt_or_tax_invoice') { #T03
                    // }
                    // else if($request->document_type == 'delivery_order_or_tax_invoice') { #T04
                    // }
                    else if($request->document_type == 'tax_invoice_abb') { #T05
                        if(!empty($_etax['document_reference_code'])) {
                            $_etax['remark']['document_reference_code'][] = 'The document reference code field is value must be blank.';
                            $_etax['status'] = 'fail';
                        }
                        if(empty($_etax['document_reference'])) {
                            $_etax['remark']['document_reference'][] = 'The document reference field is value must be blank.';
                            $_etax['status'] = 'fail';
                        }
                        if(!empty($_etax['document_reason_code'])) {
                            $_etax['remark']['document_reason_code'][] = 'The document reason code field is value must be blank.';
                            $_etax['status'] = 'fail';
                        }
                    }
                    else if($request->document_type == 'cancel_notice') { #T07
                        if(in_array($_etax['document_reference_code'], ['80', '81', '380', '388', 'T01', 'T02', 'T03', 'T04', 'T05', 'T06'])) {
                            if(empty($_etax['document_reference'])) {
                                $_etax['remark']['document_reference'][] = 'The document reference field is required.';
                                $_etax['status'] = 'fail';
                            }
                            if(!empty($_etax['document_reason_code'])) {
                                $_etax['remark']['document_reason_code'][] = 'The document reason_code field is value must be blank.';
                                $_etax['status'] = 'fail';
                            }
                        }
                        else {
                            $_etax['remark']['document_reference_code'][] = 'The document reference code field support data is 80 81 380 388 T01 T02 T03 T04 T05 T06.';
                            $_etax['status'] = 'fail';
                        }
                    }
                    else {
                        $_etax['remark']['document_type'][] = 'The system is not support this document type.';
                        $_etax['status'] = 'fail';
                    }
                    //endregion

                    if($_etax['status'] === 'success') {
                        $_etax['remark'] = 'PASS';
                    }
                    else
                    {
                        $status_upload = 'false';
                    }

                    $etax_to_preview[] = $_etax;
                }
                
                Session::put('etax_upload', $etax_to_preview); 
                Session::put('status_upload', $status_upload);
                Session::put('upload_template', [
                                                    'document_type' => $request->document_type,
                                                    'mapping_id'    => $request->mapping_id,
                                                    'upload_type'   => $request->upload_type,
                                                    'pdf_template'   => $request->pdf_template
                                                ]);
            
                return  response()
                    ->json([
                        'success' => true
                    ]);
            } catch (\Exception $e) {
                Log::info($e);
                return  response()
                    ->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
            }
        }
    }

    public function BatchobjectData(Request $request)
    {
        try {
            $request['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->api_client->post('api/batch/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success == true) {
                return response()->json($data_response->object);
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

    public function EtaxobjectData(Request $request)
    {
        try {
            $request['corporate_id'] = $this->CORP_CURRENT;
            
            $response = $this->api_client->post('api/etax/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success == true) {
                return response()->json($data_response->object);
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

    public function confirm()
    {
        if(!Session::has('etax_upload'))
        {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return view('ETax.index');
        }

        $bill = Session::get('etax_upload');
        $template = Session::get('upload_template');
        $template = $template['document_type'];

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

        return view('ETax.create_confirm', compact('total', 'success', 'fail', 'template'));
    }

    public function download_template($document_type,$mapping_id)
    {
        try
        {
            $response = $this->helper->PostRequest(
                $this->api_client, 
                $this->API_URL.'/api/field_mapping/get/mapping_template', 
                [
                    'token' => Session::get('token'),
                    'mapping_id' => $mapping_id
                ]
            );
            
            if ($response->success != true) {
                return  response()->json([
                    'success' => false,
                    'message' => $response->message
                ]);
            }

            $data = $response->data;
            $name_file = strtoupper($document_type).date('dmY');

            $field = [];
            if(count($data) > 0)
            {   
                foreach ($data as $key => $value) {
                    $field[] = $value->field;
                }
            }

            Excel::create($name_file, function ($excel) use ($field) {
                $excel->sheet('sheet_name', function($sheet) use ($field) {
                    $sheet->fromArray($field);
                });
            })->export('csv');
    
            return  response()->json([
                'success' => true
            ]);
        }
        catch(\Exception $ex)
        {
            // Log::info($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function objectDataUpload()
    {
        if(!Session::has('etax_upload'))
        {
            Datatables::of([]);
        }

        $all_etax = Session::get('etax_upload') != null ? Session::get('etax_upload') : [];

        return Datatables::of($all_etax)
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
        if(Session::has('etax_upload'))
        {
            $all_etax = Session::get('etax_upload');
            $template_upload = Session::get('upload_template');

            $current_corporate = Session::get('CORP_CURRENT')['id'];
            // Log::info('all '.json_encode($all_etax));

            try {
                $response = $this->api_client->post('api/etax/upload', [
                    'form_params' => [
                        'etax'              => $all_etax,
                        'template_upload'   => $template_upload,
                        'cur_corp_id'       => $current_corporate,
                        'batch_detail'      => $request->all()
                    ]
                ]);

                $data_response = json_decode($response->getBody()->getContents());

                if ($data_response->success == true) {
                    Session::forget('etax_upload');
    //                        Session::put('status_import', 'Import invocie success');

                    Session::flash('alert-class', 'alert-success');
                    Session::flash('message', $data_response->message);

                    return response()->json([
                        'message' => $data_response->message, 'success' => true
                    ]);
                } else {
                    return  response()->json([
                        'success' => false,
                        'message' => $data_response->message
                    ]);
                }
            } catch (\Exception $ex) {
                Log::info($ex);

                return  response()->json([
                    'success' => false,
                    'message' => $ex->getMessage()
                ]);
            }
        }
        else{
            return  response()->json([
                'success' => false,
                'message' => 'Data dose not exist!'
            ]);
        }
    }

    

    public function confirmSign(Request $request)
    {
        try {

            return  response()->json([
                                        'success' => true,
                                        'message' => $e->getMessage()
                                    ]);
        } catch (\Exception $e) {
            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }
    //etax template PDF 


    public function pdf_report_template_1()
    {
        $pdf = PDF::loadView('ETax.pdf_1');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_1.pdf');
    }
    public function pdf_report_template_2()
    {
        $pdf = PDF::loadView('ETax.pdf_2');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_2.pdf');
    }
    public function pdf_report_template_3()
    {
        $pdf = PDF::loadView('ETax.pdf_3');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_3.pdf');
    }
    public function pdf_report_template_4()
    {
        $pdf = PDF::loadView('ETax.pdf_4');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_4.pdf');
    }
    public function pdf_report_template_5()
    {
        $pdf = PDF::loadView('ETax.pdf_5');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_5.pdf');
    }
    public function pdf_report_template_6()
    {
        $pdf = PDF::loadView('ETax.pdf_6');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_6.pdf');
    }
    public function pdf_report_template_7()
    {
        $pdf = PDF::loadView('ETax.pdf_7');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150 , 'isFontSubsettingEnabled' => true]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF_7.pdf');
    }

    public function EtaxFileLogs(Request $request)
    {   
        $func = __FUNCTION__;
        try {
            $data = $request->except('_token');
            $data['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->helper->PostRequest(
                $this->api_client, 
                $this->API_URL.'/api/etax/filedetail', 
                $data,
                [
                    'token'  => Session::get('token')
                ]
            );

            if ($response->success != true) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");

                return response()->json([
                    'success'       => false,
                    'message'       => $msg
                ]);
            }

            return response()->json([
                'success'       => true,
                'data'          => $response->data
            ]);

        } catch(\Exception $e) {
            Log::error("[{$func}] error: {$e->getMessage()}");
            
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function EtaxTXTDetail(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $data = $request->except('_token');
            $data['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->helper->PostRequest(
                $this->api_client, 
                $this->API_URL.'/api/etax/txt_detail', 
                $data,
                [
                    'token'  => Session::get('token')
                ]
            );

            if ($response->success != true) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");

                return response()->json([
                    'success'       => false,
                    'message'       => $msg
                ]);
            }

            return response()->json([
                'success'       => true,
                'data'          => $response->data
            ]);

        } catch(\Exception $e) {
            Log::error("[{$func}] error: {$e->getMessage()}");
            
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }

    // etax download PDF
    // public function downloadPDF($invoice_number)
    public function downloadPDF(Request $request)
    {
        try 
        {
            $invoice_number = $request->invoice_number;
            $corporate_id   = Session::get('CORP_CURRENT')['id']; 
            $data_response = $this->helper->PostRequest($this->api_client, '/api/etax/download_PDF',[
                                                            'invoice_number' => $invoice_number,
                                                            'corporate_id'   => $corporate_id     
                                                        ]);   
            Log::info(json_encode($data_response)); 
            if ($data_response->success == true) 
            {
                $type = $data_response->type;
                $file = base64_decode($data_response->data);
                $response = \Response::make($file);
                $response->header('Content-Type', 'text/csv');
                $response->header('Content-disposition',"attachment; filename=$invoice_number-$type.pdf");
                return $response;
            }        
        } 
        catch (\Exception $ex) 
        {
            Log::info($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }
    public function downloadXML(Request $request)
    {
        try 
        {
            $invoice_number = $request->invoice_number;
            $corporate_id   = Session::get('CORP_CURRENT')['id']; 
            $data_response = $this->helper->PostRequest($this->api_client, '/api/etax/download_XML',[
                                                            'invoice_number' => $invoice_number,
                                                            'corporate_id'   => $corporate_id
                                                        ]);          
            if ($data_response->success == true) 
            {
                $type = $data_response->type;
                $file = base64_decode($data_response->data);
                $response = \Response::make($file);
                $response->header('Content-Type', 'text/csv');
                $response->header('Content-disposition',"attachment; filename=$invoice_number-$type.xml");
                return $response;
            }        
        } 
        catch (\Exception $ex) 
        {
            Log::info($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }
    public function objectJobs(Request $request)
    {
        try {
            $response = $this->api_client->post('api/etax/objectJobs', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
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

    public function download_error_file() 
    {
        try
        {
            $file_data = Session::get('etax_upload');
            $template = Session::get('upload_template')['document_type'];
            $original_file_name = Session::get('file_name_upload');
            $name_file = str_replace('.csv', '', $original_file_name).'-error_detail';

            if($file_data === null && $template === null) {
                return  response()->json([
                    'success' => false,
                    'message' => 'file data not found!'
                ]);
            }
            $i = 0;
            $csv_key = '';
            $csv_val = '';
            $make_csv = '';
            foreach ($file_data as $key => $value) {
                $j = 0;
                $csv_val = '';
                foreach ($value as $k => $v) {
                    if(is_array($v)) {
                        $str_remark = '';
                        foreach($v as $erroe_key => $erroe_value) {
                            $str_remark .= $erroe_key.' => '.str_replace(',', '/', json_encode($erroe_value)).' | ';
                        }
                        $val = substr_replace($str_remark , '', -3);
                    }
                    else {
                        $val = $v;
                    }

                    if($i == 0)
                    {
                        $csv_key .= $j == 0 ? $k : ','.$k;
                        $csv_val .= $j == 0 ? PHP_EOL.$val : ','.$val;
                    }
                    else
                    {
                        $csv_val .= $j == 0 ? PHP_EOL.$val : ','.$val;
                    }
                    $j++;
                }

                if($i == 0) {
                    $make_csv = $csv_key.$csv_val;
                }
                else {
                    $make_csv .= $csv_val;
                }
                $i++;
            }
            $response = \Response::make($make_csv);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition',"attachment; filename=$name_file.csv");
            return $response;
        }
        catch(\Exception $ex)
        {
            Log::info($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    
}
