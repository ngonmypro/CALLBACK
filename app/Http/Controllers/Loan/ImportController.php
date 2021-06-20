<?php

namespace App\Http\Controllers\Loan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use Redirect;
use GuzzleHttp;
use Exception;
use Validator;
use File;
use \PDF;
use App\Repositories\Loan\Softspace;
use App\Repositories\Loan\Flash;
use App\Http\Requests\LoanApplicationUpload;

class ImportController extends Controller
{
    private $helper;
    private $api_client;
    private $logger;

    private $CORP_CURRENT;
    private $CORP_CODE;

    public function __construct()
    {
        $this->api_client           = parent::APIClient();
        $this->helper               = parent::Helper();
        $this->logger               = parent::Logger();

        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : null;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null;
        $this->BANK_CURRENT			= isset(Session::get('BANK_CURRENT')['id']) ? Session::get('BANK_CURRENT')['id'] : null;
        $this->BANK_CODE			= isset(Session::get('BANK_CURRENT')['code']) ? Session::get('BANK_CURRENT')['code'] : null;
    }

    public function loan_upload_landing_page(Request $request)
    {
        Session::forget('function');
        Session::forget('loan_import_data');
        return view('Loan.Upload.upload');
    }

    public function loan_download_template(Request $request, $function)
    {
        $path = '';
        if ($function === 'SOFTSPACE') {
            $path = storage_path('template/softspace_loan_upload_template.csv');
        } else if ($function === 'FLASH') {
            $path = storage_path('template/flash_loan_upload_template.csv');
        }

        if ( file_exists($path) ) {
            $content = file_get_contents($path);
            $response = \Response::make($content);
            $response->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="template.csv"');
            return $response;
        } else {
            Log::error("[".__FUNCTION__."] Error: template was not found.");

            return redirect()->back()->with([
                ['alert-class'  => 'alert-danger'],
                ['message'      => 'Whoops, looks like something went wrong.']
            ]);
        }
        
    }

    public function loan_import(LoanApplicationUpload $request)
    {
        Session::put('function', $request->function);

        if ( $request->function === 'SOFTSPACE' ) {
            $loan = new Softspace();
            return $loan->file_upload($request);
        } else if ($request->function === 'FLASH') {
            $loan = new Flash();
            return $loan->file_upload($request);
        }
    }

    public function confirm_page()
    {
        $dataset = Session::get('loan_import_data');
        if ($dataset == null) {
            return redirect('Loan/Upload');
        }

        $column   = array_column($dataset, 'upload_status');
        $total    = count($dataset);
        $success  = count(array_filter($column, function ($item) {
            return $item === true;
        }));

        $fail = count(array_filter($column, function ($item) {
            return $item === false;
        }));

        if ( blank($success) )  {
            $success = 0;
        }
        if ( blank($fail) ) {
            $fail = 0;
        }

        return view('Loan.Upload.confirm', compact('total', 'success', 'fail'));
    }

    public function confirmCancel()
    {
        Session::forget('function');
        Session::forget('loan_import_data');
        return redirect('Loan/Upload');
    }

    public function loan_upload_obj(Request $request)
    {
        $all_bill = Session::get('loan_import_data') != null
            ? Session::get('loan_import_data')
            : [];

        return Datatables::of($all_bill)
            ->addColumn('status_label', function ($data) {
                if (isset($data['upload_status']) && $data['upload_status'] !== true) {
                    return '<span class="role badge badge-danger">Fail</span>';
                } else {
                    return '<span class="role badge badge-success">Pass</span>';
                }
            })
            ->addColumn('citizen_id', function ($data) {
                if (isset($data['customer_citizen_id']) && !blank($data['customer_citizen_id'])) {
                    return $data['customer_citizen_id'];
                } else if (isset($data['ic']) && !blank($data['ic'])) {
                    return $data['ic'];
                } else {
                    return '';
                }
            })
            ->addColumn('mobile_no', function ($data) {
                if (isset($data['customer_telephone']) && !blank($data['customer_telephone'])) {
                    return $data['customer_telephone'];
                } else if (isset($data['mobile_no']) && !blank($data['mobile_no'])) {
                    return $data['mobile_no'];
                } else {
                    return '';
                }
            })
            ->addColumn('application_no', function ($data) {
                if (isset($data['contract_reference']) && !blank($data['contract_reference'])) {
                    return $data['contract_reference'];
                } else if (isset($data['application_no']) && !blank($data['application_no'])) {
                    return $data['application_no'];
                } else {
                    return '';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function submitConfirm(Request $request)
    {
        try {
            // Password validation
            $data_response = $this->helper->PostRequest($this->api_client, 'api/import/invoice/confirm', [
                'password' => $request->password
            ]);

            if ($data_response->success) {
                $all_bill = Session::get('loan_import_data');

                try {
                    $bill_data_response = $this->helper->PostRequest($this->api_client, 'api/loan/contract/import', [
                        'data'         => $all_bill,
                        'corporate_id' => $this->CORP_CURRENT,
                        'function'     => Session::get('function')
                    ]);

                    if ( $bill_data_response->success ) {
                        if ($bill_data_response->data->failed > 0 || $bill_data_response->data->total == 0) {
                            return response()->json([
                                'message' => $bill_data_response->message,
                                'success' => false
                            ]);
                        } else {
                            Session::forget('loan_import_data');
                            Session::flash('alert-class', 'alert-success');
                            Session::flash('message', $bill_data_response->message);

                            return response()->json([
                                'message' => 'success',
                                'success' => true
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => $bill_data_response->message,
                            'code'    => $bill_data_response->code ?? ''
                        ]);
                    }
                } catch (\Exception $e) {

                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'กรอกรหัสไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง.'
                ], 200);
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
