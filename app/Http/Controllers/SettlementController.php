<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use File;
use Exception;
use App\Http\Requests\ManualRepaymentBillRequest;


class SettlementController extends Controller
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
        return view('Settlement.Product.Index');
    }

    public function upload()
    {
        $response = $this->helper->PostRequest($this->api_client,'api/settlement/product/import',[
            'bank_id' => $this->BANK_CURRENT
        ]);

        $bank_payment_channel = $response->data;
        return view('Settlement.Product.Import' , compact('bank_payment_channel'));
    }

    public function import_settlement(Request $request)
    {
        if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);

            if ($type_file != 'csv') {
                return response()->json([
                    'success'   => false,
                    'message'   => 'ไฟล์ที่อัพโหลดไม่รองรับ'
                ], 200);
            }
            $settlement = [];

            try 
            {

                $file_base     = base64_encode( file_get_contents($file) );
                $csv_code = [];
                $header = array_slice(file($file), 0, 1);
                $header = explode(',', trim(preg_replace('/\xEF\xBB\xBF/', '', str_replace('"', '', $header[0]))));

                $exist_customer_code = $this->helper->PostRequest($this->api_client, 'api/settlement/product/check_exist_code', [
                    'bank_id' => $this->BANK_CURRENT,
                    'chennel_name'  => $request->chennel_name
                ]);

                $channel_name = json_encode($exist_customer_code->data->channel_name);
                $field_name_date = json_encode($exist_customer_code->data->field_name_date);
                $field_name_time = json_encode($exist_customer_code->data->field_name_time);
              
                if (strpos(json_encode($header), $field_name_date) !== false  &&  strpos(json_encode($header), $field_name_time) !== false) {

                    $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/submit_confirm', [
                        'file'  =>  $file_base,
                        'channel_name' => $channel_name,
                        'bank_id' => $this->BANK_CURRENT,
                    ]);
                   
                    if($response->success == true){
                        return response()->json([
                            'success'   =>  true,
                            'message'    =>  $response->message
                            ], 200);
                    }else{
                        return response()->json([
                            'success'   =>  false,
                            'message'    =>  $response->message
                            ], 200);
                    }
                   
                }
                else{
                    return response()->json([
                        'success' => false,
                    ]);
                }

            } catch (\Exception $e) {
                report($e);


                return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function confirm_obj(Request $request)
    {
        $all_bill = Session::get('import_data') != null
            ? Session::get('import_data')
            : [];
        return Datatables::of($all_bill)
            ->addColumn('status_label', function ($data) {
                if ($data['status'] == 'fail') {
                    return '<span class="role badge-danger">Fail</span>';
                } else {
                    return '<span class="role badge-success">Pass</span>';
                }
            })
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
            $all_recipient = Session::get('import_data');
               
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/submit_confirm', [
                'data'         => $all_recipient,
                'bank_id' => $this->BANK_CURRENT,
                'update_type' =>  Session::get('update_type')
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

    public function object_data_channel(Request $request) 
    {
        try {
            $request->request->add(['bank_id' => $this->BANK_CURRENT]);

            if (!blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            
            $response = $this->api_client->post('api/settlement/product/data_channel/object_data', [
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

    public function add_product($channel_name) 
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/add_product/object_data', [
                'bank_id'	    =>	$this->BANK_CURRENT,
                'channel_name'  =>  $channel_name
            ]);

            if ($response->success) {
                $settlement = $response->data;
                return view('Settlement.Product.Corprate', compact('channel_name' , 'settlement'));
            }
        } catch (\Exception $e) {
            report($e);
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->message);
            return redirect()->back();
        }
    }

    public function edit($corp_code , $channel_name)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/corp/porofile_edit', [
                'bank_id'	    =>	$this->BANK_CURRENT,
                'corp_code'	    =>	$corp_code,
                'channel_name'	    =>	$channel_name
            ]);

            if ($response->success) {
                $data_obj = $response->data;
            }
            return view('Settlement.Product.Edit', compact('data_obj'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->back();
        }
    }

    public function update_corp(Request $request)
    {
        try 
        {
            $response = $this->api_client->post('api/settlement/product/corp/update', [
                'form_params' => $request->all(),
                'bank_id'	    =>	$this->BANK_CURRENT,
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());
            
            if ($data_response->success) {

                
                return redirect()->action('SettlementController@add_product', ['channel_name' => $data_response->channel])->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Update Settlement is Successful.'
                    ]);
                
            }
            else{
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => 'ระบุข้อมูลไม่ถูกต้อง'
                    ]);
            }

        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function create_product_corporate($channel_name)
    {
        try 
        {
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/corp/create_product_corporate', [ 
                'bank_id'	    =>	$this->BANK_CURRENT,
                'channel_name'  => $channel_name
            ]);

            $channel  = null;

            if ($response->success) {
                $corporate = $response->data; 
                $channel_type = $response->bank->channel_type;
                $channel =  ucfirst(strtolower($channel_name));
                $channel = str_replace('_', ' ' ,$channel);
            }
            return view('Settlement.Product.Create2',  compact('corporate' , 'channel_name' ,'channel' ,'channel_type'));
   
        } catch (\Exception $e) {
            report($e);
            return redirect('/Exception/InternalError');
        }
    }

    public function select2_corpid(Request $request)
    {
        try 
        {
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/corp/select2_corpid', [ 
                'corporate_id'      => $this->CORP_CURRENT,
                'bank_id'           => $this->BANK_CURRENT,
                'channel_name'      => $request->channel_name,
                'search'            => $request->search,
            ]);
        
            return response()->json([
                'items' => $response->data ?? null,
                'mid' => $response->mid ?? null
            ]);
   
        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function select2_config(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/corp/select2_config', [ 
                'corporate_id'      => $this->CORP_CURRENT,
                'bank_id'           => $this->BANK_CURRENT,
                'corp_code'         => $request->corp_code,
                'channel'           => $request->channel_name
            ]);

            $getkey = null;
            if (strpos($request->channel_name, 'redirect_credit') !== false) {
                $getkey = 'mid';
            }
            else if (strpos($request->channel_name, 'thai_qr') !== false) {
                $getkey = 'biller';
            }

            $data = null;
            if($response->success) {
                $data = $response->data->$getkey;
            }

            return response()->json([
                'success' => true,
                'data'    => $data,
                'type'    => $getkey
            ]);
   
        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function corporate_obj(Request $request)
    {
        try 
        {
            $request->request->add(['bank_id' => $this->BANK_CURRENT]);
         
            $response = $this->api_client->post('api/settlement/product/corporate/create', [
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

    public function corporate_create(Request $request)
    { 
        try {
            $request->request->add(['bank_id' => $this->BANK_CURRENT]);

            $response = $this->helper->PostRequest($this->api_client, 'api/settlement/product/corp/create', $request->all());
  
            if ( $response->success ) {
                return redirect()->action('SettlementController@add_product', ['channel_name' => $response->channel])->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Create Settlement is Successful.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message
                ]);
            }

        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
   
}