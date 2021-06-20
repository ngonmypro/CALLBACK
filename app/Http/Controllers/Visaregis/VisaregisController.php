<?php

namespace App\Http\Controllers\Visaregis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthToken;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Http\Requests\SimpleCreateBillRequest;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\VisaregisCreate;


class VisaregisController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper(); 	
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE			= Session::get('CORP_CURRENT')['corp_code'] ?? null;
        $this->BANK_CURRENT			= Session::get('BANK_CURRENT')['id']        ?? null;
    }



    public function index()
    {
        return redirect('https://www.digio.co.th/meebill');
        // return view('Visaregis.index');
    }
    
    public function regis() 
    {
        return view('Visaregis.index');
    }

    public function create_success($code = '')
    {
        $item = [];
        $item['code'] = $code;
        $response = $this->helper->PostRequest($this->api_client, '/visaregis/create_success', $item);

        if ( $response->success ) {
            return view('Visaregis.success');

        }else
        {
            return redirect()->back()->withInput();
        }
    }

    

    public function create_submit(Request $request) //VisaregisCreate $request
    {

        $response = $this->helper->PostRequest($this->api_client, '/visaregis/create_submit', $request->all());

        if ( $response->success ) {
            $sheet_response = $this->helper->PostRequest($this->api_client, '/sheet_service', $response->data);
            Log::debug(json_encode($sheet_response));

            return redirect()->action('Visaregis\VisaregisController@create_success' , ['code' => $response->code])->withInput();
        } else {
            Log::error('request fail with error message: '. $response->message ?? '-');
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $response->message ?? ''
            ]);
        }
    }

    public function zipcode_address(Request $request)
    {
        try {
            $data = $this->helper->PostRequest($this->api_client, '/visaregis/zipcode_address', $request->all());

            if ($data->success == true) {
                return  response()->json([
                                        'success' => true,
                                        'items'   => $data->items
                                    ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());

            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }

    public function bank(Request $request)
    {
        try {
            $data = $this->helper->PostRequest($this->api_client, '/visaregis/bank', $request->all());

            if ($data->success == true) {
                return  response()->json([
                                        'success' => true,
                                        'items'   => $data->items
                                    ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());

            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }


 }
