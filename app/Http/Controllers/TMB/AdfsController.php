<?php

namespace App\Http\Controllers\TMB;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class AdfsController extends Controller
{
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
    }

    public function index(Request $request)
    {
        return redirect()->action('AuthController@index');
    }

    public function login(Request $request)
    {
        Log::debug('REQUEST_LOGIN', $request->all());
        $this->validate($request, [
            'SAMLResponse'              => 'required'
        ]);

        $array = $this->parseXML( $request->SAMLResponse );

        Log::debug('Login: Decode SAML Response', $array);

        $data = [
            'user'              => $this->getUserInfo($array),
            'roles'             => $this->getRoles($array),
            'issuer'            => $array['Issuer'] ?? null,
            'service_id'        => $request->getRequestUri()
        ];
        $data = array_merge($data, [
            'username'              => $array['Assertion']['Subject']['NameID'] ?? null,
            'client_id'             => env('CLIENT_ID')
        ]);
        Log::debug('Login: request', $data);

        if ( blank($data['roles'] ?? null) ) {
            return view('auth.error')->with([
                'error' => 'requesting to access to the system but user role was not found.'
            ]);
        }

        $response = $this->helper->PostRequest($this->api_client, 'auth/tmb/adfs', $data);

        if ( $response->access_token ?? false ) {

            Session::put('token', $response->access_token);
            Session::put('refresh_token', $response->refresh_token);

            try {
                $this->postLogin();
            } catch (Exception $e) {
                report($e);

                return view('auth.error')->with([
                    'error' => 'something goes wrong.'
                ]);
            }

        } else {

            Log::error('Login: error '. $response->message ?? 'empty message');
            return view('auth.error')->with([
                'error' => $response->message ?? 'something goes wrong.'
            ]);

        }

        return redirect()->to('/');
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'SAMLRequest'              => 'required'
        ]);

        Log::debug('REQUEST_LOGOUT', $request->all());

        $array = $this->parseXML( $request->SAMLRequest );

        try {
            $response = $this->helper->PostRequest($this->api_client, 'auth/tmb/adfs/logout', [
                'username'              => $array['NameID'] ?? null,
            ]);
            Log::debug('Logout ADFS Response: '. json_encode($response));

            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            $request->session()->invalidate();

        } catch (\Exception $e) {
            report($e);
        }
        
        return redirect()->to('/');
    }

    public function parseXML($base64_xml)
    {
        $xml = simplexml_load_string( base64_decode($base64_xml) );

        $json = json_encode($xml);

        $array = json_decode($json, true);

        return $array;
    }

    public function postLogin()
    {
        $token = Session::get('token');

        $response = $this->helper->PostRequest($this->api_client, 'api/user/detail', null, [
            'Authorization' => 'Bearer '.$token
        ]);

        if ( $response->success && $userdetail = $response->user ) {
            Log::info('Request to get user detail: SUCCESS');
            Session::put('user_detail', $userdetail);
            Session::put('locale', strtolower($userdetail->localize));

            if ( in_array($userdetail->user_type, ['USER', 'AGENT']) ) {
                Session::put('user_list', $response->user);
            }

        } else {
            Log::error('[ERROR] could not retreive user detail.');
            throw new Exception('invalid user');
        }

        $response = $this->helper->PostRequest($this->api_client, 'api/auth/permission', null, [
            'Authorization' => 'Bearer '.$token
        ]);

        if ( $response->success ) {

            Log::info('login: request to get user permissions: SUCCESS');
            Session::put('permission', $response->permission);

        } else {

            Log::error('[ERROR] could not retreive user permissions.');
            throw new Exception('invalid user');
        }

        if ( in_array($userdetail->user_type, ['USER', 'AGENT']) ) {

            $response = $this->helper->PostRequest($this->api_client, 'api/user/get_corporate/bank', null, [
                'Authorization' => 'Bearer '.$token
            ]);

            if ( !$response->success ) {

                Log::error('[ERROR] failed to request get associate bank/corporate.');

            } else {

                Log::info('login: request to get associate bank/corporate: SUCCESS');

            }

            if ( $userdetail->user_type === 'USER' ) {

                $bank = $this->SetDelegateId($response->data->bank_profile);
                        
                $corp_list = $this->SetDelegateId($response->data->corporate);
                if ( $corp_list ) {
                    Session::put('CORP_LIST', $corp_list);
                    Session::put('CORP_CURRENT', $corp_list[0] ?? null);
                    Session::put('BANK_CURRENT', $bank[0] ?? null);
                }

            } else if ( $userdetail->user_type === 'AGENT' ) {
                
                $bank = $this->SetDelegateId($response->data);
                Session::put('BANK_CURRENT', $bank[0] ?? null);

            }
        } else {
            // OTHER USER TYPE
        }

        // END
    }

    protected function SetDelegateId($arr)
    {
        $temp = json_decode(json_encode($arr), true);
        foreach ($temp as &$item) {
            $item['refid'] = Str::uuid();
        }
        return $temp;
    }

    protected function getRoles(array $samlRequest)
    {
        $roles = [];
        $attribute = $samlRequest['Assertion']['AttributeStatement']['Attribute'] ?? null;

        if ( isset($attribute['@attributes']) && $attribute['@attributes']['Name'] === 'memberOf' ) {
            $roles = array_values($attribute['AttributeValue']);

        } else {
            foreach ( $attribute as $key => $value ) {
                if ( isset($value['@attributes']['Name']) && $value['@attributes']['Name'] === 'memberOf' ) {
                    $roles = array_values($value['AttributeValue'] ?? []);
                }
            } 
        }

        return $roles;
    }

    protected function getUserInfo(array $samlRequest)
    {
        $userInfo = [
            'givenname'     => null,
            'surname'       => null,
            'emailaddress'  => null,
        ];
        $attribute = $samlRequest['Assertion']['AttributeStatement']['Attribute'] ?? null;

        if ( is_array($attribute) ) {
            foreach ( $attribute as $key => $value ) {
                if ( isset($value['@attributes']['Name']) && $value['@attributes']['Name'] === 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress' ) {
                    $userInfo['emailaddress'] = $value['AttributeValue'] ?? null;
                }
                if ( isset($value['@attributes']['Name']) && $value['@attributes']['Name'] === 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/surname' ) {
                    $userInfo['surname'] = $value['AttributeValue'] ?? null;
                }
                if ( isset($value['@attributes']['Name']) && $value['@attributes']['Name'] === 'http://schemas.xmlsoap.org/ws/2005/05/identity/claims/givenname' ) {
                    $userInfo['givenname'] = $value['AttributeValue'] ?? null;
                }
            } 
        }

        return $userInfo;
    }
}
