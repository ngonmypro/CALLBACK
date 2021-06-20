<?php

namespace App\Http\Controllers\Loan;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Client;

class CustomerPortalController extends Controller
{
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client           = parent::APIClient();
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

    public function index()
    {
        try {
            $auth = $this->get_auth_token();

            $response = $this->helper->PostRequest($this->api_client, 'api/customer_loan/history', [
                'recipient_code'            => 'db1c1144b9c7bba777fc52e9f2c5c469'
            ],[
                'Authorization' =>  'Bearer '.$auth->access_token
            ]);

            // $response = $this->helper->PostRequest($this->api_client, 'api/customer_loan/history', [
            //                 'recipient_code'            => 'db1c1144b9c7bba777fc52e9f2c5c469'
            //             ],[
            //                 'Authorization' => 'Bearer '.$this->ClientAuthen()
            //             ]);

            // $data_response = json_decode($response->getBody()->getContents());
            // echo "<pre>";
            // print_r($response);

            if ($response->success) {
                $data = $response->data;

                return view('Loan.Customer.history', compact('data'));
            }
             // else {
            //     Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

            //     Session::flash('alert-class', 'alert-danger');
            //     Session::flash('message', "ไม่พบข้อมูล BILL");

            //     return redirect()->back()->withInput();
            // }
        } catch (\Exception $e) {

            print_r($e->getMessage());

            // Session::flash('alert-class', 'alert-danger');
            // Session::flash('message', $e->getMessage());

            // return redirect()->back()->withInput();
        }
    }

    public function ClientAuthen()
    {
        $response = $this->helper->PostRequest($this->api_client, 'oauth2/token', [
            'grant_type'    =>  'client_credentials',
            'client_id'     =>  env('CLIENT_ID'),
            'client_secret' =>  env('CLIENT_SECRET'),
            'scope'         =>  env('SCOPE')
        ]);
        
        if (isset($response->access_token)) {

            Log::debug('token: '.$response->access_token);
            return $response->access_token;

        } else {

            Log::error('Error client authenticate failed. message: '.isset($response->error) ? $response->error : 'empty message');
            throw new Exception('Error client authenticate failed. message: '.isset($response->error) ? $response->error : 'empty message');

        }
    }
}
