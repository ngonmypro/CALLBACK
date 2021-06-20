<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use File;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class AppManageController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
    }

    public function index()
    {
        return view('AppManage.index');
    }

    public function objectData(Request $request)
    {
        $func = 'objectData';
        try {
            $response = $this->api_client->post('api/system/app/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());
            Log::debug('datable: '.json_encode($data_response));

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            Log::error("[{$func}] Error: {$e->getMessage()},".PHP_EOL."Stacktrace:".PHP_EOL."{$e->getTraceAsString()}");
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
