<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use \Exception;

class FunctionController extends Controller
{
  
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper           = parent::Helper();
    }
  
    public function index()
    {
        return view('Function.index');
    }
    
    public function objectData(Request $request)
    {
        try {
            $data_response = $this->helper->PostRequest($this->api_client, 'api/function/objectData',
                $request->except('_token')
            );
            
            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch(\Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function create()
    {
        $response = $this->helper->PostRequest($this->api_client, 'api/function/get_app',
            null
        );
        
        $apps = $response->data;
      
        return view('Function.create', compact('apps'));
    }
    
    public function create_save(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/function/create',
                $request->except('_token')
            );
            
            if ($response->success == true) {
                return redirect('/Function')->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Create Function Successfully.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    
    public function get_permission(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/function/permission_list', 
                $request->except('_token')
            );

            if ($response->success) {
                return response()->json([
                    'success'       => true,
                    'data'          => $response->data
                ]);
            } else {
                return response()->json([
                    'success'           => false,
                    'message'           => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            
            return response()->json([
                'success'           => false,
                'message'           => $e->getMessage()
            ]);
        }
    }
    
    public function edit($function_code)
    {
        $role_permission = [];
        try 
        {    
            $response = $this->helper->PostRequest($this->api_client, 'api/function/detail', [
                'function_code' => $function_code
            ]);
            
            if ($response->success == true) {
                $data = json_decode(json_encode($response->data), true);
                
                return view('Function.edit', compact('data', 'function_code'));
            }
            else
            {
                throw new Exception($response->message);
            }

        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    
    public function edit_save(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/function/update',
                $request->except('_token')
            );
            
            if ($response->success == true) {
                return redirect('/Function/Edit/'.$request->function_code)->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Update Function Successfully.'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }
    
    public function get_function(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/function/get_function',
                $request->except('_token')
            );

            if ($response->success == true) {
                return response()->json([
                    'success'   =>  true,
                    'data'      =>  $response->data
                ]);
            } else {
                return response()->json([
                    'success'       => false,
                    'message'       => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success'       => false,
                'message'       => $e->getMessage()
            ]);
        }
    }
    
}
