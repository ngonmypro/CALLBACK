<?php

namespace App\Http\Controllers\Bill;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LogsController extends Controller
{
    private $client;
    private $CORP_CURRENT;
    private $CORP_CODE;
    private $BANK_CURRENT;

    public function __construct()
    {   
        $this->helper               = parent::Helper();
        $this->client               = parent::APIClient();
        $this->PAYMENT_URL          = env('PAYMENT_URL');
        $this->BANK_CURRENT         = Session::get('BANK_CURRENT')['id']        ?? null;
        $this->CORP_CURRENT         = Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE            = Session::get('CORP_CURRENT')['corp_code'] ?? null;
    }

    public function index(Request $request)
    {
        $data = null;
        return view('Bill.logs.index', compact('data'));
    }

    public function objectData(Request $request)
    {
        try {    

            $request->request->add([
                'corporate_id' => $this->CORP_CURRENT,
                'bank_id'      => $this->BANK_CURRENT,
            ]);

            $response = $this->helper->PostRequest($this->client, 'api/bill/logs/objectData', 
                $request->all()
            );

            return response()->json($response->object ?? null);

        } catch (\Exception $e) {

            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }
}
