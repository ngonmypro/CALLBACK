<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Validator;
use Yajra\Datatables\Datatables;

class RichMenuController extends Controller
{
    private $api_client;
    private $CORP_CURRENT;
    private $BANK_CURRENT;

    public function __construct()
    {   
        $this->helper       = parent::Helper();
        $this->api_client   = parent::APIClient();
        $this->CORP_CURRENT = isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->BANK_CURRENT = isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : '';
    }

    public function index()
    {
        try {
            

            return view('Line.Richmenu.index');
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function create()
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, '/api/line2/get_app_list', [
                            'corporate_id'      => $this->CORP_CURRENT
                        ]);

            $data = NULL;

            if($response->success) {
                $data = $response->data;
            }

            return view('Line.Richmenu.create',compact('data'));
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function post_create(Request $request)
    {
        try {
            $request->richmenu_default = $request->has('richmenu_default') ? true : false;

            $response = $this->helper->PostRequest($this->api_client, '/api/line/richmenu/create', [
                            'corporate_id'          => $this->CORP_CURRENT,
                            'image'                 => $request->img_base64,
                            'config'                => $request->config,
                            'file_type'             => $request->file_type,
                            'line_app_code'         => $request->line_app_code,
                            'richmenu_name'         => $request->richmenu_name,
                            'richmenu_desc'         => $request->richmenu_desc,
                            'richmenu_default_app'  => $request->richmenu_default_app,
                            'richmenu_default_auth' => $request->richmenu_default_auth
                        ]);

            return  response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update($reference)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, '/api/line/richmenu/detail', [
                            'corporate_id'      => $this->CORP_CURRENT,
                            'reference'         => $reference,
                        ]);

            if($response) {
                $data = $response->data;

                return view('Line.Richmenu.detail',compact('data'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'Oops.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function post_update($reference,Request $request)
    {
        try {
            $request->richmenu_status   = $request->has('richmenu_status') ? 'ACTIVE' : 'INACTIVE';
            $request->richmenu_default  = $request->has('richmenu_default') ? true : false;

            $response = $this->helper->PostRequest($this->api_client, '/api/line/richmenu/update_detail', [
                            'corporate_id'      => $this->CORP_CURRENT,
                            'reference'         => $reference,
                            'config'            => $request->config,
                            'status'            => $request->richmenu_status,
                            'richmenu_name'     => $request->richmenu_name,
                            'richmenu_desc'     => $request->richmenu_desc,
                            'richmenu_default_app'  => $request->richmenu_default_app,
                            'richmenu_default_auth' => $request->richmenu_default_auth
                        ]);

            if($response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update complete.');
                return redirect()->back()->withInput();
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', 'Oops.');
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

            $response = $this->api_client->post('api/line/richmenu/objectData', [
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

}
