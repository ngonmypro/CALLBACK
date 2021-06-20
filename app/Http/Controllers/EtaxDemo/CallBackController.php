<?php

namespace App\Http\Controllers\EtaxDemo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Log;

use App\EtaxDemo;
use App\LogCallbackEtax;

class CallBackController extends Controller
{
    public function call_back(Request $request)
    {
        Log::info('<= START CALL BACK FROM PROD => ');
        // Log::info('All => '.json_encode($request->all()));
        // return view('EtaxDemo.index');
        if($request->document == null)
        {
            Log::info('SIGN FAIL');
            EtaxDemo::where('invoice_number','=',$request->invoice_number)
                    ->update([
                        'status'            =>  $request->status_file,
                        'updated_by'        =>  'Etax-Demo',
                        'updated_at'        =>  date('Y-m-d H:i:s')
            ]);
        }
        else
        {
            if($request->document['document_type'] != null && $request->document['document_type'] != '')
            {
                if($request->document['document_type'] == 'PDF')
                {
                    Log::info('PDF FILE');
                    EtaxDemo::where('invoice_number','=',$request->invoice_number)
                            ->update([
                                'status'            =>  $request->status_file,
                                'pdf_file'          =>  $request->document['data'],
                                'updated_by'        =>  'Etax-Demo',
                                'updated_at'        =>  date('Y-m-d H:i:s')
                    ]);
                }
                else
                {
                    Log::info('XML FILE');
                    EtaxDemo::where('invoice_number','=',$request->invoice_number)
                            ->update([
                                'status'            =>  'SIGN XML SUCCESS',
                                'xml_file'          =>  $request->document['data'],
                                'updated_by'        =>  'Etax-Demo',
                                'updated_at'        =>  date('Y-m-d H:i:s')
                    ]);
                }
            }
            else
            {
                Log::info('GEN PDF SUCCESS');
            }
        }

        return  response()->json([
            'success'   =>  true,
            'message'   =>  'success'
        ], 200);
    }

    public function callBackEtax(Request $request)
    {
        Log::info('<= START CALL BACK FROM PROD => ');
        Log::info(json_encode($request->all()));

        // {"success":"1","response_code":"0000","invoice_number":"boat88","status_file":"GEN XML &amp; SIGN XML SUCCESS","document":{"document_type":"XML","data":"SQ=="}}  

        if($request){
            DB::table('log_callback_etax')
            ->insert([
                    'invoice_number'   =>  $request->invoice_number ?? '',
                    'success'           =>  $request->success ?? '',
                    'response_code'      =>  $request->response_code ?? '',
                    'status_file'            =>  $request->status_file ?? '',
                    'document'          => $request->document['document_type'] ?? '',
                    'updated_by'        =>  'Log',
                    'updated_at'        =>  date('Y-m-d H:i:s'),
                    'created_at'        =>  date('y-m-d H:i:s'),  
                    ]);
            // LogCallbackEtax::where('invoice_number','=',$request->invoice_number)
            // ->update([
            //     'success'           =>  $request->success ?? '',
            //     'response_code'            =>  $request->response_code ?? '',
            //     'status_file'            =>  $request->status_file,
            //     'document'          =>  $request->document,
            //     'updated_by'        =>  'Log',
            //     'updated_at'        =>  date('Y-m-d H:i:s')
            // ]);
        }

        // // Log::info('All => '.json_encode($request->all()));
        // // return view('EtaxDemo.index');
       
       
        // if($request->document == null)
        // {
        //     Log::info('if');
        // //     Log::info('SIGN FAIL');
        // //     EtaxDemo::where('invoice_number','=',$request->invoice_number)
        // //             ->update([
        // //                 'status'            =>  $request->status_file,
        // //                 'updated_by'        =>  'Etax-Demo',
        // //                 'updated_at'        =>  date('Y-m-d H:i:s')
        // //     ]);
        // }
        // else
        // {
        //     Log::info('else');
        //     Log::info(json_encode($request->document));



        //     foreach($request->document as $document){
        //         Log::info('document : '.json_encode($document));   
        //         Log::info($document['document_type']);
                
        //     }
        //     die();
        //     // if($request->document['document_type'] != null && $request->document['document_type'] != '')
        //     // {
        //     //     if($request->document['document_type'] == 'PDF')
        //     //     {
        //     //         Log::info('PDF FILE');
        //     //         // EtaxDemo::where('invoice_number','=',$request->invoice_number)
        //     //         //         ->update([
        //     //         //             'status'            =>  $request->status_file,
        //     //         //             'pdf_file'          =>  $request->document['data'],
        //     //         //             'updated_by'        =>  'Etax-Demo',
        //     //         //             'updated_at'        =>  date('Y-m-d H:i:s')
        //     //         // ]);
        //     //     }
        //     //     elseif($request->document['document_type'] == 'XML')
        //     //     {
        //     //         Log::info('XML FILE');
        //     //         // EtaxDemo::where('invoice_number','=',$request->invoice_number)
        //     //         //         ->update([
        //     //         //             'status'            =>  'SIGN XML SUCCESS',
        //     //         //             'xml_file'          =>  $request->document['data'],
        //     //         //             'updated_by'        =>  'Etax-Demo',
        //     //         //             'updated_at'        =>  date('Y-m-d H:i:s')
        //     //         // ]);
        //     //     }
        //     // }
        //     // else
        //     // {
        //     //     Log::info('GEN PDF SUCCESS');
        //     // }
        // }

        // return  response()->json([
        //     'success'   =>  true,
        //     'message'   =>  'success'
        // ], 200);
    
    }


    public function Log_call_back()
    {
        Log::info(' <= Log_call_back => ');
        return view('Callback.index');
        // return  response()->json([
        //     'success'   =>  true,
        //     'message'   =>  'success'
        // ], 200);
    }


    public function log_etax_data(Request $request)
    {
        // Log::info('all : '.json_encode($request->all()));
        try {

            $etax = DB::table('log_callback_etax')
                        ->select(
                                'success',
                                'response_code',
                                'invoice_number',
                                'status_file',
                                'document',
                                'created_by',
                        )
                        ->where([
                            ['created_at', 'LIKE', "%2020-11-%"],
                            // ['invoice_number', '=', 'boat88']
                        ]);
                        // Log::info('$etax => '.json_encode($etax));
                        // ->orderBy('etax_file.id', 'desc');
            return Datatables::of($etax)
                            ->filter(function ($query) use ($request) {
                               
                                // if ($request->has('inv_no') && !blank($request->inv_no)) {
                                //     $query->Where('invoice_number', 'LIKE', '%'.$request->inv_no.'%');
                                // }

                                // if ($request->has('daterange') && !blank($request->daterange)) 
                                // {
                                //     $dateRange = str_replace(' ', '', $request->daterange);
                                //     $arr = explode('-', $dateRange);
                                //     $start1 = str_replace('/', '-', $arr[1]);
                                //     $end1 = str_replace('/', '-', $arr[0]);
                                //     if( $end1 >= $start1)
                                //     {
                                //         $start = date('Y-m-d', strtotime($start1."+1 days"));
                                //         $end = date('Y-m-d', strtotime($end1."-1 days"));
                                //         $query->whereBetween('created_at', [$end, $start]);
                                //     }
                                //     else
                                //     {
                                //         $start = date('Y-m-d', strtotime($start1."+1 days"));
                                //         $end = date('Y-m-d', strtotime($end1));
                                //         $query->whereBetween('created_at', [$end, $start]);
                                //     } 
                                // }
                                // else
                                // {
                                //     $today = date("Y-m-d", strtotime("+1 days"));
                                //     $last_month = date('Y-m-d', strtotime("-1 Months". "-1 days"));
                                //     $query->whereBetween('created_at', [$last_month, $today]);
                                // }
                            })
                            ->make(true);

        } catch (Exception $e) {
            report($e);
            return $this->error->CheckException($e);
        }
    }


    // public function index()
    // {
    //     Log::info(' <= TEST CALL BACK => ');
    //     // Log::info('All => '.json_encode($request->all()));
    //     // return view('EtaxDemo.index');
    //     return  response()->json([
    //         'success'   =>  true,
    //         'message'   =>  'success'
    //     ], 200);
    // }
}
