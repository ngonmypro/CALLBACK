<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
    }

    public function corporate()
    {
        $data = [
            'report'    => 'CORPORATE'
        ];
        return view('report.download.index', compact('data'));
    }

    public function bill_payment()
    {
        $data = [
            'report'    => 'BILL'
        ];
        return view('report.download.index', compact('data'));
    }

    public function payment_transaction()
    {
        $data = [
            'report'    => 'PAYMENT'
        ];
        return view('report.download.index', compact('data'));
    }

    public function get_list(Request $request)
    {
        $request->request->add([
            'accepts'      => ['CORPORATE', 'PAYMENT', 'BILL']
        ]);
        $this->validate($request, [
            'report'                 => 'required|in_array:accepts.*',
        ]);

        $service = '';
        if ( $request->report === 'CORPORATE' ) {

            $service = env('REPORT_URL').'/api/report/directory/corporate';

        } else if ( $request->report === 'PAYMENT' ) {

            $this->validate($request, [
                'corporate'              => 'required'
            ]);
            $service = env('REPORT_URL').'/api/report/directory/payment';

        } else if ( $request->report === 'BILL' ) {

            $this->validate($request, [
                'corporate'              => 'required'
            ]);
            $service = env('REPORT_URL').'/api/report/directory/bill';

        }

        $response = $this->helper->PostRequest($this->api_client, $service, [
            'corp_code'         => $this->CORP_CODE ?? $request->corporate,
            'bank_id'           => $this->BANK_CURRENT
        ]);

        if ( env('APP_DEBUG', false) ) {
            Log::debug('response: '.json_encode($response));
        }

        if ( !isset($response->data->files) ) {
            return response()->json([
                'success'       => false,
                'message'       => $response->message ?? 'Could not get result.'
            ]);
        }

        return response()->json([
            'success'       => true,
            'data'          => $response->data->files
        ]);
    }

    public function search_corporate(Request $request)
    {
        $response = $this->helper->PostRequest($this->api_client, env('REPORT_URL').'/api/report/directory/request/corporates', [
            'corp_code'         => $this->CORP_CODE ?? $request->corporate,
            'corporate_id'      => $this->CORP_CURRENT,
            'bank_id'           => $this->BANK_CURRENT,
            'search'            => $request->search
        ]);

        if ( env('APP_DEBUG', false) ) {
            Log::debug('response: '.json_encode($response));
        }

        if ( !isset($response->data) ) {
            return response()->json([
                'success'       => false,
                'message'       => $response->message ?? 'Could not get result.'
            ]);
        }

        return response()->json([
            'success'       => true,
            'data'          => $response->data
        ]);
    }

    public function download(Request $request)
    {
        $request->request->add([
            'accepts'      => ['CORPORATE', 'PAYMENT', 'BILL']
        ]);
        $this->validate($request, [
            'report'                 => 'required|in_array:accepts.*'
        ]);

        $service = '';
        if ( $request->report === 'CORPORATE' ) {

            $service = env('REPORT_URL').'/api/report/directory/corporate/download';

        } else if ( $request->report === 'PAYMENT' ) {

            $this->validate($request, [
                'corporate'              => 'required'
            ]);
            $service = env('REPORT_URL').'/api/report/directory/payment/download';

        } else if ( $request->report === 'BILL' ) {

            $this->validate($request, [
                'corporate'              => 'required'
            ]);
            $service = env('REPORT_URL').'/api/report/directory/bill/download';

        }

        $response = $this->helper->PostRequest($this->api_client, $service, [
            'corp_code'         => $this->CORP_CODE ?? $request->corporate,
            'bank_id'           => $this->BANK_CURRENT,
            'filename'          => $request->filename
        ]);

        if (isset($response->url)) {

            $decoded = file_get_contents($response->url);
            $response = \Response::make($decoded);
            $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')->header('Content-Disposition', 'inline');
            return $response;

        } else if (isset($response->data)) {

            $decoded = base64_decode($response->data);
            $response = \Response::make($decoded);
            $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')->header('Content-Disposition', 'inline');
            return $response;

        } else {
            $msg = $response->message ?? '';
            Log::error("[".__FUNCTION__."] Error: requesting to download report, but response failed url: {$service}, message: {$msg}");
            return abort(400);
        }
        
    }
}
