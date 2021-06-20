<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use File;
use App\Http\Requests\MappingFieldRequest;

class FieldMappingController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				= parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->API_URL              = env('API_URL');
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : 5;
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
    }

    public function index()
    {
        return view('FieldMapping.index');
    }

    public function import()
    {
        try {
            // $response = $this->api_client->post('api/field_mapping/data/document_type', [
            //     'json' => [
                    
            //     ]
            // ]);

            // $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/data/document_type', [
            ]);

            if($response->success == true) {
                $document_type = $response->data;

                return view('FieldMapping.import',compact('document_type'));
            } else {
                
            }
        } catch (\Exception $e) {
            Log::info($e);
            return redirect('/Exception/InternalError');
        }
    }

    public function detail($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/detail', [
                            'reference_code' => $code,
                            'corporate_id'	 => $this->CORP_CURRENT
                        ]);

            if($response->success == true) {
            	$data = $response->data;

            	return view('FieldMapping.detail',compact('data'));
            } else {
            	
            }
        } catch (\Exception $e) {
            return  response()->json([
					                    'success' => false,
					                    'message' => $e->getMessage()
					                ]);
        }
    }

    public function importPost(Request $request)
    {
        $func = "import mapping field";
    	if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);
      
            if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
                return  response()->json(['success' => false]);
            }

            try {

                // Excel::load($file, function ($reader) use ($request) { //read file excel
                //     $headerRows = $reader->first()->keys()->toArray();
                // });

                Excel::load($file, function ($reader) use ($request){
                    /** @var RowCollection $singleRow */
                    $singleRow = $reader->takeRows(1)->get(); // no need to parse whole sheet for the headings
                    $headerRows = $singleRow->getHeading();

                    array_walk_recursive($headerRows, function (&$input) {
                        $input = htmlentities($input);
                    });
                
                    Session::put('headerRows', $headerRows);
                    Session::put('document_type', $request->document_type); 
                    
                    // Do validation. Throw exception.
                    $reader->takeRows(false); // set the limit back to unlimited
                })->get();

                return  response()
                    ->json([
                        'success' => true
                    ]);
            }
            catch (\Exception $e) 
            {
                Log::error("[{$func}] error: {$e->getMessage()}");
                return  response()
                    ->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
            }
            catch (\Error $e) 
            {
                Log::error("[{$func}] error: {$e->getMessage()}");
                return  response()
                    ->json([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
            }
        }
    }

    public function create(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/data/mapping_field', [
                'document_code' => Session::get('document_type')
            ]);

            if($response->success == true) {
                $systemField = $response->data;
                $userField = Session::get('headerRows');

                return view('FieldMapping.create',compact('systemField','userField'));
            }
        } catch (\Exception $e) {
            return  response()->json([
                                        'success' => false,
                                        'message' => $e->getMessage()
                                    ]);
        }
    }

    public function createPost(MappingFieldRequest $request)
    {
    	try {
            $request['corporate_id'] = $this->CORP_CURRENT;
            $request['corporate_code'] = $this->CORP_CODE;
            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/create',
                $request->except('_token')
            );

            if($response->success == true) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', $response->message);
            	return  response()->json([
					                    'success' => true
					                ]);
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $response->message);
            	return  response()->json([
					                    'success' => false,
					                    'message' => $response->message
					                ]);
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return  response()->json([
					                    'success' => false,
					                    'message' => $e->getMessage()
					                ]);
        }
    }

    public function objectData(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/objectData', [
                'corporate_id' => $this->CORP_CURRENT
            ]);

            Log::info(json_encode($response));

            if ($response->success == true) {
                return response()->json($response->object);
            } else {
                return response()->json(null);
            }
        } catch (\Exception $e) {
            return  response()->json([
					                    'success' => false,
					                    'message' => $e->getMessage()
					                ]);
        }
    }

    public function CreateNewDefault()
    {
        Log::info('CreateNewDefault');
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/field_mapping/create/default/mapping', [
                'corporate_id'      => $this->CORP_CURRENT,
                'corporate_code'    => $this->CORP_CODE
            ]);

            if($response->success == true)
            {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', $response->message);
                Log::info(json_encode($response));
            }
            else
            {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $response->message);
                Log::info(json_encode($response));
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            Log::info(json_encode($response));
            return redirect()->back();
        }
    }

    public function Get_Template($doc_type, $doc_code)
    {
        try
        {
            $response = $this->helper->PostRequest(
                $this->api_client, 
                $this->API_URL.'/api/field_mapping/get/sftp_template', 
                [
                    'token' => Session::get('token'),
                    'mapping_code' => $doc_code
                ]
            );
            
            if ($response->success != true) {
                return  response()->json([
                    'success' => false,
                    'message' => $response->message
                ]);
            }

            $data = $response->data;
            $name_file = strtoupper($doc_type).'-'.$doc_code.'-'.date('Ymd');

            $field = ['jobs_code'];
            if(count($data) > 0)
            {   
                foreach ($data as $key => $value) {
                    $field[] = $value->field;
                }
            }

            Excel::create($name_file, function ($excel) use ($field) {
                $excel->sheet('sheet_name', function($sheet) use ($field) {
                    $sheet->fromArray($field);
                });
            })->export('csv');
    
            return  response()->json([
                'success'   => true
            ]);
        }
        catch(\Exception $ex)
        {
            // Log::info($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }
}
