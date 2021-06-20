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

class RecipientManageController extends Controller
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
        return view('Recipient.manage.index');
    }

    public function profile($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/profile_info', [
                'code'	    =>	$code,
                'corp_id'	=>	Session::get('CORP_CURRENT')['id']
            ]);

            if ( $response->success ) {
                $profile = $response->data ?? null;
                return view('Recipient.manage.profile', compact('profile'));
                
            } else {
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

    public function profileUpdate($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/profile_info', [
                'code'	    =>	$code,
                'corp_id'	=>	$this->CORP_CURRENT
            ]);

            if ($response->success) {
                $profile = $response->data;
                return view('Recipient.manage.profile_update', compact('profile'));
            } else {
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

    public function profileInvitation($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/profile_invitaion', [
                'code'	    =>	$code,
                'corp_id'	=>	$this->CORP_CURRENT
            ]);

            if ($response->success) {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Send invitation to recipient complete.'
                ]);
            } else {
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

    public function UpdateSave(EditRecipientRequest $request, $code)
    {
        try {
            $request->merge([
                'recipient_code' => $code,
                'corporate_id'   => $this->CORP_CURRENT
            ]);

            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/edit_recipient', $request->except('_token'));

            if ( $response->success ) {

                return redirect()
                    ->action('RecipientManageController@profile', ['code' => $code])
                    ->with([
                        'alert-class'  => 'alert-success',
                        'message'      => 'Update recipient complete'
                    ]);

            } else {
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

    public function create()
    {
        try {
            $response = $this->helper->PostRequest($this->api_client,'api/recipient/corp_noti_channel',[
                'corp_id' => Session::get('CORP_CURRENT')['id']
            ]);

            if($response->success) {
                $noti_channel = $response->data;
                return view('Recipient.manage.create', compact('noti_channel'));
            }
            else {
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

    public function createSave(CreateRecipientRequest $request)
    {
        try {
            $request['corp_id'] = $this->CORP_CURRENT;
            $data = $this->helper->PostRequest($this->api_client, '/api/recipient/create', $request->all());

            if ( $data->success ) {
                return redirect()->action('RecipientManageController@index')->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Create Recipient Successful.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data->message
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
            $request['corp_id']  = $this->CORP_CURRENT;
            $response = $this->api_client->post('api/recipient/objectData', [
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

    public function objectDataCount(Request $request)
    {
        try {

            $request['corporate_id']  = $this->CORP_CURRENT;

            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/objectData/count', $request->all());

            return response()->json($response);

        } catch (\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Upload recipient
    public function import_recipient(Request $request)
    {

        if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);

            if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
                return response()->json([
                    'success'   => false,
                    'message'   => 'ไฟล์ที่อัพโหลดไม่รองรับ'
                ], 200);
            }

            $recipient = [];
            try 
            {
                $corporate = Session::get('CORP_CURRENT');
                $corporate_id = $corporate['id'];
                if ($corporate_id == null) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'กรุณาเลือกบริษัทก่อนทำการอัพโหลด'
                    ], 200);
                }

                $myValueBinder = new \App\ExcelSkuBinder;
                $data = Excel::setValueBinder($myValueBinder)->load($file)->toArray();
                
                array_walk_recursive($data, function (&$input) {
                    $input = htmlentities($input);
                });
                
                $exist_customer_code = $this->helper->PostRequest($this->api_client, 'api/recipient/check_exist_code', [
                    'corporate_id' => $this->CORP_CURRENT,
                    'upload_type'  => $request->upload_type
                ]);


                $csv_code = [];
                    foreach ($data as $key => $value) {  //Read data from each column.
                        $_recipient = [];
                        $_recipient['customer_code']              = isset($value['customer_code']) ? $value['customer_code'] : '';
                        $_recipient['first_name']                 = isset($value['first_name']) ? $value['first_name'] : '';
                        $_recipient['middle_name']                = isset($value['middle_name']) ? $value['middle_name'] : '';
                        $_recipient['last_name']                  = isset($value['last_name']) ? $value['last_name']: '';
                        // $_recipient['citizen_id']                 = isset($value['citizen_id']) ? $value['citizen_id'] : '';
                        $_recipient['email']                      = isset($value['email']) ? $value['email']: '';
                        $_recipient['telephone']                  = isset($value['telephone']) ? $value['telephone']: '';
                        $_recipient['address']                    = isset($value['address']) ? $value['address'] : '';
                        $_recipient['zipcode']                    = isset($value['zipcode']) ? $value['zipcode'] : '';
                        $_recipient['contact']                    = isset($value['contact']) ? $value['contact'] : '';
                        $_recipient['line_id']                    = isset($value['line_id']) ? $value['line_id'] : '';
                        $_recipient['ref_1']                      = isset($value['reference_1']) ? $value['reference_1']: '';
                        $_recipient['ref_2']                      = isset($value['reference_2']) ? $value['reference_2']: '';
                        $_recipient['ref_3']                      = isset($value['reference_3']) ? $value['reference_3']: '';
                        $_recipient['ref_4']                      = isset($value['reference_4']) ? $value['reference_4']: '';
                        $_recipient['ref_5']                      = isset($value['reference_5']) ? $value['reference_5']: '';
                        $_recipient['type']                       = $request->upload_type;
                        $_recipient['remarks']                    = [];
                        $_recipient['status']                     = [];
    
                        //validation
                        $validator = Validator::make(
                            $_recipient,
                            [
                                'customer_code'                 => 'nullable|max:50|regex:/^[a-zA-Z0-9-_]+S*$/',
                                'first_name'                    => 'required|max:100',
                                'middle_name'                   => 'nullable|max:100',
                                'last_name'                     => 'max:100',
                                // 'citizen_id'                    => 'min:7|max:20',
                                'email'                         => 'nullable|regex:/^(?!.{501})(([a-zA-Z0-9\-\_]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{1,})((\s*;\s*)?(\s*$)?)){1,3})$/',
                                'telephone'                     => 'required|regex:/^((\d{1,})?(\d{1,}(;\d{1,}){1,2})?)$/',
                                'address'                       => 'nullable|max:250',
                                'zipcode'                       => 'nullable|max:10',
                                'contact'                       => 'nullable|max:50',
                                'line_id'                       => 'nullable',
                                'reference_1'                   => 'nullable',
                                'reference_2'                   => 'nullable',
                                'reference_3'                   => 'nullable',
                                'reference_4'                   => 'nullable',
                                'reference_5'                   => 'nullable',
                            ]
                        );
                        $_recipient['remarks'] = [];
                        $_recipient['status'] = '';
    
                        if($request->upload_type == 'new')
                        {
                            if ($validator->fails()) 
                            {
                                $_recipient['remarks'] = $validator->messages()->toArray();
                                $_recipient['status'] = 'fail';
                            }
                            else if (!blank($value['customer_code'])) {
                                $customer_code = $value['customer_code'];
        
                                if ( in_array($customer_code, $exist_customer_code->data, true) ) 
                                {
                                    $_recipient['remarks'] = ['Customer code has already in used.'];
                                    $_recipient['status'] = 'fail';
                                }
                                if(in_array($value['customer_code'], $csv_code)) {
                                    $_recipient['remarks'] = ['The Customer code is repeated in cvs.'];
                                    $_recipient['status'] = 'fail';
                                }
                                array_push($csv_code, $value['customer_code']);
                            }
                            else
                            {
                                $_recipient['remarks'] = 'PASS';
                                $_recipient['status'] = 'success';
                            }
                            
                            if(blank($_recipient['status'])) {
                                $_recipient['remarks'] = 'PASS';
                                $_recipient['status'] = 'success';
                            }      
                        }
                        else if($request->upload_type == 'replace'){
                            if ($validator->fails()) 
                            {
                                $_recipient['remarks'] = $validator->messages()->toArray();
                                $_recipient['status'] = 'fail';
                            }
                            else if (!blank($value['customer_code'])) {
                                $customer_code = $value['customer_code'];

                                if ( in_array($customer_code, $exist_customer_code->data, true) ) 
                                {
                                    $_recipient['remarks'] = 'PASS';
                                    $_recipient['status'] = 'success';
                                }else{
                                    $_recipient['remarks'] = ['The Customer code does not exist in the database.'];
                                    $_recipient['status'] = 'fail';
                                }
                                if(in_array($value['customer_code'], $csv_code)) {
                                    $_recipient['remarks'] = ['The Customer code is repeated in cvs.'];
                                    $_recipient['status'] = 'fail';
                                }
                                    
                                array_push($csv_code, $value['customer_code']);
                            }
                            else if( (blank($value['customer_code'])) ) {
                                $_recipient['remarks'] = ['The Customer code not specified.'];
                                $_recipient['status'] = 'fail';
                            }
                            else
                            {
                                $_recipient['remarks'] = 'PASS';
                                $_recipient['status'] = 'success';
                            }
                            
                            if(blank($_recipient['status'])) {
                                $_recipient['remarks'] = 'PASS';
                                $_recipient['status'] = 'success';
                            }      
                        }
                        array_push($recipient, $_recipient);
                    }

                Session::put('import_data', $recipient);
                Session::put('update_type', $request->upload_type);

                return response()->json([
                    'success' => true
                ]);
            } catch (\Exception $e) {
                report($e);


                return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function upload_page(Request $request)
    {
        return view('Recipient.manage.Upload.index');
    }

    public function download_template($template_type)
    {
        try
        {
            $path = '';
            $file_name = 'RECIPIENT_TEMPLATE';
            if($template_type == 'xlsx') {
                $path = storage_path('template/recipient_master_file.xlsm');
                $file_name .= '.xlsm';
            } else if($template_type == 'csv') {
                $path = storage_path('template/recipient_template.csv');
                $file_name .= '.csv';
            }
            // $path = storage_path('template/recipient_template.csv');
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

    public function confirm_page()
    {
        if (!Session::has('import_data')) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'Data dose not exist!');
            return redirect('Recipient');
        }

        $bill       = Session::get('import_data');
        $type       = Session::get('update_type');
        
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

        return view('Recipient.manage.Upload.confirm', compact('total', 'success', 'fail' , 'type'));
    }

    public function confirmCancel()
    {
        Session::forget('import_data');

        return redirect('Recipient/Upload');
    }

    public function confirm_obj(Request $request)
    {

        $all_bill = Session::get('import_data') != null
            ? Session::get('import_data')
            : [];

        return Datatables::of($all_bill)
            ->addColumn('status_label', function ($data) {
                if ($data['status'] == 'FAILED') {
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
                
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/upload', [
                'data'         => $all_recipient,
                'corporate_id' => Session::get('CORP_CURRENT')['id'],
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

    public function select2_recipient(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/request/select2', [
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

    public function check_code(Request $request)
    {
        try {
           
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/request/check_code', [
                'corporate_id'      => $this->CORP_CURRENT,
                'bank_id'           => $this->BANK_CURRENT,
                'recipient_code'            => $request->recipient_code,
            ]);

            if ($response->success == true)
            {
                Session::forget('import_data');
                Session::flash('alert-class', 'alert-success');
            
                return response()->json([
                    'message' => 'success',
                    'success' => true
                ], 200);
            } 
            else 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Error'
                ], 200);
            }

        } catch (\Exception $e) {
            report($e);

            return response()->json(null);
        }
    }

    public function sendSMSCardStore(Request $request)
    {
        try {
            $this->validate($request, [
                'recipient_code'    => 'required',
            ]);
    
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/request/cardstore', [
                'corporate_id'              => $this->CORP_CURRENT,
                'bank_id'                   => $this->BANK_CURRENT,
                'recipient_code'            => $request->recipient_code,
                'request_type'              => $request->request_type
            ]);

            Log::info('response '.json_encode($response));
    
            if($response->success) {
                return response()->json([
                    'success'       => true,
                    'url'           => $response->url ?? NULL
                ]);
            }
            else {
                return response()->json([
                    'success'       => false,
                    'message'       => $response->message
                ]);
            }
        }
        catch (\Exception $e) {
            report($e);
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }
    
    /////// START demo create recipient group //////////////////////////////////////
    public function group()
    {
        $recipient_group = $this->api_client->get('api/recipient/show_group');
        $data_response = json_decode($recipient_group->getBody()->getContents());
        
        if ($data_response->success) {
            $group = $data_response->data->group;
            $count = $data_response->data->count;
            $total = $data_response->data->total;

            return view('Recipient.group.index', compact('group', 'count', 'total'));
        } else {
            return response()->json([
                'success'   =>  false,
                'data'      =>  'xxxxxxxxxx'
            ]);
        }
    }
    public function create_group()
    {
        return view('Recipient.group.create_recipient_group');
    }
    public function edit_group($group_id)
    {
        $recipient = $this->helper->PostRequest($this->api_client, 'api/recipient/edit_group', [
                                                                        'group_id' => $group_id
                                                                    ]);
        $recipient = $recipient->data->recipient;
        $count  =   count($recipient);

        return view('Recipient.group.edit_recipient_group', compact('recipient', 'count'));
    }
    public function select_recipient(Request $request)
    {
        $response = $this->api_client->post('api/recipient/select_recipient', [
                                                                                '_token' => $request->_token
                                                                            ]);
        $data_response = json_decode($response->getBody()->getContents());
        if ($data_response->success) {
            $recipient = $data_response->data;

            return $recipient;
        } else {
            return response()->json([
                'success'   =>  false,
                'data'      =>  'xxxxxxxxxx'
            ]);
        }
    }
    public function create_recipient_group(Request $request)
    {
        try {
            $corp_id = \Session::get('CORP_CURRENT')['id'];
            if (isset($request->select_recipient)) {
                $data_response = $this->helper->PostRequest($this->api_client, 'api/recipient/create_recipient_group', [
                                                                            'corp_id'       =>  $corp_id,
                                                                            'data'          =>  $request->all()
                                                                ]);
                if ($data_response->success) {
                    return response()->json([
                        'success'   =>  true,
                        'data'      =>  'success'
                    ]);
                } else {
                    if ($data_response->data == 'name') {
                        return response()->json([
                            'success'   =>  false,
                            'data'      =>  'name',
                            'massage'   =>  'มีชื่อนี้ในระบบแล้ว'
                        ]);
                    } else {
                        return response()->json([
                            'success'   =>  false,
                            'data'      =>  'dataFail',
                            'massage'   =>  'ไม่สามารถสร้างข้อมูลได้ กรุณาลองใหม่'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'success'   =>  false,
                    'data'      =>  'select',
                    'massage'   =>  'กรุณาเลือกสามาชิกกลุ่ม'
                ]);
            }
        } catch (\Exception $e) {
            report($e);            

            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ], 200);
        }
    }
    public function edit_recipient_group(Request $request)
    {
        try {
            $corp_id = Session::get('CORP_CURRENT')['id'];
            if (isset($request->select_recipient)) {
                $data_response = $this->helper->PostRequest($this->api_client, 'api/recipient/edit_recipient_group', [
                                                                            'corp_id'       =>  $corp_id,
                                                                            'data'          =>  $request->all()
                                                                ]);
                if ($data_response->success) {
                    return response()->json([
                        'success'   =>  true,
                        'data'      =>  'success'
                    ]);
                } else {
                    if ($data_response->data == 'name') {
                        return response()->json([
                            'success'   =>  false,
                            'data'      =>  'name',
                            'massage'   =>  'มีชื่อนี้ในระบบแล้ว'
                        ]);
                    } else {
                        return response()->json([
                            'success'   =>  false,
                            'data'      =>  'dataFail',
                            'massage'   =>  'ไม่สามารถสร้างข้อมูลได้ กรุณาลองใหม่'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'success'   =>  false,
                    'data'      =>  'select',
                    'massage'   =>  'กรุณาเลือกสามาชิกกลุ่ม'
                ]);
            }
        } catch (\Exception $e) {
            report($e);            

            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ], 200);
        }
    }

    public function delete_recipient_group(Request $request)
    {
        try {
            $corp_id = Session::get('CORP_CURRENT')['id'];
            $data_response = $this->helper->PostRequest($this->api_client, 'api/recipient/delete_recipient_group', [
                                                                        'corp_id'       =>  $corp_id,
                                                                        'data'          =>  $request->all()
                                                            ]);
            if ($data_response->success) {
                return response()->json([
                    'success'   =>  true,
                    'data'      =>  'success'
                ]);
            } else {
                return response()->json([
                    'success'   =>  false,
                    'data'      =>  'xxxxxxxxxx'
                ]);
            }
        } catch (\Exception $e) {
            report($e);            

            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ], 200);
        }
    }

    public function recipient_activity(Request $request) 
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/recipient/recipient_activity',  [
                'action'            => $request->action,
                'recipient_code'    => $request->recipient_code,
                'corporate_id'      => $this->CORP_CURRENT
            ]);

            if ( $response->success ) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Recipient Is Successfully.');
                return response()->json([
                    'success'   =>  true,
                    'message'   =>  'success'
                ]);
            } else {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);            
            Session::flash('alert-class', 'alert-success');
            Session::flash('message', $e->getMessage());
            return response()->json([
                'success'   =>  false,
                'message'   =>  $e->getMessage()
            ], 200);
        }
    }
    /////// END demo create recipient group ///////////////////////////////////////////
}
