<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use Carbon\Carbon;

class AuthToken extends Controller
{
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try
        {
            // AuthToken Middleware is Handle an incoming request.

            if ( blank( Session::get('token') ) ) {
                // Ending with session invalid and redirect to logout.
                return redirect('logout');
            }

            // token expired time
            $token = $this->get_token_data(Session::get('token'));
            // user last activity time
            $last_activity = !blank( Session::get('last_activity') ) 
                                ? date('Y-m-d H:i:s', strtotime(Session::get('last_activity')))
                                : '';

            $expWithIn = Session::get('expired_within');
            if ( blank( $expWithIn ) ) {
                $dt = Carbon::now();
                $exp = Carbon::createFromTimestamp($token->exp);
                $expWithIn = $dt->diffInMinutes($exp);
                if ( ($expWithIn - 1) >= 0 ) {
                    $expWithIn -= 1;
                }
                Session::put('expired_within', $expWithIn);
            } 
            
            // CHECK USER LAST ACTIVITY
            if ( blank( Session::get('last_activity') ) && !$request->ajax() ) {

                // last_activity was not set, update last activity time.
                Session::put( 'last_activity', date('Y-m-d H:i:s') );

            } else if ( $last_activity <= date('Y-m-d H:i:s', strtotime("-{$expWithIn} minutes")) ) {
                
                // User has no activity after a certain time, system not renew access token.
                if ( $request->ajax() ) {
                    // response unauthorized on ajax request.
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Unauthorized',
                        'code'      => '401'
                    ]);
                } else {
                    // redirect logout.
                    return redirect('logout');
                }

            } else {

                if (! $request->ajax() ) {
                    // update last activity time.
                    Session::put( 'last_activity', date('Y-m-d H:i:s') );
                }
                
            }

            // CHECK TOKEN EXPIRED TIME
            if ( date('Y-m-d H:i:s', $token->exp) > date('Y-m-d H:i:s', strtotime("+3 minutes")) ) {

                // these look like pretty good token, Passing to next middleware.
                return $next($request);

            } else {

                if (! $request->ajax() ) {
                    // trying to refresh an access token.
                    $result = $this->RefreshToken();
    
                    if ( isset($result->access_token) ) {
    
                        // put new token, put new refresh token
                        Session::put('token', $result->access_token);
                        Session::put('refresh_token', $result->refresh_token);
    
                        $this->LoginUpdate($result->access_token);
    
                        return $next($request);
                    } else {
                        Log::error('Error: refreshing fail, and passing to next middleware');
                    }
                } else {
                    // skip refreshing new token on ajax request.
                }

            }

            // Passing to next middleware.
            return $next($request);

        } catch(Exception $e) {
            report($e);
            return redirect('logout');
        }
    }
    
    protected function get_token_data($token)
    {
        list($header, $body, $signature) = explode('.', $token);
        $decoded = base64_decode($body);
        return json_decode($decoded);
    }

    public function RefreshToken()
    {
        try {
            return $this->helper->PostRequest($this->api_client, 'oauth2/token', [
                'grant_type'            => 'refresh_token',
                'client_id'             => env('CLIENT_ID'),
                'client_secret'         => env('CLIENT_SECRET'),
                'refresh_token'         => Session::get('refresh_token')
            ]);
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }

    public function LoginUpdate(string $token) : void
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/auth/login-update', null, [
                'Authorization'     => 'Bearer '.$token
            ]);
            if (isset($response->success) && !$response->success) {
                Log::error("[".__FUNCTION__."] Error: {$response->message}");
            }
        } catch (Exception $e) {
            report($e);
        }
    }

    public function ExceptionToken($response_exception)
    {
        $this->FlushToken();
        $error = isset($response_exception->error) ? $response_exception->error : '';

        Log::error('[ExceptionToken] Error: '.$error);
        Session::put('throw_detail', $error);

        return redirect('logout');
    }

    public function FlushToken()
    {   
        Session::forget('token');
        Session::forget('refresh_token');
        Session::forget('CORP_LIST');
        Session::forget('CORP_CURRENT');
        Session::forget('permission');
        Session::forget('throw_detail');
    }
}