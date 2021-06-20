<?php

namespace App\Http\Controllers\EtaxDemo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use Exception;
use \DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use GuzzleHttp\Client;

use App\Repositories\Helper;

use Yajra\Datatables\Datatables;

use App\EtaxDemo;

class ETaxDemoController extends Controller
{
    private $helper;
    protected $EtaxGateway;
    protected $EtaxClientId;
    protected $EtaxClientSecret;

    public function __construct()
    {
        $this->helper            = new Helper();
        $this->EtaxGateway       = env('ETAX_GATEWAY');
        $this->EtaxClientId      = env('ETAX_CLIENT_ID');
        $this->EtaxClientSecret  = env('ETAX_CLIENT_SECRET');
    }

    public function index()
    {
        // Log::info('test index');
        return view('EtaxDemo.index');
    }

    public function etax_object_data(Request $request)
    {
        // Log::info('all : '.json_encode($request->all()));
        try {
            $etax = DB::table('etax_demo')
                        ->select(
                                'id',
                                'reference_code',
                                'invoice_number',
                                'total_amount',
                                'created_by',
                                'created_at',
                                'updated_at',
                                'due_date',
                                'status',
                                'document_type',
                                'batch_name',
                                'name',
                                'pdf_file',
                                'xml_file'
                        )
                        ->where([
                            // ['created_at', 'LIKE', "%2020-08-%"],
                            ['corporate_id', '=', 85]
                        ]);
                        // Log::info('$etax => '.json_encode($etax));
                        // ->orderBy('etax_file.id', 'desc');
            return Datatables::of($etax)
                            ->filter(function ($query) use ($request) {
                                if ($request->has('name') && !blank($request->name)) {
                                    $query->Where('name', 'LIKE', '%'.$request->name.'%');
                                }
                                if ($request->has('inv_no') && !blank($request->inv_no)) {
                                    $query->Where('invoice_number', 'LIKE', '%'.$request->inv_no.'%');
                                }

                                if ($request->has('daterange') && !blank($request->daterange)) 
                                {
                                    $dateRange = str_replace(' ', '', $request->daterange);
                                    $arr = explode('-', $dateRange);
                                    $start1 = str_replace('/', '-', $arr[1]);
                                    $end1 = str_replace('/', '-', $arr[0]);
                                    if( $end1 >= $start1)
                                    {
                                        $start = date('Y-m-d', strtotime($start1."+1 days"));
                                        $end = date('Y-m-d', strtotime($end1."-1 days"));
                                        $query->whereBetween('created_at', [$end, $start]);
                                    }
                                    else
                                    {
                                        $start = date('Y-m-d', strtotime($start1."+1 days"));
                                        $end = date('Y-m-d', strtotime($end1));
                                        $query->whereBetween('created_at', [$end, $start]);
                                    } 
                                }
                                else
                                {
                                    $today = date("Y-m-d", strtotime("+1 days"));
                                    $last_month = date('Y-m-d', strtotime("-1 Months". "-1 days"));
                                    $query->whereBetween('created_at', [$last_month, $today]);
                                }
                            })
                            ->make(true);

        } catch (Exception $e) {
            report($e);
            return $this->error->CheckException($e);
        }
    }

    public function create()
    {
        // Log::info('test index');
        Log::info('date("Y-m-dTH:i:s", strtotime("2020-08-24")) => '.date("Y-m-d\TH:i:s"));
        return view('EtaxDemo.create');
    }

    public function get_province(Request $request)
    {
        // Log::info('all : '.json_encode($request->all()));
        try {
            if($request->has('type')) {
                $type           = $request->type;
                $search         = $request->has('search') ? $request->search : NULL;
                $province       = $request->has('province') ? $request->province : NULL;
                $district       = $request->has('district') ? $request->district : NULL;
                $locale         = $request->has('locale') ? $request->locale : NULL;
                $query_local    = "";
                // Log::info('type : '.json_encode($type));
                $locale == 'en' ? $query_local = 'name_in_english' : $query_local = 'name_in_thai';
            
                if ($type == 'province') {
                    $sql = DB::table('dp_address_provinces')
                                ->select($query_local.' as id',$query_local.' as text')
                                ->groupBy($query_local)
                                ->orderBy($query_local,'ASC')
                                ->where($query_local,'LIKE',$search.'%');
                } else if ($type == 'district') {
                    $sql = DB::table('dp_address_districts')
                                ->join('dp_address_provinces','dp_address_provinces.id','=','dp_address_districts.province_id')
                                ->select('dp_address_districts.'.$query_local.' as id','dp_address_districts.'.$query_local.' as text')
                                ->groupBy('dp_address_districts.'.$query_local)
                                ->orderBy('dp_address_districts.'.$query_local,'ASC')
                                ->where([
                                    ['dp_address_provinces.'.$query_local,'LIKE',$province],
                                    ['dp_address_districts.'.$query_local,'LIKE',$search.'%']
                                ]);
                } else if ($type == 'sub_district') {
                    $sql = DB::table('dp_address_subdistricts')
                                ->join('dp_address_districts','dp_address_districts.id','=','dp_address_subdistricts.district_id')
                                ->select('dp_address_subdistricts.'.$query_local.' as id','dp_address_subdistricts.'.$query_local.' as text','dp_address_subdistricts.zip_code as zipcode')
                                // ->groupBy('dp_address_subdistricts.'.$query_local)
                                ->orderBy('dp_address_subdistricts.'.$query_local,'ASC')
                                ->where([
                                    ['dp_address_districts.'.$query_local,'LIKE',$district],
                                    ['dp_address_subdistricts.'.$query_local,'LIKE',$search.'%']
                                ]);
                } else {
                    return  response()->json([
                            'success'   =>  false,
                            'items'     =>  null
                        ], 200);
                }

                $sql = $sql->get()->toArray();
                // Log::info('sql : '.json_encode($sql));
                return  response()->json([
                            'success'   =>  true,
                            'items'     =>  $sql
                        ], 200);

            } else {
                return  response()->json([
                            'success'   =>  false,
                            'items'     =>  null
                        ], 200);
            }
        } catch (Exception $e) {
            report($e);
            return $this->error->CheckException($e);
        }
    }

    public function create_post(Request $request)
    {
        // Log::info('all : '.json_encode($request->all()));
        // return view('EtaxDemo.create');
        
        try
        {
            $products = array();
            for($i=0; $i<count($request->product_name); $i++)
            {
                $product['product_description']          = $request->product_name[$i];
                $product['product_quantity']             = number_format($request->product_qty[$i],3,".","");
                $product['product_unit_code']            = "";
                $product['product_amount']               = number_format($request->product_price_per_unit[$i],2,".","");
                $product['product_amount_vat']           = "";
                $product['product_amount_per_txn']       = number_format($request->product_amount[$i],2,".","");
                $product['product_total_amount_per_txn'] = number_format($request->product_amount[$i],2,".","");

                array_push($products, $product);
            }
            $data = array();
            $data = [
                "document_type_no"          => "380",
                "invoice_number"            => $request->invoice_number,
                "tax_id"                    => "0105531071981",
                "branch_code"               => "00000",
                "buyer_type"                => "TXID",
                "buyer_tax_id"              => "123456789012300000",
                "buyer_name"                => $request->recipient_name." ".$request->recipient_lastname,
                "buyer_email"               => $request->recipient_email,
                "buyer_email_cc"            => "",
                "buyer_zipcode"             => $request->select_zipcode,
                "buyer_country"             => "TH",
                "buyer_address_1"           => $request->address." ".$request->select_sub_district." ".$request->select_district." ".$request->select_province." ".$request->select_zipcode,
                "buyer_address_2"           => "",
                "currency"                  => "THB",
                "amount"                    => number_format($request->total_price_before_fee_and_discount,2,".",""),
                "tax_code_type"             => "VAT",
                "tax_rate"                  => $request->tax_percentage,
                "tax_amount"                => number_format($request->tax_amount,2,".",""),
                "fee_amount"                => "",
                "discount_amount"           => number_format($request->bill_discount,2,".",""),
                "total_amount_old"          => "",
                "total_amount_diff"         => "",
                "total_amount_before_tax"   => number_format($request->total_price_before_tax,2,".",""),
                "total_amount_tax"          => number_format($request->tax_amount,2,".",""),
                "total_amount"              => number_format($request->bill_total_amount,2,".",""),
                "cash_pay"                  => "",
                "cheque_number"             => "",
                "cheque_amount"             => "",
                "cheque_date"               => "",
                "payment_condition"         => "ชำระเงินภายใน 30 วัน",
                "due_date"                  => $request->bill_due_date == null ? date("Y-m-d") : date("Y-m-d", strtotime($request->bill_due_date)),
                "save_date"                 => "",
                "document_reference"        => "",
                "document_reference_date"   => "",
                "document_reference_code"   => "",
                "document_reason"           => "",
                "document_reason_code"      => "",
                "note"                      => "",
                "export_date"               => date("Y-m-d\TH:i:s"),
                "pdf_password"              => "",
                "products"                  => $products,
                "additional"                => []
            ];
            // $job_code = 'meaw06';
            $job_code = 'DEMOETAX';
            $upload_type = '';
            // $pdf_template = 'DEMO_ETAX_TEST';
            $pdf_template = 'Demo_etax_invoice';
            $callback = [
                'url' => 'https://eipp-sit.digio.co.th:7801/callback',
                'file' => 'PDF/XML'
            ];

            // Log::info('$data : '.json_encode($data));

            $client = new Client();
            
            $body_login       = [
                                    "grant_type"    => "client_credentials",
                                    "client_id"     => $this->EtaxClientId,
                                    "client_secret" => $this->EtaxClientSecret,
                                    "scope"         => "*"
                                ];
            Log::info('Authen ETax Service');
            
            #Authen ETax Service
            $respon_login   =   $client->request('POST',$this->EtaxGateway.'/oauth2/token',
                                                                [
                                                                    'json'     => $body_login
                                                                ]
                                                );
                $responsetoken = json_decode($respon_login->getBody()->getContents(),true);
                Log::info('Authen response:'.json_encode($responsetoken['access_token']));
            
            #call service
            $headers   = [
                                'Authorization' => 'Bearer '.$responsetoken['access_token'],
                                'Content-Type'  => 'application/json'
                        ];
            $body       = [
                                'data'          =>   $data,
                                'job_code'      =>   $job_code,
                                'upload_type'   =>   $upload_type,
                                'pdf_template'  =>   $pdf_template,
                                'callback'      =>   $callback
                        ];
            Log::info('call ETax Service');
            $response    =    $client->request('POST',$this->EtaxGateway.'/api/etaxservice/createinvoice',
                                                    [
                                                        'headers'  => $headers,
                                                        'body'     => json_encode($body)
                                                    ]
                                                );
            
            $response_request = json_decode($response->getBody()->getContents(),true);
            Log::info('Call ETax Service response:'.json_encode($response_request));

            if($response_request['success'] == true)
            {
                DB::beginTransaction();

                EtaxDemo::create([
                    'corporate_id'      =>  '85',
                    'reference_code'    =>  '',
                    'document_code'     =>  '380',
                    'document_type'     =>  'invoice',
                    'invoice_number'    =>  $request->invoice_number,
                    'batch_name'        =>  $request->batch_name == '' ? 'WEB-'.date('Y-m-d') : $request->batch_name,
                    'branch_code'       =>  $request->branch_name,
                    'name'              =>  $request->recipient_name." ".$request->recipient_lastname,
                    'email'             =>  $request->recipient_email,
                    'status'            =>  'NEW',
                    'total_amount'      =>  number_format($request->bill_total_amount,2,".",""),
                    'due_date'          =>  date("Y-m-d", strtotime($request->bill_due_date)),
                    'export_date'       =>  date('Y-m-d H:i:s'),
                    'created_by'        =>  'Etax-Demo',
                    'created_at'        =>  date('Y-m-d H:i:s'),
                    'updated_at'        =>  date('Y-m-d H:i:s')
                ]);
                

                DB::commit();
            }

            return  response()->json([
                'success'   =>  $response_request['success'],
                'message'   =>  $response_request['message']
            ], 200);
            
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return  response()->json([
                'success'   =>  false,
                'message'   =>  'Requst fail'
            ], 200);
            // return $this->error->CheckException($e);
        } 
    }

    public function download_PDF(Request $request)
    {
        // Log::info('all : '.json_encode($request));
        try 
        {
            $data = DB::table('etax_demo')
                        ->select(
                                'id',
                                'invoice_number',
                                'document_type',
                                'pdf_file'
                        )
                        ->where([
                            ['created_at', 'LIKE', "%2020-08-%"],
                            ['corporate_id', '=', 85],
                            ['id', '=', $request->id]
                        ])
                        ->first();
                        
            if ($data != null && $data != '') 
            {
                $type = $data->document_type;
                $file = base64_decode($data->pdf_file);
                $response = \Response::make($file);
                $response->header('Content-Type', 'text/csv');
                $response->header('Content-disposition',"attachment; filename=$data->invoice_number-$type.pdf");
                return $response;
            }
            else{
                return redirect('/Exception/InternalError');
            }     
        } 
        catch (\Exception $ex) 
        {
            Log::info($ex);
            report($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function download_XML(Request $request)
    {
        // Log::info('all : '.json_encode($request));
        try 
        {
            $data = DB::table('etax_demo')
                        ->select(
                                'id',
                                'invoice_number',
                                'document_type',
                                'xml_file'
                        )
                        ->where([
                            ['created_at', 'LIKE', "%2020-08-%"],
                            ['corporate_id', '=', 85],
                            ['id', '=', $request->id]
                        ])
                        ->first();
                        
            if ($data != null && $data != '') 
            {
                $type = $data->document_type;
                $file = base64_decode($data->xml_file);
                $response = \Response::make($file);
                $response->header('Content-Type', 'text/csv');
                $response->header('Content-disposition',"attachment; filename=$data->invoice_number-$type.xml");
                return $response;
            }
            else{
                return redirect('/Exception/InternalError');
            }     
        } 
        catch (\Exception $ex) 
        {
            Log::info($ex);
            report($ex);
            return  response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }
}
