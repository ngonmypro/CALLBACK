<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use \Exception;
use App\Http\Requests\CreateUserRole;

class RoleManagementController extends Controller
{
    private $CORP_CODE;
    
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
        $this->BANK_CURRENT         = Session::get('BANK_CURRENT')['id']        ?? null;
        $this->BANK_CODE            = Session::get('BANK_CURRENT')['code']        ?? null;
        $this->CORP_CURRENT         = Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE            = Session::get('CORP_CURRENT')['corp_code'] ?? null;
    }

    public function Index()
    {
        return view('RoleManagement.index');
    }

    public function GetRoleDetail(Request $request)
    {
        try {
            $response = $this->api_client->post('api/user/get/roles/objectData', [
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

    public function CreateRole()
    {
        return view('RoleManagement.create');
    }

    public function GetObjectType(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/object/usertype', $request->except(['_token']));

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

    public function SubmitCreateRole(CreateUserRole $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['corporate']  = $this->CORP_CODE;
            $response = $this->helper->PostRequest($this->api_client, 'api/user/create/permissions', 
                $data,
                [
                    'token'     => Session::get('token')
                ]
            );

            if ($response->success == true) {
                if($request->user_type == "AGENT"){
                    return redirect('/RoleManagement/Agent')->with([
                        'alert-class'  => 'alert-success',
                        'message'      => 'Create Role Permission Successful.'
                    ]);
                }
                else {
                    return redirect('/RoleManagement/Corporate')->with([
                        'alert-class'  => 'alert-success',
                        'message'      => 'Create Role Permission Successful.'
                    ]);
                }

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
    

    public function GetPermissions(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/user/get/permissions', $request->except(['_token']));

            if ($response->success) {
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

    public function RegisterRole(Request $request)
    {
        $role = $request->all();
        unset($role['_token']);
        Session::put('role', $role);

        return response()->json(['success' => true]);
    }

    public function CreatePermission()
    {
        try {
            $response = $this->api_client->get('api/user/permissions');

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            if ($data->success == true) {
                $permission_list = \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($data->permission), true);
                return view('RoleManagement.Create.Permission', compact('permission_list'));
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data->message
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

    public function SubmitCreatePermission(Request $request)
    {
        $permission = $request->all();

        unset($permission['_token']);

        try {
            $role_detail = [
                'name'			=> '',
                'description'	=> '',
                'permission'    => $permission,
                'role_detail'   => $this->CORP_CODE
            ];

            // get role detail
            $role = $this->session_getorthrow('role');

            $role_detail['name']                =       isset($role['name']) ? $role['name'] : '';
            $role_detail['description']         =       isset($role['description']) ? $role['description'] : '';

            $response = $this->api_client->post('api/user/permissions', [
                'json' => $role_detail
            ]);

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            if ($data->success == true) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => $data->message]);
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function RoleAndPermission($code)
    {
        $role_permission = [];
        try 
        {    
            $response = $this->helper->PostRequest(
                $this->api_client, 'api/user/permissions', 
                [
                    'role_id' => $code
                ]
            );
            
            $permission_list = [];
            $role_name = [];
            $role_description = [];
            if ($response->success == true) {
                $data = json_decode(json_encode($response->data), true);
            }
            else
            {
                throw new Exception($response->message);
            }

        } catch (\Exception $e) {
            report($e);
            return redirect('/InternalError');
        }

        return view('RoleManagement.Edit.preview', compact('data', 'code'));
    }

    public function EditRolePermission($code)
    {
        $role_permission = [];
        try 
        {    
            $response = $this->helper->PostRequest(
                $this->api_client, 'api/user/permissions', 
                [
                    'role_id' => $code
                ]
            );
            
            $permission_list = [];
            $role_name = [];
            $role_description = [];
            if ($response->success == true) {
                $data = json_decode(json_encode($response->data), true);
            }
            else
            {
                throw new Exception($response->message);
            }

        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }

        return view('RoleManagement.Edit.edit', compact('data', 'code'));
    }

    public function _UpdateRoleAndPermission(Request $request)
    {
        $role_permission = $request->all();
        $eisting_role_id = $role_permission['existing_role_id'];
        $name = $role_permission['name'];
        $description = $role_permission['description'];

        unset($role_permission['_token']);
        unset($role_permission['existing_role_id']);
        unset($role_permission['name']);
        unset($role_permission['description']);

        try {
            $role_detail = [
                'name'			=> '',
                'description'	=> '',
                'permission'    => $role_permission
            ];

            // get role detail

            $role_detail['existing_role_id'] = $eisting_role_id;
            $role_detail['name'] = $name;
            $role_detail['description'] = $description;

            $response = $this->api_client->post('api/user/permissions', [
                'json' => $role_detail
            ]);

            $data = \GuzzleHttp\json_decode($response->getBody()->getContents());
            if ($data->success == true) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => $data->message]);
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function UpdateRoleAndPermission(CreateUserRole $request)
    {
        try {
            $data = $request->except(['_token']);
            $response = $this->helper->PostRequest($this->api_client, 'api/user/create/permissions', 
                $data, 
                [
                    'token'     => Session::get('token')
                ]
            );

            if ($response->success == true) {
                return redirect()->back()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Update Role Permission Successful.'
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

    public function CancelCreateRole()
    {
        Session::forget('role');

        return redirect()->back();
    }

    private function session_getorthrow($session_name)
    {
        if (Session::has($session_name)) {
            return Session::get($session_name);
        }
        throw new Exception($session_name . ' is not exist.');
    }

    public function agent_role_page_index(Request $request)
    {
        return view('RoleManagement.agent.index');
    }

    public function objectData_agent_role(Request $request)
    {
        try {

            $request->request->add([
                'bank_code'     => $this->BANK_CODE ?? $request->agent,
            ]);

            $response = $this->api_client->post('api/user/get/roles/objectData/agent', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            return response()->json($data_response->object ?? null);

        } catch (\Exception $e) {

            report($e);
            return response()->json(null);

        }
    }

    public function corporate_role_page_index(Request $request)
    {
        return view('RoleManagement.corporate.index');
    }

    public function objectData_corporate_role(Request $request)
    {
        try {
            $request->request->add([
                'bank_id'       => $this->BANK_CURRENT,
                'corporate_id'  => $this->CORP_CURRENT,
                'corp_code'     => $this->CORP_CODE ?? $request->corporate,
            ]);

            $response = $this->api_client->post('api/user/get/roles/objectData/corporate', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            return response()->json($data_response->object ?? null);

        } catch (\Exception $e) {

            report($e);
            return response()->json(null);

        }
    }
}
