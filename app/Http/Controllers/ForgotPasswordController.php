<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;

use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->api_client 			= parent::APIClient();
    }

    public function index(Request $request)
    {
        return view('forgot_password.index');
    }

    public function submit(ForgotPasswordRequest $request)
    {
        $response = $this->helper->PostRequest($this->api_client, 'user/forgot-password', [
            'email'     => $request->email
        ]);

        if ( $response->success ?? false ) {  
            return redirect()->action('AuthController@index')->with('throw_success', $response->message ?? '');
        } else {
            return redirect()->back()->with('throw_detail', $response->message ?? '');
        }
    }

    public function recaptcha(Request $request)
    {
        return response()->json([
            'success'   => true
        ]);
    }
}
