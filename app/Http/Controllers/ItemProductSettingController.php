<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Exception;
use File;
use Validator;

class ItemProductSettingController extends Controller
{
    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : 5;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
        $this->reportURL			= env('REPORT_URL');

    }

    public function index()
    {
        return view('ItemProduct.index');
    }

    public function objectData (Request $request)
    {
        try {
            $request->request->add(['corporate_id' => $this->CORP_CURRENT]);
            $response = $this->api_client->post('api/item/setting/objectData', [
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
            return DataTables::of([]);
        }
    }

    public function createItem ()
    {
        return view('ItemProduct.create');
    }

    public function itemDetail (Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/item/setting/get/item', [
                'reference_code'    => $request->reference,
                'corporate_id'      => $this->CORP_CURRENT
            ]);

            if($response->success) {
                return  response()->json([
                    'success'   => true,
                    'data'      => $response->data
                ]);
            }
            else {
                return  response()->json([
                    'success'   => false,
                    'message'   => $response->message
                ]);
            }
        }
        catch (\Exception $e) {
            report($e);
            return  response()->json([
                'success'   => true,
                'message'   => $response->message
            ]);
        }
    }

    public function manageItem (Request $request)
    {
        try {
            $this->validate($request, [
                "item_name"                 => ['required','max:150'],
                "item_code"                 => ['max:50'],
                "item_amount"               => ["required"],
            ]);

            $response = $this->helper->PostRequest($this->api_client, 'api/item/setting/manage_item', [
                'data'          => $request->except('_token'),
                'corporate_id'  => $this->CORP_CURRENT
            ]);

            if ( $response->success ) {
                return redirect()->action('ItemProductSettingController@index')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => $response->message ?? ''
                ]);
            } else {
                Log::error('request fail with error message: '. $response->message ?? '-');
                return redirect()->back()->withInput()->with([
                    'alert-class'  => 'alert-danger',
                    'message'      => $response->message ?? ''
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

    public function deleteItem (Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/item/setting/manage_item', [
                'data'          => $request->except('_token'),
                'corporate_id'  => $this->CORP_CURRENT
            ]);

            if ( $response->success ) {
                return  response()->json([
                    'success'   => true,
                    'data'      => $response->data
                ]);
            } else {
                return  response()->json([
                    'success'   => false,
                    'message'      => $response->message
                ]);
            }
        } catch (\Exception $e) {
            report($e);
            return  response()->json([
                'success'   => true,
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function Search (Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/item/setting/search', [
                'corporate_id'      => $this->CORP_CURRENT,
                'search'            => $request->search,
            ]);

            return response()->json([
                'items' => $response->data ?? null
            ]);

        } catch (\Exception $e) {
            report($e);

            return response()->json(null);
        }
    }

}
