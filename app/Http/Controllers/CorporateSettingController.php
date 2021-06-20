<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorpCustomerFeeRequest;
use App\Http\Requests\CorpSettingBankAcc;
use App\Http\Requests\CorpSettingLoanSchedule;
use App\Http\Requests\CorpSettingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use \Validator;
use App\Http\Requests\CorpSettingNotify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CorporateSettingController extends Controller
{
    private $CORP_CURRENT;
    private $CORP_CODE;
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->client               = parent::APIClient();
        $this->API_URL              = env('API_URL');
        $this->CORP_CURRENT         = isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE            = isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
    }

    public function index(Request $request)
    {
        return $this->setting($request, $this->CORP_CODE);
    }

    public function setting(Request $request, $corp_code = null)
    {
        $func = __FUNCTION__;
        if ( !blank($this->CORP_CODE) ) {
            $corp_code = $this->CORP_CODE;
        } else if ( blank($corp_code) ) {
            Log::warning("[{$func}] error: corp_code is empty");
            return redirect()->to('/Exception/AccessDenied');
        }
        
        try {
            $response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/corporate/setting',
                [
                    'corp_code'  => $corp_code
                ]
            );

            $payment_channel = $this->helper->PostRequest($this->client, $this->API_URL.'/api/corporate/setting/get_payment_channel',
                [
                    'corp_code'  => $corp_code
                ]
            );

            if (!$response->success || !$payment_channel->success) {

                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'Whoops, looks like something went wrong.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);

            } else {
                $data = $response->data;
                $etax_job = isset($data->etaxjob) ? json_decode(json_encode($data->etaxjob), true) : NULL;
                $cer_data = isset($data->cer_data) ? json_decode(json_encode($data->cer_data), true) : NULL;

                $channel_name = [];

                foreach ($payment_channel->data as $key => $value) {
                    array_push($channel_name, $value->channel_name);
                }

                $payment_config = isset($data->payment->config) ? json_decode($data->payment->config) : NULL;

                $branch = isset($data->branch) ? $data->branch : NULL;

                $notify = isset($data->notify) ? $data->notify : NULL;

                $notify_config = isset($data->notify_config) ? json_decode($data->notify_config->config) : NULL;

                $email_config = isset($data->email_config) ? $data->email_config : NULL;

                $line_config = isset($data->line_config) ? $data->line_config : NULL;

                $sheet_config = isset($data->sheet_config) ? json_decode($data->sheet_config->config) : NULL;
                
                $function_config = isset($data->function) ? $data->function : NULL;

                $notify_type = ['BILL','LOAN','POS','FORWARD_NOTIFY'];
                $data->bank_logo = $this->getfiles( 'assets/images/bank_logo' )->toArray();
                
                return view('Corporate.Setting.setting', compact('data', 'corp_code','channel_name','payment_config','branch','notify','notify_config','notify_type','email_config','line_config','etax_job','cer_data', 'sheet_config', 'function_config'));
            }
        } catch (\Exception $e) {
            report($e);
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        // return view('Corporate.Setting.setting', compact('corp_code'));
    }

    /**
     * return collection|null
     */
    protected function getfiles(string $directory)
    {
        // list all filenames in given path
        return collect( Storage::disk( 'public' )->files( Str::finish($directory, '/') ) )
                    ->map(function ($filename) {
                        $tmp = explode('/', $filename);
                        return [
                            'path'      => $filename,
                            'filename'  => end( $tmp ),
                            'name'      => head( explode('.', end( $tmp )) ),
                        ];
                    });
    }

    public function customer_fee_setting(CorpCustomerFeeRequest $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/customerfee', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function loan_schedule(CorpSettingLoanSchedule $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/loanschedule', 
                $request->except('_token')
            );
            Log::debug(json_encode($response));

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function payment(CorpSettingPayment $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/payment', 
                $request->except('_token')
            );

            if ( !$response->success ) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");

                return redirect()->back()->withInput()->with([
                    'alert-class'   => 'alert-danger',
                    'message'       => $msg
                ]);

            } else {
                return redirect()->back()->with([
                    'alert-class'   => 'alert-success',
                    'message'       => 'Update Success!!'
                ]);
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput()->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage()
            ]);
        }

        
    }

    public function img_logo(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/img_logo', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function notify(CorpSettingNotify $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/notify', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function email(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/email', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function line(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/line', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function sheet(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/sheet', 
                $request->except('_token')
            );

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Log::error("[{$func}] error: {$msg}");
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
        } catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

        return redirect()->back();
    }

    public function get_obj_pdf_template(Request $request)
    {
        Log::info($request->corp_code);
        try {
            $response = $this->helper->PostRequest(
                $this->client,
                $this->API_URL.'/api/corporate/setting/pdf_template/object', 
                $request->except(['_token']),
                [
                    'corp_code'  => $request->corp_code
                ]
            );
            Log::info('$response '.json_encode($response));

            if ($response->success) {
                return response()->json($response->object);
            } else {
                return response()->json(null);
            }
        } 
        catch (\Exception $e) {
            report($e);
            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function create_pdf_tempate($corp_code)
    {
        try
        {
            $response = $this->helper->PostRequest(
                $this->client, 
                $this->API_URL.'/api/corporate/setting/get/pdf_template', 
                [
                    'query_type' => 'create'
                ]
            );
            if ($response->success) 
            {
                $documents = $response->data->document_type;
                return view('Corporate.Setting.Function.PDFTemplate.pdf_template', compact('documents', 'corp_code'));
            }
            else{
                return redirect('/Exception/InternalError');
            }
        } 
        catch(\Exception $e) 
        {
            report($e);
            return redirect('/Exception/InternalError');
        }
    }

    public function pdf_template_confirm(Request $request)
    {
        try
        {
            $base64_file = '';
            $original_filename = '';
            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                $file = file_get_contents($uploadedFile);
                $base64_file = base64_encode($file);
                $original_filename = $request->file('file')->getClientOriginalName();

                if(!strpos($original_filename, '.jrxml') !== false) {
                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('message', 'The System support file type .jrxml only!');
                    return redirect()->back()->withInput();
                }
                Log::info('has file');
            }
            else{
                if($request['method'] == 'create') {
                    Session::flash('alert-class', 'alert-danger');
                    Session::flash('message', 'Please input template file .jrxml and try again!');
                    return redirect()->back()->withInput();
                }
            }

            unset($request['_token'], $request['file']);
            $response = $this->helper->PostRequest(
                $this->client, 
                $this->API_URL.'/api/corporate/setting/create_pdf_template', 
                [
                    'method' => $request['method'],
                    'data' => $request->except('_token'),
                    'file' => [ 
                        'file_content'  => $base64_file,
                        'file_name'     => $original_filename
                    ]
                ]
            );

            if ($response->success) 
            {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', $response->message);
                return redirect('/Corporate/'.$request->corp_code.'/Setting');
            }
            else{
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $response->message);
                return redirect()->back()->withInput();
            }
        } 
        catch(\Exception $e) 
        {
            report($e);
            Log::error("[{".__FUNCTION__."}] error: {$e->getMessage()}");
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function pdf_tempate($corp_code, $template_code) 
    {
        try
        {
            $response = $this->helper->PostRequest(
                $this->client, 
                $this->API_URL.'/api/corporate/setting/get/pdf_template', 
                [
                    'query_type' => 'update',
                    'reference' => $template_code
                ]
            );
            if ($response->success) 
            {
                $status = $response->data;
                $pdf_template = $response->data->template;
                $documents = $response->data->document_type;
                $pdf_preview = $response->data->pdf_preview;
                $signature_type = $response->data->template->signature_type;
                $signature = $response->data->template->signature_detail;
                $reference = $response->data->template->reference;
                $signatureDetail = json_decode($signature, true);

                return view('Corporate.Setting.Function.PDFTemplate.edit_pdf_template', compact('pdf_template', 'documents', 'corp_code', 'template_code','pdf_preview' , 'signatureDetail' , 'signature_type', 'status'));
            }
            else{
                return redirect('/Exception/InternalError');
            }
        } 
        catch(\Exception $e) 
        {
            report($e);
            return redirect('/Exception/InternalError');
        }
    }

    public function etax_rd(Request $request)
    {
        try
        {
            $request['corporate_id'] = isset($this->CORP_CURRENT) ? $this->CORP_CURRENT : "";
            $request['corp_code'] = isset($request->corp_code) ? $request->corp_code : "";

            $data_response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/etax/etax_rd',$request->all());

            if ($data_response->success) 
            {

                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);

            } 
            else 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
                ]);

            }
        }
        catch (\Exception $e)
        {
            report($e);

            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    public function etax_create_job(Request $request)
    {
        try 
        {
            Log::info('etax_create_job:'.json_encode($request->all()));
            $request['corporate_id'] = isset($this->CORP_CURRENT) ? $this->CORP_CURRENT : "";
            $request['corp_code'] = isset($request->corp_code) ? $request->corp_code : "";

            $data_response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/etax/etax_create_job',$request->all());

            if ($data_response->success) 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);
            } 
            else 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
                ]);
            }
        } 
        catch (\Exception $e) 
        {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    public function inactive_job(Request $request)
    {
        try 
        {
            $data_response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/etax/inactive_job',$request->all());

            if ($data_response->success) 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);
            } 
            else 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
                ]);
            }
        } 
        catch (\Exception $e) 
        {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    public function job_detail(Request $request)
    {
       
        try
        {
            $data_response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/etax/job_detail',$request->all());
            if ($data_response->success) 
            {
                return  response()->json([
                    'success'       => true,
                    'job_detail'    => $data_response->job_detail,
                    'count'         => count($data_response->job_detail)
                ], 200);
            } 
            else 
            {
                return  response()->json([
                    'success'       => false,
                    'job_detail'    => null,
                    'count'         => 0
                ], 200);
            }
        }
        catch (\Exception $e)
        {
            report($e);
            return response()->json([
                'success'       => false,
                'message'       => "show job fail.",
                'job_detail'    => null,
                'count'         => 0
            ], 200);
        }
    }
    
    public function function(Request $request)
    {
        try 
        {
            $data_response = $this->helper->PostRequest($this->client, $this->API_URL.'/api/corporate/setting/function',
                $request->all()
            );

            if ($data_response->success) 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);
            } 
            else 
            {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
                ]);
            }
        } 
        catch (\Exception $e) 
        {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
}
