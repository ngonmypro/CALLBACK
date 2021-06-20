<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Middleware\AuthToken;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Requests\CreateUser;
use App\Http\Requests\EditUser;

class UserManagementController extends Controller
{
    private $delegate;
    private $CORP_CURRENT;
    private $CORP_CODE;

    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper 			    = parent::Helper();

        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
        $this->BANK_CODE			= isset(Session::get('BANK_CURRENT')['code']) ? Session::get('BANK_CURRENT')['code'] : null;
    }

    public function index()
    {
        return view('UserManagement.index');
    }

    public function objectData(Request $request)
    {
        unset($request ['_token']);
        $request['corp_id'] = $this->CORP_CURRENT;
        try {
            $response = $this->api_client->post('api/user/objectData', [
                'form_params' => $request->all()
            ]);
            // Log::debug('datatable: '.json_encode($response));

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            report($e);

            $this->ServiceException($e);
            return DataTables::of([]);
        }
    }

    public function create()
    {
        return view('UserManagement.create');
    }

    public function create_submit(CreateUser $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/create', $request->except(['_token']), [
                'token'     => Session::get('token')
            ]);

            if ( $response->success ) {
                return redirect()->to('UserManagement')->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'User is created successfully.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message ?? ''
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

    public function detail(Request $request, $code)
    {   
        try {
            $data = new \stdClass();

            $response = $this->helper->PostRequest($this->api_client, 'api/user/inquiry/profile', [
                'user_code'     => $code,
                'corporate_id'  => $this->CORP_CURRENT,
            ]);

            if ( $response->success ) {
                $_data = json_decode(json_encode($response->data ?? null), true);

                // // USER DATA
                foreach ($_data['user'] as $key => $value) {
                    $data->{$key} = $value;
                }

                $data->lastname_th = $data->surname_th;
                $data->lastname_en = $data->surname_en;
                unset($data->surname_th);
                unset($data->surname_en);

                // CORPORATE DATA
                $data->corp_code = array_column($_data['corporate'], 'corp_code');

                // ROLE DATA
                $data->roles = [];
                
                foreach ($_data['roles'] as $key => $value) {
                    array_push($data->roles, (object)[
                        'id'            => $value['id'],
                        'name'          => $value['role_name']
                    ]);
                }

                return view('UserManagement.detail', compact('data', 'code'));
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

    public function edit($code)
    {
        try {
            $data = new \stdClass();

            $response = $this->helper->PostRequest($this->api_client, 'api/user/info', [
                'id' => $code
            ]);

            if ($response->success === true) {
                $_data = json_decode(json_encode($response->data), true);

                // USER DATA
                foreach ($_data['user'] as $key => $value) {
                    $data->{$key} = $value;
                }
                $data->lastname_th = $data->surname_th;
                $data->lastname_en = $data->surname_en;
                unset($data->surname_th);
                unset($data->surname_en);

                // CORPORATE DATA
                $data->corp_code = array_column($_data['corporate'], 'corp_code');

                // ROLE DATA
                $data->roles = [];

                foreach ($_data['roles'] as $key => $value) {
                    array_push($data->roles, (object)[
                        'id'            => $value['id'],
                        'name'          => $value['role_name']
                    ]);
                }

                return view('UserManagement.edit', compact('data', 'code'));
            } else {
                return redirect()->to('UserManagement')->withInput()->with([
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

    public function edit_submit(EditUser $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/edit', $request->except(['_token']), [
                'token'     => Session::get('token')
            ]);

            if ($response->success) {
                $response = $this->helper->PostRequest($this->api_client, 'api/user/detail', null, [
                    'Authorization' => 'Bearer '.Session::get('token')
                ]);
                if ($response->success === true) {
                    $userdetail = $response->user;
                    Session::put('user_detail', $response->user);
                    Session::put('locale', strtolower($response->user->localize));

                    if ($userdetail->user_type === 'USER' || $userdetail->user_type === 'AGENT') {
                        Session::put('user_list', $response->user);
                    }
                }

                return redirect()->to('/User/Profile')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Update user profile successfully.'
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

    public function objectData_AllCorpUser(Request $request)
    {
        try {
            $response = $this->api_client->post('api/user/get/corps/objectData', [
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
            return DataTables::of([]);
        }
    }

    public function CountUsersStatus(Request $request)
    {
        try {
            $user_type = $request->query('type') != null 
                ? $request->query('type') 
                : Session::get('user_detail')->user_type;

            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/status/count/'.$user_type, null);

            if ($response->success == true) {
                return response()->json($response);
            } else {
                return response()->json([
                    'success'       => false,
                    'message'       => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return DataTables::of([]);
        }
    }

    public function objectData_CorpUser(Request $request, $corp_code)
    {
        try {

            $response = $this->api_client->post('api/user/get/corp/'.$corp_code.'/objectData', [
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

    public function CreateUserSelectCorporate()
    {
        try {
            $response = $this->api_client->post('api/user/get_corporate');

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data->success == true) {
                $corporate_list = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($data->data), true);

            }
        } catch (\Exception $ex) {
            report($ex);
        }

        try {
            $response = $this->api_client->get('api/user/users_data');

            $data_user = \GuzzleHttp\json_decode($response->getBody()->getContents());
        } catch (\Exception $ex) {
            report($ex);
        }
        $users_type  =  $data_user->data;

        $type = $users_type != null ? explode('.', $users_type->user_type) : '';

        Session::put('users_type', $type);
        return view('UserManagement.Create.SelectCorporate', compact('corporate_list', 'type'));
    }

    public function SubmitUserSelectCorporate(Request $request)
    {
        $queryCorporate = $request->all();

        unset($queryCorporate ['_token']);

        Session::put('create_user_step1', true);
        Session::put('step_CreateUserSelect', $queryCorporate);

        $step_1 = Session::get('step_CreateUserSelect');
        return response()->json(['success' => true]);
    }

    // CORP USER
    public function CreateCorporateUser($corp_code)
    {
        $data = new \stdClass();

        try {
            $data->corp_code = [$corp_code];

            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/roles/', [
                'corp_code' => $corp_code,
            ]);
            if ($response->success === true) {
                $data->roles = $response->data;
            }
        } catch (\Exception $e) {
            report($e);
        }

        return view('UserManagement.corporate.create', compact('data'));
    }

    // CORP USER
    public function CreateUserCorporateSubmit(CreateUser $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/create', $request->except(['_token']), [
                'token'     => Session::get('token')
            ]);

            if ($response->success == true) {
                return redirect()->to('UserManagement')->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'User is created successfully.'
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

    public function GetAgents(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/agents', null);

            if ($response->success == true) {
                return response()->json([
                    'success'       => true,
                    'data'          => $response->data
                ]);
            } else {
                return response()->json([
                    'success'           => false,
                    'message'           => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            
            return response()->json([
                'success'           => false,
                'message'           => $e->getMessage()
            ]);
        }
    }

    public function GetRoles(Request $request)
    {
        $corp_code = !blank($this->CORP_CODE) ? $this->CORP_CODE : $request->corp;
        $agent_code = !blank($this->BANK_CODE) ? $this->BANK_CODE : $request->agent;

        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/roles/', [
                'corp_code'     => $corp_code,
                'agent_code'    => $agent_code,
            ]);

            if ($response->success == true) {
                return response()->json([
                    'success'   =>  true,
                    'data'      =>  $response->data
                ]);
            } else {
                return response()->json([
                    'success'       => false,
                    'message'       => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }

    public function getJobsAddNewUser(Request $request)
    {
        try {
            $response = $this->api_client->post('api/user/all_jobs', [
                'form_params' => [
                    'corp_id' => $request->corp_id
                ]
            ]);
            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data->success == true) {
                $data_job = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($data->data), true);

                return response()->json($data_job);
            }
        } catch (\Exception $ex) {
            report($ex);
        }

        return response()->json([]);
    }

    public function GetUsersInfo($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/info', [
                'id' => $code
            ]);
            return response()->json($response);
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ]);
        }
    }

    public function UsersProfile()
    {
        try {
            $data = new \stdClass();

            $response = $this->helper->PostRequest($this->api_client, 'api/user/info', [
                'id' => ''
            ]);

            if ($response->success === true) {
                $_data = json_decode(json_encode($response->data), true);

                // USER DATA
                foreach ($_data['user'] as $key => $value) {
                    $data->{$key} = $value;
                }
                $data->lastname_th = $data->surname_th;
                $data->lastname_en = $data->surname_en;
                unset($data->surname_th);
                unset($data->surname_en);

                // CORPORATE DATA
                $data->corp_code = array_column($_data['corporate'], 'corp_code');

                // ROLE DATA
                $data->roles = [];

                foreach ($_data['roles'] as $key => $value) {
                    array_push($data->roles, (object)[
                        'id'            => $value['id'],
                        'name'          => $value['role_name']
                    ]);
                }

                return view('UserManagement.Profile.profile', compact('data'));
            } else {
                return redirect()->to('UserManagement')->with([
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

    public function RequestSuspend(Request $request)
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
            $response = $this->helper->PostRequest($this->api_client, 'api/user/status', [
                'detail' => [
                    'lock_reason'       => isset($detail_reason['lock_reason']) ? $detail_reason['lock_reason'] : null,
                    'reason_message'    => isset($detail_reason['reason_message']) ? $detail_reason['reason_message'] : null
                ],
                'user_id'   => $detail_reason['user_id']
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

    public function SaveEditUser(Request $request)
    {
        $user_info = $request->all();
        unset($user_info ['_token']);

        $validator = Validator::make(
            $user_info,
            [
                // 'email'             =>  'required|email',
                'phone'             =>  'required',
                'name_en'           =>  'required',
                'lastname_en'       =>  'required',
            ],
                [
                // 'email.required'            => 'username number is required',
                'phone.required'            => 'telephone is required',
                'name_en.required'          => 'firstname english is required',
                'lastname_en.required'      => 'lastname english is required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid value for edit');
        }

        try {
            $response = $this->api_client->post('api/user/edit', [
                'form_params' => [
                        'user_info' => $user_info
                ]
            ]);

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data->success == true) {
                return response()->json(['success' => true, 'message' => $data->message]);
            } else {
                return response()->json(['success' => false, 'message' => $data->message]);
            }
        } catch (\Exception $e) {
            report($e);

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function CancelCreateUser()
    {
        Session::forget('create_user_step1');
        Session::forget('step_CreateUserSelect');

        return redirect('UserManagement/Index');
    }

    private function forgetSession()
    {
        Session::forget('create_user_step1');
        Session::forget('step_CreateUserSelect');
    }

    public function ServiceException(Exception $exception)
    {
        try {
            $response_exception = \GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents());

            if ($response_exception->code == 99) {
                return (new AuthToken())->ExceptionToken($response_exception);
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            report($ex);
            return null;
        }
    }

    public function SuspendList(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/get/suspend', null);

            if (!$response->success) {
                throw new Exception($response->message);
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

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'username'             => 'required'
        ]);

        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/auth/resend', [
                'username' => $request->username
            ]);

            if (!$response->success) {
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

    public function ResetLoginAttempt(Request $request)
    {
        try {
            $response = $this->api_client->post('api/user/reset_login_attempt', [
                'form_params' => [
                        'user_code' => $request->user_code
                ]
            ]);

            $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($result->success == false) {
                throw new Exception($result->message);
            }

            return response()->json([
                'success'   => true,
                'data'      => $result->data
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'success'   => false,
            ]);
        }
    }

    public function change_lang(Request $request, $locale) {

        if (!blank(Session::get('token'))) {
            try {
                $response = $this->helper->PostRequest($this->api_client, 'api/user/update/lang', [
                    'lang'      => strtoupper($locale)
                ]);
                if (!$response->success) {
                    Log::warning("[".__FUNCTION__."] response: ".json_encode($response));
                } else {
                    Log::debug("[".__FUNCTION__."] response: ".json_encode($response));
                }
            } catch (Exception $e) {
                report($e);
            }
        }

        \Session::put('locale', $locale);
        \Session::save();
        
        return redirect()->back();
    }
}
