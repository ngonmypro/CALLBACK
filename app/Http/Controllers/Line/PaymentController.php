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

class PaymentController extends Controller
{
    private $api_client;

    public function __construct()
    {   
        $this->helper       = parent::Helper();
        $this->api_client   = parent::APIClient();
    }

    public function payment($app_code)
    {
        try {
            $config = $this->get_app_config($app_code);    

            if($config != false) {
                if($config->theme == 'EIPP') {
                    return view('Line.App.EIPP.payment',compact('app_code','config'));
                } else {
                    // return view('Line.App.auth',compact('app_code','config'));
                }
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function payment_confirm($app_code,$bill_reference)
    {
        try {
            $config = $this->get_app_config($app_code);    

            if($config != false) {
                if($config->theme == 'EIPP') {
                    return view('Line.App.EIPP.payment_confirm',compact('app_code','config','bill_reference'));
                } else {
                    // return view('Line.App.auth',compact('app_code','config'));
                }
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            // return  response()->json([
            //         'success'   =>  false
            //     ], 200);
        }
    }

    public function payment_history($app_code)
    {
        try {
            $config = $this->get_app_config($app_code);    

            if($config != false) {
                if($config->theme == 'EIPP') {
                    return view('Line.App.EIPP.payment_history',compact('app_code','config'));
                } else {
                    // return view('Line.App.auth',compact('app_code','config'));
                }
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function post_payment($app_code)
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/bill_payment', [
                'app_code'              => $app_code,
                'line_id'               => 'Uc2e9817a1ee2ce934962b9b3636829e4'
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if($response->success) {
                return  response()->json([
                        'success'   =>  true,
                        'data'      =>  $response->data
                    ], 200);
            } else {
                return  response()->json([
                        'success'   =>  false
                    ], 200);
            }
        } catch (\Exception $e) {
            return  response()->json([
                        'success'   =>  false
                    ], 200);
        }
    }

    public function post_payment_confirm($app_code,$bill_reference)
    {
        try {
            $auth = $this->get_auth_token();
            
            $response = $this->helper->PostRequest($this->api_client, 'api/line2/payment/qr', [
                'app_code'              => $app_code,
                'bill_reference'        => $bill_reference,
                'line_id'               => 'Uc2e9817a1ee2ce934962b9b3636829e4'
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            Log::info(json_encode($response));

            if($response->success) {
                return  response()->json([
                        'success'   =>  true,
                        'data'      =>  $response->data
                    ], 200);
            } else {
                return  response()->json([
                        'success'   =>  false
                    ], 200);
            }
        } catch (\Exception $e) {
            return  response()->json([
                        'success'   =>  false
                    ], 200);
        }
    }

    public function post_payment_history($app_code)
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/line2/history', [
                'app_code'              => $app_code,
                'line_id'               => 'Uc2e9817a1ee2ce934962b9b3636829e4'
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            if($response->success) {
                return  response()->json([
                        'success'   =>  true,
                        'data'      =>  $response->data
                    ], 200);
            } else {
                return  response()->json([
                        'success'   =>  false
                    ], 200);
            }
        } catch (\Exception $e) {
            return  response()->json([
                        'success'   =>  false
                    ], 200);
        }
    }

    public function get_app_config($app_code)
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
                    return $config;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
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