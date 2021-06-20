<?php

namespace App\Http\Controllers\BAAC;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use File;
use Validator;

class ProductController extends Controller
{
    private $api_client;
    private $CORP_CURRENT;
    private $virtual_card_url;

    public function __construct()
    {   
        $this->helper           = parent::Helper();
        $this->api_client       = parent::APIClient();
        $this->CORP_CURRENT     = isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
    }

    public function index()
    {
        return view('BAAC.Product.index');
    }
    
    public function objectData(Request $request)
    {
        try {
            $response = $this->api_client->post('api/BAAC/product/objectData', [
                'form_params' => $request->all()
            ]);
            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
            } else {
                return response()->json(null);
            }
        } catch (Exception $e) {
            report($e);

            return  response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function product_upload_page()
    {
        try {
            return view('BAAC.Product.Upload.index');
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function import_product(Request $request)
    {
        if ($request->file != null) {
            $file = $request->file('file');
            $real_name = $file->getClientOriginalName();
            $type_file = File::extension($real_name);

            if ($type_file != 'csv' && $type_file != 'xls' && $type_file != 'xlsx') {
                return response()->json([
                    'success'   => false,
                    'message'   => 'ไฟล์ที่อัพโหลดไม่รองรับ'
                ], 200);
            }

            $product = [];
            try 
            {    
                if ($this->CORP_CURRENT == '') {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'กรุณาเลือกบริษัทก่อนทำการอัพโหลด'
                    ], 200);
                }
                
                $result = Excel::load($file)->toArray();
                $title = Excel::load($file)->getSheetNames();
                
                if(count($title) == 1) {
                    $data[0] = $result;
                }
                else {
                    $data = $result;
                }
                    
                foreach ($data as $k => $v) {  //Read data from each sheet.
                    $product[$title[$k]] = [];
                    foreach($v as $key => $value) {
                        $value = array_filter($value);
                        if(!empty($value)) {
                            $_product = [];
                            $_product['product_code']          = isset($value['product_code']) ? $value['product_code'] : '';
                            $_product['product_name']          = isset($value['product_name']) ? $value['product_name'] : '';
                            $_product['short_des']             = isset($value['short_des']) ? $value['short_des'] : '';
                            $_product['description']           = isset($value['description']) ? $value['description']: '';
                            $_product['exp_date']              = isset($value['exp_date']) ? $value['exp_date']: '';
                            $_product['how_to']                = isset($value['how_to']) ? $value['how_to']: '';
                            $_product['is_call']               = isset($value['is_call']) ? $value['is_call']: '';
                            $_product['is_delivery']           = isset($value['is_delivery']) ? $value['is_delivery']: '';
                            $_product['is_e_voucher']          = isset($value['is_e_voucher']) ? $value['is_e_voucher']: '';
                            $_product['e_voucher_dec']         = isset($value['e_voucher_dec']) ? $value['e_voucher_dec']: '';
                            $_product['image']                 = isset($value['image']) ? $value['image']: '';
                            $_product['price']                 = isset($value['price']) ? $value['price']: '';
                            
                            $validator = Validator::make(
                                $_product,
                                [
                                    'product_code'                 => 'required',
                                    'product_name'                 => 'required',
                                ]
                            );
                            if ($validator->fails())
                            {
                                $fail_remark = implode("|",$validator->messages()->all()).' On sheet : '.$title[$k];
                                
                                return response()->json([
                                    'success' => false,
                                    'message' => $fail_remark
                                ]);
                            }
                            array_push($product[$title[$k]], $_product);
                        }
                    }
                }
                
                $response = $this->helper->PostRequest($this->api_client, 'api/BAAC/product/import',
                    [
                        'product' => $product,
                        'corp_id' => $this->CORP_CURRENT
                    ]
                );
                
                if($response->success == true) {
                    return response()->json([
                        'success' => true
                    ]);
                }
                else {
                    return response()->json([
                        'success' => false
                    ]);
                }
            } catch (\Exception $e) {
                report($e);

                return  response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
    
    public function product_detail($code)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/BAAC/product/detail',
                [
                    'code' => $code,
                    'corp_id' => $this->CORP_CURRENT
                ]
            );
            
            $product = $response->data->product;
            $all_catalogue = $response->data->all_catalogue;
            $all_product_type = $response->data->all_product_type;
          
            return view('BAAC.Product.detail',compact('code', 'product', 'all_catalogue', 'all_product_type'));
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function product_update(Request $request)
    {
        try {
            $response = $this->helper->PostRequest($this->api_client, 'api/BAAC/product/update',
                $request->all()
            );
          
            if ($response->success == true) {
                return redirect('BAAC/Product/Detail/'.$request->code)->with([
                    'alert-class' => 'alert-success',
                    'message'  => 'Update Product Successfully'
                ]);
            } else {
                return redirect()->back()->withInput()->with([
                    'alert-class' => 'alert-danger',
                    'message'  => $response->message
                ]);
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
