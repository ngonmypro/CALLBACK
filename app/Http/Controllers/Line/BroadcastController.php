<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BroadcastController extends Controller
{
    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
    }


    public function index()
    {
        return view('Line.Broadcast.index');
    }

    public function create()
    {
        return view('Line.Broadcast.create');
    }

    public function detail($id)
    {
        try {
            $response = $this->api_client->post('api/broadcast/detail', [
                'form_params' => [
                    'corp_id'       =>  1,
                    'broadcast_id'  => $id
                ]
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            Log::info(json_encode($data_response));

            return view('Line.Broadcast.detail', compact('data_response'));
        } catch (\Exception $e) {
            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function objectData(Request $request)
    {
        try {
            $response = $this->api_client->post('api/broadcast/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            Log::info(json_encode($data_response));

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            // //Log::info('catch >>>> '.$e);
            // $response_exception = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());

            // if($response_exception->code == 99){
            //     return (new AuthToken())->ExceptionToken($response_exception);
            // }

            return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
        }
    }
}
