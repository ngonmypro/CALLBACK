<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    private $api_client;

    public function __construct()
    {   
        $this->helper       = parent::Helper();
        $this->api_client   = parent::APIClient();
    }

    public function auth($app_code)
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/get_app', [
                'app_code'              => $app_code
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if($response->success) {

                $config = isset($response->data->config) ? json_decode($response->data->config) : NULL;

                if($config != NULL) {
                    if($config->theme == 'EIPP') {
                        return view('Line.App.EIPP.landing',compact('app_code','config'));
                    } else {
                        return view('Line.App.auth',compact('app_code','config'));
                    }
                } else {
                    echo "no config";
                }
            } else {
                echo "app not found";
            }
        } catch (\Exception $e) {

            print_r($e->getMessage());
            // Session::flash('alert-class', 'alert-danger');
            // Session::flash('message', $e->getMessage());
            // return redirect()->back()->withInput();
        }
    }

    public function post_inquiry($app_code,Request $request)
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/inquiry', [
                'app_code'              => $app_code,
                'recipient_reference'   => $request->recipient_reference,
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if($response->success) {
                return response()->json([
                    'success'   => true,
                    'code'      => '0000',
                    'data'      => $response->data
                ], 200);
            } else {
                return response()->json([
                    'success'   => false,
                    'code'      => '9999'
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

            return response()->json([
                    'success'   => false,
                    'code'      => '9999'
                ], 200);
        }
    }

    public function post_auth($app_code,Request $request)
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/auth', [
                'app_code'              => $app_code,
                'line_id'               => $request->line_id,
                'recipient_reference'   => $request->recipient_reference,
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if($response->success) {
                return response()->json([
                    'success'   => true,
                    'code'      => '0000'
                ], 200);
            } else {
                return response()->json([
                    'success'   => false,
                    'code'      => '9999'
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

            return response()->json([
                    'success'   => false,
                    'code'      => '9999'
                ], 200);
        }
    }

    public function recipient_profile(Request $request)
    {
        try {
            $this->validate($request, [
                'line_id'               => 'required'
            ]);

            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/get_recipient', [
                'line_id'               => $request->line_id
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if ($response->success) {
                $data = $response->data;
                
                return response()->json([
                    'success'   => true,
                    'data'      => [
                        'recipient_code' => $data->recipient_code
                    ]
                ], 200);
            } else {
                return response()->json([
                    'success'   => false,
                ], 200);
            }
        } catch (Exception $e) {
            Log::info(json_encode($e));

            return response()->json([
                'success'   => false
            ], 200);
        }
    }

    public function get_auth_token()
    {
        $auth = $this->helper->PostRequest($this->api_client, 'oauth2/token', [
            'grant_type'            => 'client_credentials',
            'client_id'             => env('VISA_VIRTUAL_CLIENT_ID'),
            'client_secret'         => env('VISA_VIRTUAL_CLIENT_SECRET'),
            'scope'                 => '*'
        ]);

        return $auth;
    }
}