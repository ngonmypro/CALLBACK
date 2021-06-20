<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Http\Controllers\Controller;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->client 			    = parent::APIClient();
        $this->CORP_CURRENT			= Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE			= Session::get('CORP_CURRENT')['corp_code'] ?? null;      
        $this->BANK_CURRENT			= Session::get('BANK_CURRENT')['id']        ?? null;
        $this->USER_DETAIL			= Session::get('user_detail');
    }

    public function inquiry_page(Request $request)
    {
        $func = __FUNCTION__;

        if ( !isset($this->USER_DETAIL->user_type) ) {
            Log::error("[{$func}] user type was not set.");
            return redirect()->to('/Exception/InternalError');
        }

        if ( $this->USER_DETAIL->user_type === 'AGENT' || $this->USER_DETAIL->user_type === 'SYSTEM' ) {

            return view('report.agent_portal.index');

        } else if ( $this->USER_DETAIL->user_type === 'USER') {
          
            return view('report.corp_portal.index');

        }

        return redirect()->to('/Exception/NotFound');
    }

    public function inquiry(Request $request)
    {
        $this->validate($request, [
            'report_type'       => 'required',
            'date_range'        => 'required_without_all:start_month,end_month',
            'start_month'       => 'required_without:date_range|lte:end_month|date_format:m/Y',  
            'end_month'         => 'required_without:date_range|gte:start_month|date_format:m/Y',  
            'criteria'          => 'required|in:daily,monthly'
        ]);

        if ( !isset($this->USER_DETAIL->user_type) ) {
            Log::error("[{$func}] user type was not set.");
            return redirect()->to('/Exception/InternalError');
        }

        $request->merge([
            'bank_id'           => $this->BANK_CURRENT,
            'corp_code'         => $this->CORP_CODE,
        ]);

        if ( $this->USER_DETAIL->user_type === 'AGENT' ) {

            $response = $this->helper->PostRequest($this->client, 'api/reports/agent/request/inquiry', $request->all());
    
        } elseif ( $this->USER_DETAIL->user_type === 'USER' ) { 
            $response = $this->helper->PostRequest($this->client, 'api/reports/user/request/inquiry', $request->all());
        }

        if ( env('APP_DEBUG', false) ) {
            Log::debug('request: '.json_encode($request->all()));
            Log::debug('response: '.json_encode($response));
        }

        if ( !isset($response->files) ) {
            return response()->json([
                'success'       => false,
                'message'       => $response->message ?? 'Could not get result.'
            ]);
        }
        return response()->json([
            'success'       => true,
            'data'          => $response->files
        ]);
    }

    public function single_download(Request $request)
    {
        $func = __FUNCTION__;

        $this->validate($request, [
            'filename'          => 'required',
            'report_type'       => 'required',
        ]);

        if ( !isset($this->USER_DETAIL->user_type) ) {

            Log::error("[{$func}] user type was not set.");

            return redirect()->to('/Exception/InternalError');

        }
        
        if ( $this->USER_DETAIL->user_type === 'AGENT' ) {

            $response = $this->helper->PostRequest($this->client, 'api/reports/agent/request/download/get-file-url', [
                'bank_id'           => $this->BANK_CURRENT,
                'filename'          => $request->query('filename'),
                'report_type'       => $request->query('report_type'),
            ]);

        } else if ( $this->USER_DETAIL->user_type === 'USER' ) { 

            $response = $this->helper->PostRequest($this->client, 'api/reports/user/request/download/get-file-url', [
                'bank_id'           => $this->BANK_CURRENT,
                'filename'          => $request->query('filename'),
                'report_type'       => $request->query('report_type'),
                'corp_code'         =>  $this->CORP_CODE,
            ]);
        } 
        

        if (! isset($response->path) ) {
            echo 'Could not get result.';
        }

        return redirect()->to($response->path ?? '/Exception/NotFound');
    }
}
