<?php

namespace App\Http\Controllers\Visa;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthToken;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Validator;
use Yajra\Datatables\Datatables;

class VirtualCardController extends Controller
{
    private $api_client;
    private $CORP_CURRENT;
    private $virtual_card_url;

    public function __construct()
    {   
        $this->helper           = parent::Helper();
        $this->api_client       = parent::APIClient();
        $this->CORP_CURRENT     = isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->virtual_card_url = env('VIRTUAL_CARD_URL','');
    }

    public function index()
    {
        try {

            return view('Visa.VirtualCard.index');
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function setting()
    {
        try {
            $card_type = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/card_type_list', []);

            $data = $card_type != NULL ? $card_type->data : NULL;

            return view('Visa.VirtualCard.setting',compact('data'));
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function add_card_type()
    {
        try {
            $rules = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/rules', []);

            
            if ($rules->success) {
                $data = $rules->data;

                return view('Visa.VirtualCard.card_type',compact('data'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', "ไม่พบข้อมูล");

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function request($reference_code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/request_detail', [
                'reference_code'    => $reference_code
            ]);

            if ($response->success) {
                $data = $response->data;

                $get_type = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/get_type', ['reference_code'=>$data->card_type]);

                $countries  = Storage::disk('local')->exists('json_data/country_names.json') ? json_decode(Storage::disk('local')->get('json_data/country_names.json')) : NULL;
                $currencies = Storage::disk('local')->exists('json_data/country_currency.json') ? json_decode(Storage::disk('local')->get('json_data/country_currency.json')) : NULL;

                $type = $get_type->success ? $get_type->data : NULL;

                return view('Visa.VirtualCard.request',compact('data','countries','currencies','type'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', "ไม่พบข้อมูล");

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function post_card_type(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/card_type', $request->all());

            if($response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', "success");

                return redirect()->to('Visa/VirtualCard/setting');
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', "ไม่พบข้อมูล");

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function post_request(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/request', $request->all());

            if($response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', "success");

                return redirect()->back()->withInput();
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', "ไม่พบข้อมูล");

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function objectData(Request $request)
    {
        try {
            $request->request->add(['corporate_id' => $this->CORP_CURRENT]);

            $response = $this->api_client->post($this->virtual_card_url.'/api/v1/virtual_card/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if (!!$data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function visa_transaction()
    {
        try {
            return view('Visa.VirtualCard.transaction');
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function object_transaction(Request $request)
    {
       try {
           $request->request->add(['corporate_id' => $this->CORP_CURRENT]);

            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }
         
           $response = $this->api_client->post($this->virtual_card_url.'/api/v1/virtual_card/object_transaction', [
               'form_params' => $request->all()
           ]);

           $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

           if (!!$data_response->success) {
               return response()->json($data_response->object);
           } else {
               return response()->json(null);
           }
       } catch (\Exception $e) {
           Log::error("[".__FUNCTION__."] Error: {$e->getMessage()},\nStacktrace:\n{$e->getTraceAsString()}");

           return  response()->json([
               'success' => false,
               'message' => $e->getMessage()
           ]);
       }
    }

    public function post_perform(Request $request)
    {
        try {

            if ( !blank($request->daterange) ) {
                $e = explode('-', $request->daterange);
                $start_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[0]))));
                $end_date   = date('Y-m-d', strtotime(str_replace("/", "-", trim($e[1]))));

                $request['start_date']  = $start_date;
                $request['end_date']    = $end_date;
            }

            $response = $this->helper->PostRequest($this->api_client, $this->virtual_card_url.'/api/v1/virtual_card/post_perform', $request->all());

            if($response->success) {

                return response()->json($response->object);

                return redirect()->back()->withInput();
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }
    
}
