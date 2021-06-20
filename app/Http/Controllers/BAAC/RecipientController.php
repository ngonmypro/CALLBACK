<?php

namespace App\Http\Controllers\BAAC;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use File;
use Validator;

class RecipientController extends Controller
{
    private $api_client;
    private $CORP_CURRENT;
    private $virtual_card_url;

    public function __construct()
    {   
        $this->helper           = parent::Helper();
        $this->api_client       = parent::APIClient();
        $this->CORP_CURRENT     = isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
    }

    public function recipient_activity()
    {
        return view('BAAC.Recipient.activity');
    }
    
    public function activity_objectData(Request $request)
    {
        try {
            $request['corp_id']  = $this->CORP_CURRENT;
            
            if ($request->has('daterange') && !blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            
            $response = $this->api_client->post('api/BAAC/recipient/activity_objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function recipient_bookstate()
    {
        return view('BAAC.Recipient.bookstate');
    }
    
    public function bookstate_objectData(Request $request)
    {
        try {
            $request['corp_id']  = $this->CORP_CURRENT;
            
            if ($request->has('daterange') && !blank($request->daterange)) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
            
            $response = $this->api_client->post('api/BAAC/recipient/bookstate/objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function bookstate_tracking($code)
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/BAAC/recipient/bookstate/detail', [
            'code' => $code
        ]);
        
        $bookstate = $response->data;
      
        return view('BAAC.Recipient.tracking', compact('bookstate', 'code'));
    }
    
    public function tracking_objectData(Request $request)
    {
        try {
            $response = $this->api_client->post('api/BAAC/recipient/bookstate/tracking/objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
}
