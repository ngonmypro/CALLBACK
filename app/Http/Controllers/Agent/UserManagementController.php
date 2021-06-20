<?php

namespace App\Http\Controllers\Agent;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Middleware\AuthToken;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateUser;
use App\Http\Requests\EditUser;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    protected $CORP_CURRENT;
    protected $CORP_CODE;
    protected $BANK_CURRENT;

    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->client 			    = parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
        $this->BANK_CODE			= isset(Session::get('BANK_CURRENT')['code']) ? Session::get('BANK_CURRENT')['code'] : null;
    }

    public function index()
    {
        return view('UserManagement.agent.index');
    }

    public function objectData(Request $request)
    {
        $request->request->add([
            'bank_id'       => $this->BANK_CURRENT,
            'bank_code'     => $request->agent,
        ]);

        try {

            $response = $this->client->post('api/user/agentObjectData', [
                'form_params' => $request->all()
            ]);

            $data_response = json_decode($response->getBody()->getContents());
            
            return response()->json($data_response->object ?? null);

        } catch (\Exception $e) {
            report($e);
            return response()->json(null);
        }
    }

    public function default_create(Request $request)
    {
        return $this->create($request, $this->CORP_CODE);
    }

    public function create(Request $request, $agent_code = 0)
    {
        if ( !blank($this->BANK_CODE) && $this->BANK_CODE !== $agent_code ) {
            return redirect()->action(
                'Agent\UserManagementController@create', ['agent_code' => $this->BANK_CODE]
            );
        }

        $agent_code = $this->BANK_CODE ?? $agent_code;
        if ( blank($agent_code) ) {
            return redirect()->action('Agent\UserManagementController@index')->with([
                'alert-class'   => 'alert-danger',
                'message'       => 'Please select corporate.'
            ]);
        }

        $data = new \stdClass();
        $data->agent_code = $agent_code;

        $response = $this->helper->PostRequest($this->client, 'api/user/get/roles/', [
            'agent_code' => $agent_code,
        ]);

        if ($response->success ?? false) {
            $data->roles = $response->data;
        } else {
            Log::error('Request for get list of roles for corporate with fail: '.$response->message ?? '-');
        }

        return view('UserManagement.agent.create', compact('data'));
    }

    public function create_submit(CreateUser $request)
    {
        try {
            $response = $this->helper->PostRequest($this->client, 'api/user/create', $request->except(['_token']));

            if ( $response->success ?? false ) {
                return redirect()->action('Agent\UserManagementController@index')->with([
                    'alert-class'   => 'alert-success',
                    'message'       => 'User is created successfully.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'   => 'alert-danger',
                    'message'       => $response->message ?? ''
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            
            return redirect()->back()->withInput()->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function detail(Request $request, $user_code)
    {   
        try {

            $data = $this->getUserDetail($user_code);
            return view('UserManagement.agent.detail', compact('data'));

        } catch (\Exception $e) {
            report($e);
            return redirect()->action('Agent\UserManagementController@index')->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $request, $user_code)
    {
        try {

            $data = $this->getUserDetail($user_code);
            return view('UserManagement.agent.edit', compact('data'));

        } catch (\Exception $e) {
            report($e);
            return redirect()->action('Agent\UserManagementController@index')->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage(),
            ]);
        }
    }

    public function edit_submit(EditUser $request)
    {
        try {
            $response = $this->helper->PostRequest($this->client, 'api/user/edit', $request->except(['_token']));

            if ( $response->success == true ) {
                return redirect()->action('Agent\UserManagementController@index')->with([
                    'alert-class'   => 'alert-success',
                    'message'       => 'Update users successful.',
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'   => 'alert-danger',
                    'message'       => $response->message ?? '',
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'   => 'alert-danger',
                'message'       => $e->getMessage(),
            ]);
        }
    }

    private function getUserDetail(string $user_code)
    {
        $response = $this->helper->PostRequest($this->client, 'api/user/inquiry/profile', [
            'user_code'         => $user_code
        ]);

        if ( $response->success && isset($response->data) ) {

            Log::debug('response: '.json_encode($response->data));

            // SET USER DATA
            $data = $response->data->user;
            $data->user_code = $user_code;
            $data->lastname_th = $data->surname_th ?? '';
            $data->lastname_en = $data->surname_en ?? '';
            unset($data->surname_th);
            unset($data->surname_en);

            // CORPORATE DATA
            $data->corp_code = $response->data->corporate->corp_code ?? null;
            $data->agent_code = $response->data->user->agent_code ?? null;

            // ROLE DATA
            $data->roles = [];
            foreach ( $response->data->roles as $key => $value ) {
                array_push($data->roles, (object)[
                    'id'            => $value->id,
                    'name'          => $value->role_name
                ]);
            }

            return $data;

        } 
        
        throw new Exception($response->message ?? '');
    }

    public function requestSuspend(Request $request)
    {
        $func = __FUNCTION__;

        $request->validate([
            'lock_reason'       => 'nullable',
            'reason_message'    => 'nullable',
            'user_id'           => 'required',
        ]);

        $detail_reason = $request->all();
        unset($detail_reason['_token']);

        try {
            $response = $this->helper->PostRequest($this->client, 'api/user/status', [
                'detail' => [
                    'lock_reason'       => isset($detail_reason['lock_reason']) ? $detail_reason['lock_reason'] : null,
                    'reason_message'    => isset($detail_reason['reason_message']) ? $detail_reason['reason_message'] : null
                ],
                'user_id'   => $request->user_id
            ]);

            if ($response->success) {
                return response()->json([
                    'success' => true
                ]);
            } else {
                Log::error("[{$func}] Error: {$response->message}");
                
                return response()->json([
                    'success'   => false,
                    'message'   => 'Can\'t not change user status for some reason'
                ]);
            }

            
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ]);
        }
    }

    public function suspendList(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->client, 'api/get/suspend', null);

            if (! $response->success ) {
                throw new Exception($response->message ?? '');
            }

            return response()->json([
                'success'   => true,
                'data'      => $response->data
            ]);
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'username'             => 'required'
        ]);

        try {
            $response = $this->helper->PostRequest($this->client, 'api/auth/resend', [
                'username' => $request->username
            ]);

            if (! $response->success ) {
                throw new Exception($response->message);
            }

            return response()->json([
                'success'   => true
            ]);
        } catch (\Exception $e) {
            report($e);
            
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ]);
        }
    }
}
