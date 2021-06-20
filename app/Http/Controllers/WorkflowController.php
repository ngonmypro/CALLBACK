<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class WorkflowController extends Controller
{
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
    }

    public function index()
    {
        return view('Setting.workflow.index');
    }

    public function GetWorkflowList(Request $request)
    {
        $corp = Session::get('CORP_CURRENT');
        Log::info('corp list '.\GuzzleHttp\json_encode($corp));
        try {
            $response = $this->api_client->post('/api/workflow/list', [
                'form_params' => [
                    'corp_id'               => $corp['id'],
                    'corporate_type'        => 'B2B'
                ]
            ]);

            $data_response  = \GuzzleHttp\json_decode($response->getBody());

            if ($data_response->success) {
//                Log::info('true '.json_encode($data_response->object));
                return response()->json($data_response->object);
            } else {
                return DataTables::of([]);
            }
        } catch (\Exception $ex) {
            $this->ServiceException($ex);
            Log::info('err '.$ex);
            return DataTables::of([]);
        }
    }

    public function createWorkflow()
    {
        $corp = Session::get('CORP_CURRENT');

        try {
            $response = $this->api_client->post('/api/get/workflow', [
                'form_params' => [
                    'corp_id'    => $corp['id']
                ]
            ]);
            $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($result->success == true) {
                $Service = $result->data->workflow;
                $User = $result->data->users;

                return view('Setting.workflow.create', compact('Service', 'User'));
            } else {
                Log::info($result->data);
                return redirect('/Exception/InternalError');
            }
        } catch (\Exception $ex) {
            $this->ServiceException($ex);
            Log::info('err '.$ex);
            return redirect('/Exception/InternalError');
        }
    }

    public function submitCreateWorkflow(Request $request)
    {
//        Log::info(\GuzzleHttp\json_encode($request->all()));

        $service_type = $request->service_type;
        $jobs = $request->job;
        $cur_corp = Session::get('CORP_CURRENT')['id'];

        try {
            $response = $this->api_client->post('/api/workflow/create/users', [
                'form_params' => [
                    'service_type'      => $service_type,
                    'user_workflow'     => $jobs,
                    'corporate_type'    => 'B2B',
                    'current_corporate' => $cur_corp
                ]
            ]);
            $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($result->success == true) {
                // Session::put('status_import', $result->message);
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Create users workflow is successful.');
                return response()->json(['success' => true, 'message' => $result->message]);
            } else {
                return response()->json(['success' => false, 'message' => $result->message]);
            }
        } catch (\Exception $ex) {
            $this->ServiceException($ex);
            Log::info('err '.$ex);
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }

    public function EditWorkflow($service_code)
    {
        $corp = Session::get('CORP_CURRENT');
        try {
            $response = $this->api_client->post('/api/workflow/edit', [
                'form_params' => [
                    'service_code'      => $service_code,
                    'current_corp_id'   => $corp['id'],
                    'corporate_type'    => 'B2B'
                ]
            ]);
            $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($result->success == true) {
                Log::info('result '.\GuzzleHttp\json_encode($result));
                $service = $result->data[0]->service;
                $jobs = $result->data[0]->job;
                $user_job = $result->data[0]->user_job;
                $all_user = $result->data[0]->all_user;

                return view('Setting.workflow.edit', compact('service', 'jobs', 'user_job', 'all_user'));
            } else {
                redirect('/Exception/InternalError');
            }
        } catch (\Exception $ex) {
            $this->ServiceException($ex);
            Log::info('err '.$ex);
            return redirect('/Exception/InternalError');
        }
    }

    public function submitEditWorkflow(Request $request)
    {
//        Log::info('request '.\GuzzleHttp\json_encode($request->all()));

        $service_type = $request->service_type;
        $jobs = $request->job;
        $cur_corp = Session::get('CORP_CURRENT')['id'];

        try {
            $response = $this->api_client->post('/api/workflow/edit/users', [
                'form_params' => [
                    'service_type'      => $service_type,
                    'user_workflow'     => $jobs,
                    'corporate_type'    => 'B2B',
                    'current_corporate' => $cur_corp
                ]
            ]);
            $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($result->success == true) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update users workflow is successful.');
                return response()->json(['success' => true, 'message' => $result->message]);
            } else {
                return response()->json(['success' => false, 'message' => $result->message]);
            }
//            return response()->json(['success' => true, 'message' => 'success']);
        } catch (\Exception $ex) {
            $this->ServiceException($ex);
            Log::info('err '.$ex);
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }

    public function ServiceException($exception)
    {
        //	    if($exception->getCode() == 0)
        //	    {
//            return redirect('/Exception/InternalError');
//        }
//        else
//        {
        $response_exception = \GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents());
        if ($response_exception->code == 99) {
            return (new AuthToken())->ExceptionToken($response_exception);
        } else {
            return null;
        }
//        }
    }
}
