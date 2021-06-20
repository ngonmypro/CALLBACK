<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ActivatePassword;
use Exception;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
    }

    public function index(Request $request)
    {
        if (!blank(Session::get('token'))) {
            return redirect('home');
        }
        return view('auth/login');
    }

    public function postLogin(LoginRequest $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');

            $response = $this->helper->PostRequest($this->api_client, 'oauth2/token', [
                'grant_type'            => 'password',
                'client_id'             => env('CLIENT_ID'),
                'client_secret'         => env('CLIENT_SECRET'),
                'username'              => $request->username,
                'password'              => $request->password
            ]);

            if (isset($response->access_token)) {
                $token = $response->access_token;

                Session::put('token', $response->access_token);
                Session::put('refresh_token', $response->refresh_token);

                $userdetail = null;
                $response = $this->helper->PostRequest($this->api_client, 'api/user/detail', null, [
                    'Authorization' => 'Bearer '.$token
                ]);
                if ($response->success === true) {
                    $userdetail = $response->user;
                    Session::put('user_detail', $response->user);
                    Session::put('locale', strtolower($response->user->localize));

                    if ($userdetail->user_type === 'USER' || $userdetail->user_type === 'AGENT') {
                        Session::put('user_list', $response->user);
                    }
                } else {
                    throw new Exception('invalid user');
                }

                $response = $this->helper->PostRequest($this->api_client, 'api/auth/permission', null, [
                    'Authorization' => 'Bearer '.$token
                ]);

                if ( $response->success ) {
                    Session::put('permission', $response->permission);
                } else {
                    throw new Exception('invalid user');
                }

                if ($userdetail->user_type === 'USER' || $userdetail->user_type === 'AGENT') {
                    $user_response = $this->helper->PostRequest($this->api_client, 'api/user/get_corporate/bank', null, [
                        'Authorization' => 'Bearer '.$token
                    ]);

                    if ( !$user_response->success ) {
                        Log::error('Failed to Retrieving data for Authorization');
                        throw new Exception('Authentication Failed');
                    }
            
                    if ( $userdetail->user_type === 'USER') {
                        $corp_list = $this->SetDelegateId($user_response->data->corporate);
                        $bank = $this->SetDelegateId($user_response->data->bank_profile);
                        Session::put('CORP_LIST', $corp_list);
                        Session::put('CORP_CURRENT', $corp_list[0] ?? null);
                        Session::put('BANK_CURRENT', $bank[0] ?? null);
                    } else if ( $userdetail->user_type === 'AGENT') {
                        if ( isset($user_response->data) ) {
                            $bank = $this->SetDelegateId($user_response->data);
                            Session::put('BANK_CURRENT', $bank[0] ?? null);
                        }
                    }
                    Session::put('payment_recurring', $user_response->payment_ch ?? null);
                }
            } else {
                Session::put('throw_detail', $response->message);
                return redirect()->back()->withInput();
            }

            return redirect('/');
        } catch (Exception $e) {
            report($e);

            $request->session()->invalidate();
            $this->CacheClear();

            Session::put('throw_detail', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function LogOut(Request $request)
    {
        $func = __FUNCTION__;
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/auth/logout', null);

            if (isset($response->success) && !$response->success) {

                Log::error("[{$func}] Error: {$response->message}");

            } else if ( $response->redirect_to ?? false) {

                Log::info("[Logout] Redirect: {$response->redirect_to}");
                return redirect( $response->redirect_to );

            }

        } catch (Exception $e) {
            report($e);
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        
        $request->session()->invalidate();
        $this->CacheClear();

        return redirect('/');
    }

    public function GetCorporateList()
    {
        $response = $this->helper->post($this->api_client, 'api/user/get_corporate', [
            'headers' => ['token' => Session::get('token')]
        ]);
        $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if ( $result->success ) {
            return $this->SetDelegateId($result->data);
        } else {
            return null;
        }
    }

    public function CacheClear()
    {
        $CORP_CODE = isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
        Cache::forget($CORP_CODE.'_dashboard_data');
        Cache::flush();
    }

    protected function get_token_data($token)
    {
        list($header, $body, $signature) = explode(".", $token);
        $decoded = base64_decode($body);
        
        return \json_decode($decoded);
    }

    protected function SetDelegateId($arr)
    {
        $temp = json_decode(json_encode($arr), true);
        foreach ($temp as &$item) {
            $item['refid'] = str_replace('-', '', (string)Str::uuid());
            // Log::info('LOG: '.json_encode($item));
        }

        // Log::info('Login '.\json_encode($item));

        return $temp;
    }

    public function UserActivatePage(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'code'       => 'required|max:50',
            'ref'        => 'required_without:amp;ref|max:50',
            'amp;ref'    => 'required_without:ref|max:50'
        ]);

        $code   = $request->input('code');
        $ref    = $request->input('ref');
        if ($ref === null) {
            $ref    = $request->input('amp;ref');
        }

        if ($validator->fails()) {
            Log::warning('validation failed');
            abort(404);
        } else {
            $response = $this->api_client->post('user/activation/token'.'?ref='.$ref.'&code='.$code);
            $result = json_decode($response->getBody()->getContents());

            if ($result->success == true) {
                $reference = $result->reference;
                $required_otp = $result->required_otp;
                return view('auth.Activation.SetPassword', compact('reference', 'code', 'required_otp'));
            } else {
                $error = $result->message;
                return view('auth.Activation.Error', compact('error'));
            }
        }
    }

    public function UserActivate_GetOTP(Request $request)
    {
        $func = 'UserActivate_GetOTP';
        $response = null;

        $validator = \Validator::make($request->all(), [
            'code'       => 'required',
            'ref'        => 'required',
        ]);

        if ($validator->fails()) {
            Log::error("[{$func}] validation failed.");
            return response()->json([
                'success'           => false,
                'message'           => 'validation failed.'
            ]);
        } else {
            $response = $this->helper->PostRequest($this->api_client, 'user/activation/getotp', [
                'user_code'         => $request->input('code'),
                'activate_code'     => $request->input('ref'),
            ]);
            Log::debug(json_encode($response));

            if ( $response->success ) {
                return response()->json([
                    'success'           => true,
                    'otp_reference'     => $response->otp_reference
                ]);
            }
        }

        return response()->json([
            'success'           => false,
            'message'           => isset($response->message) ? $response->message : ''
        ]);
    }

    public function UserActivateConfirm(ActivatePassword $request)
    {
        $func = __FUNCTION__;

        $response = $this->api_client->post('user/activation', [
            'json' => [
                'reference' => $request->input('ref'),
                'code'      => $request->input('code'),
                'password'  => $request->input('password'),
                'otp'       => $request->input('otp'),
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());

        if ( !$result->success ) {
            $code = isset($result->code) && !blank($result->code) ? " ({$result->code})" : '';
            $msg = $this->helper->getErrorMsg($code, $result->message);
            Log::error("[{$func}] error {$msg}");
            
            return redirect()->back()
                ->with('alert-class', 'alert-danger')
                ->with('message', $msg);
        }
        

        return view('auth.Activation.Successful');
    }
}
