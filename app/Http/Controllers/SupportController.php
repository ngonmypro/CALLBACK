<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthToken;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Validator;
use Yajra\Datatables\Datatables;

class SupportController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				    = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->CORP_CODE			  = isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
    }
  
    public function search_bill()
    {
        return view('Support.Bill.search');
    }
    
    public function objectDataBill(Request $request)
    {
        try {
            $response = $this->api_client->post('api/support/objectDataBill', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            report($e);
          
            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }
    
    public function bill_detail($reference_code)
    {
        try {
            $data_response = $this->helper->PostRequest($this->api_client, 'api/support/bill/detail', [
                'reference_code' => $reference_code
            ]);

            if ($data_response->success) {
                $data = $data_response->data;

                return view('Support.Bill.detail', compact('data'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back();
            }
        } catch (\Exception $e) {
            report($e);
            
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back();
        }
    }
}
