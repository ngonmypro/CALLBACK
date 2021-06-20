<?php

namespace App\Http\Controllers\Bill;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\SimpleCreateBillRequest;
use Illuminate\Support\Facades\Validator;

class SimpleCreateController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->client 			    = parent::APIClient();
        $this->CORP_CURRENT			= Session::get('CORP_CURRENT')['id']        ?? null;
        $this->CORP_CODE			= Session::get('CORP_CURRENT')['corp_code'] ?? null;
        $this->BANK_CURRENT			= Session::get('BANK_CURRENT')['id']        ?? null;
    }

    public function createNoCorporate(Request $request)
    {
        return $this->create($request, $this->CORP_CODE);
    }

    public function create(Request $request, $corporate_code)
    {
        try {
            $data = new \stdClass();
            $data->corp_code = $this->CORP_CODE;
            $data->corp_current = $this->CORP_CURRENT;

            $payment_channel = Session::get('payment_recurring');
            return view( 'Bill.simple.create', compact('data', 'payment_channel'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->withInput()->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function createSubmit(Request $request, $corporate_code)
    {
        $validator = Validator::make(
            $request->all(), 
            (new \App\Http\Requests\SimpleCreateBillRequest)->rules()
        );
        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            $request->request->add([
                'corporate_id'      => $this->CORP_CURRENT,
                'bank_id'           => $this->BANK_CURRENT
            ]);

            $response = $this->helper->PostRequest($this->client, 'api/bill/create-simple', $request->all());

            if ( $response->success ) {
                return redirect()->action('Bill\UploadController@index')->withInput()->with([
                    'alert-class'  => 'alert-success',
                    'message'      => 'Create bill is Successful.'
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

}
