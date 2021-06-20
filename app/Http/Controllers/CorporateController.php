<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\AuthToken;
use Exception;
use Illuminate\Support\Facades\Artisan;

use App\Http\Requests\CorporateGroupRequest;
use App\Http\Requests\CorporateProfileRequest;
use App\Http\Requests\CorporateCreate;
use App\Http\Requests\CorporateEdit;

class CorporateController extends Controller
{
    private $CORP_CURRENT;
    private $CORP_CODE;

    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->BANK_CURRENT         = Session::get('BANK_CURRENT')['id']        ?? null;
        $this->CORP_CURRENT         = Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE            = Session::get('CORP_CURRENT')['corp_code'] ?? null;
    }

    public function Index()
    {
        return view('Corporate.index');
    }

    public function objectData(Request $request)
    {
        try {
            $request['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->api_client->post('api/corporate/objectData', [
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

    public function SwitchCorporate(Request $request)
    {
        $func = __FUNCTION__;

        $this->validate($request, [
            'corp_ref'           => 'required',
        ]);

        try {
            if (Session::get('CORP_LIST') == null) {
                throw new Exception('an error occured due to system problem.');
            }

            $corp_ref = $request->input('corp_ref');
            if ($corp_ref == 'ALL') {
                Session::put('CORP_CURRENT', [
                    'refid'     => 'ALL',
                    'name'      => 'All Corporate',
                    'id'        => null,
                    'is_b2b'    => null,
                    'is_b2c'    => null
                ]);
            }
         
            $list = json_decode(json_encode(Session::get('CORP_LIST')), true);
            $result = array_filter($list, function ($d) use ($corp_ref) {
                return $d['refid'] == $corp_ref;
            });

            if (!$result && count($result) === 0) {
                throw new Exception('invalid input');
            } else {
                Session::put('CORP_CURRENT', head($result));
            }

        } catch (\Exception $ex) {
            report($ex);
            return redirect()->back()
                ->with('alert-class', 'alert-danger')
                ->with('message', $ex->getMessage());
        }
        return redirect('/');
    }

    public function ZipcodeAddress(Request $request)
    {
        try {
            $data = $this->helper->PostRequest($this->api_client, '/api/corporate/zipcode_address', $request->all());

            if ($data->success == true) {
                return  response()->json([
                                        'success' => true,
                                        'items'   => $data->items
                                    ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());

            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }

    public function CorporateCreate()
    {
        try {
            $corporate_group_list = [];

            $data = $this->helper->GetRequest($this->api_client, '/api/corporate/group/list');

            if ($data->success == true) {
                $data = $data->data[0];
                $corporate_group_list = $data->corp_group;
                $bank_owner = $data->bank_owner;
            }
            Session::put('corporate_group_list', $corporate_group_list);

            return view('Corporate.create', compact('corporate_group_list', 'bank_owner'));
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
    }

    public function CorporateCreatePost(CorporateCreate $request)
    {
        try {
            unset($request ['_token']);
            $req_branch['name_th']            = $request->is_new == "true"  ? $request->group_name_th : "";
            $req_branch['name_en']            = $request->is_new == "true"  ? $request->group_name_en : "";
            $req_branch['corporate_group_id'] = $request->is_new == "false" ? $request->corporate_group_id : "";

            $request['group'] = $req_branch;

            $request['corporate_id'] = $this->CORP_CURRENT;

            $data_response = $this->helper->PostRequest($this->api_client, 'api/corporate/create', $request->all());

            if ($data_response->success) {

                return redirect()->to('/Corporate')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);

            } else {

                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
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

    public function CorporateDetail($code)
    {
        try {
            $request['corporate_id'] = $this->CORP_CURRENT;

            $data_response = $this->helper->PostRequest($this->api_client, 'api/corporate/detail', [
                'corporate_code' => $code
            ]);

            if ($data_response->success) {
                $data = $data_response->data;

                // print_r($data);

                return view('Corporate.detail', compact('data'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
    }

    public function CorporateEdit($code)
    {
        try {
            $corporate_group_list = [];

            $data = $this->helper->GetRequest($this->api_client, '/api/corporate/group/list');

            if ($data->success == true) {
                $data = $data->data[0];
                $corporate_group_list = $data->corp_group;
                $bank_owner = $data->bank_owner;
            }

            $request['corporate_id'] = $this->CORP_CURRENT;

            $data_response = $this->helper->PostRequest($this->api_client, 'api/corporate/detail', [
                'corporate_code' => $code
            ]);

            if ($data_response->success) {
                $data = $data_response->data;

                return view('Corporate.edit', compact('data', 'corporate_group_list'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
    }

    public function CorporateEditPost(CorporateEdit $request)
    {
        try {
            $req_branch['name_th']            = $request->is_new == "true"  ? $request->group_name_th : "";
            $req_branch['name_en']            = $request->is_new == "true"  ? $request->group_name_en : "";
            $req_branch['corporate_group_id'] = $request->is_new == "false" ? $request->corporate_group_id : "";

            $request['group'] = $req_branch;

            $request['corporate_id'] = $this->CORP_CURRENT;

            $data_response = $this->helper->PostRequest($this->api_client, 'api/corporate/edit/'.$request->corp_code, $request->all());

            if ($data_response->success) {

                return redirect()->to('/Corporate')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $data_response->message
                ]);

            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $data_response->message
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
    
    public function ServiceException($exception)
    {
        $response_exception = \GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents());
        if ($response_exception->code == 99) {
            return (new AuthToken())->ExceptionToken($response_exception);
        } else {
            return null;
        }
    }

    public function select2_corporate(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/corporate/request/select2', [
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
    
    public function select2_textid(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/corporate/request/select2_texid', [
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

    public function select2_branch(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/corporate/request/select2_branch', [
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
}
