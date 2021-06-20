<?php

namespace App\Http\Controllers\Loan;

use Redirect;
use GuzzleHttp;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class CreditScoreController extends Controller
{
    protected $helper;
    protected $client;

    public function __construct()
    {
        $this->client 			= parent::APIClient();
        $this->helper				= parent::Helper();

        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
    }

    public function objectData(Request $request, $id)
    {
        try {
            $request->request->add([
                'corp_code'         => $this->CORP_CODE,
                'corporate_id'      => $this->CORP_CURRENT,
                'recipient_code'    => $id,
            ]);

            $response = $this->client->post("api/loan/credit-score/{$id}/objectData", [
                'form_params' => $request->all()
            ]);

            $json = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ( $json->success ) {
                return response()->json($json->object);
            } else {
                return response()->json(null);
            }

        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function add(Request $request, $id)
    {
        try {

            $this->validate($request, [
                'credit'                    => 'required|numeric'
            ]);

            $response = $this->helper->PostRequest($this->client, "api/loan/credit-score/{$id}/add", [
                'corp_code'         => $this->CORP_CODE,
                'corporate_id'      => $this->CORP_CURRENT,
                'credit'            => $request->credit,
                'remark'            => $request->remark,
            ]);

            if ( $response->success ) {
                return response()->json($response);
            } else {
                throw new Exception($response->message ?? '', $response->code ?? 0);
            }

        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
