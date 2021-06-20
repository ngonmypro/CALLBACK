<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthToken;
use Exception;
use Illuminate\Support\Facades\Artisan;

class AgentManageController extends Controller
{
    private $request;
    private $helper;
    private $api_client;
    private $API_URL;
    private $user;
    private $CORP_CODE;

    public function __construct(Request $request)
    {
        $this->request              = $request;
        $this->helper				= parent::Helper();
        $this->API_URL              = env('API_URL');
        $this->api_client 			= parent::APIClient();
        $this->user                 = Session::get('user_detail');
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
    }

    //
    public function Index()
    {
        return view('AgentManage.index');
    }

    public function GetBankList(Request $request)
    {
        try {
            $response =  $this->helper->PostRequest($this->api_client, 'api/system/agent/object_data', 
                $request->all()
            );

            return response()->json($response->object ?? null);

        } catch (\Exception $e) {
            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    
    public function PaymentList(Request $request)
    {
        try {
            $response =  $this->helper->PostRequest($this->api_client, 'api/system/agent/payment/object_data', 
                $request->all()
            );

            return response()->json($response->object ?? null);

        } catch (\Exception $e) {
            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }


    public function detail(Request $request, $agent_code)
    {

        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get_info', [
                'bank_code' => $agent_code
            ]);
            
            if ($response->success == true) {
                $bank_data = $response->data->bank_info;
                $function = $response->data->function;
                return view('AgentManage.detail', compact('bank_data', 'function'));
            }

            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $response->message ?? ''
            ]);

        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function Create()
    {
        return view('AgentManage.create');
    }

    public function SubmitBank(Request $request)
    {
        $bank_info = isset($request->bank_info) ? $request->bank_info : null;
        $admin = isset($request->admin) ? $request->admin : null;
        $functions = isset($request->functions) ? $request->functions : null;

        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/submit', [
                'bank_info' => $bank_info,
                'admin'     => $admin,
                'functions'  => $functions
            ]);

            if ($response->success == true) {

                return redirect()->action('AgentManageController@Index')->with([
                    'alert-class' => 'alert-success',
                    'message'  => $response->message
                ]);
            } else {

                return redirect()->back()->withInput()->with([
                    'alert-class' => 'alert-danger',
                    'message'  => $response->message
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

    public function select2_agent(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/request/select2', [
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

    public function bank_setting(Request $request, $agent_code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get_info', [
                'bank_code' => $agent_code
            ]);

            if ($response->success == true) {
                $bank_data = $response->data->bank_info;
                return view('AgentManage.Setting.setting', compact('bank_data'));
            }

            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $response->message ?? ''
            ]);

        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function notify (Request $request)
    {
        $func = __FUNCTION__;
        try {
      
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/setting/notify', $request->all());

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

            return redirect()->back();

        }catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }
    }

    public function payment (Request $request)
    {
        try { 
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/setting/payment', $request->all());
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

            return redirect()->back();

        }catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }

    }

    public function update_payment ($channel_name , $bank_code)
    {
        try { 
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/setting/edit_payment',[
                'channel_name' => $channel_name,
                'bank_code' => $bank_code

            ]);
            if ($response->success == true) {
                $bank_payment = $response->data;
                return view('AgentManage.Setting.Function.Payment.edit', compact('bank_payment' , 'bank_code'));
            }else{
                return response()->json([
                    'success'   => false, 
                ]);
            }
        }catch (\Exception $e) {
            report($e);

            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }
    }

    public function PostUpdatePayment (Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/setting/update_payment', $request->all());

        if (!$response->success) {
            $bank_payment =  $response->data;
            $msg = !blank($response->message) && isset($response->message) 
                ? $response->message 
                : 'An error occurred, please try again later.';
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $msg);

            return view('AgentManage.Setting.Function.Payment.edit', compact('bank_payment'));
        } else {
           $bank_payment =  $response->data;
            Session::flash('alert-class', 'alert-success');
            Session::flash('message', 'Update Success!!');
            return view('AgentManage.Setting.Function.Payment.edit', compact('bank_payment'));
        }
    }

    public function PostCreatePayment (Request $request)
    {
        try 
        {
            $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/setting/create_payment', $request->all());

            if (!$response->success) {
                $msg = !blank($response->message) && isset($response->message) 
                    ? $response->message 
                    : 'An error occurred, please try again later.';
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $msg);
            } else {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update Success!!');
            }
            return redirect()->back();

        }catch (\Exception $e) {
            report($e);
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
        }
    }
   
    public function PaymentCreate($bank_code)
    {
        return view('AgentManage.Setting.Function.Payment.create', compact('bank_code'));
    }

    public function Permissions (Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get/permissions', $request->except(['_token']));

        if ($response->success) {
            return response()->json([
                'success'       => true,
                'data'          => $response->data
            ]);
        }

    }
    public function list_Permissions (Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get/list_permissions', $request->except(['_token']));        
        if ($response->success) {
            return response()->json([
                'success'       => true,
                'data'          => $response->data
            ]);
        }

    }

    public function getItemPermissions (Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get/getitempermissions', $request->except(['_token']));        
        if ($response->success) {
            return response()->json([
                'success'       => true,
                'data'          => $response->data
            ]);
        }
    }

    public function postPermissions (Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/system/agent/get/postpermissions', $request->except(['_token']));        
        if (!$response->success) {
            $msg = !blank($response->message) && isset($response->message) 
                ? $response->message 
                : 'An error occurred, please try again later.';
            Log::error("[{$func}] error: {$msg}");
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $msg);
        } else {
            Session::flash('alert-class', 'alert-success');
            Session::flash('message', 'Create Permisstion Success!!');
        }
        return redirect()->back();
    }
    

}
