<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Log;
use Hash;
use Session;
use Input;
use File;
use Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\AuthToken;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Helper;
use App\Repositories\ApplicationLog;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ImageRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \Eventviva\ImageResize;
use App\Http\Requests;

class RichmenuController extends Controller
{
    private $helper;
    private $api_client;
    private $logger;

    public function __construct()
    {
        $this->api_client 			= parent::APIClient();
        $this->helper               = parent::Helper();
        $this->logger               = parent::Logger();
    }
    public function index()
    {
        $response = $this->api_client->post('/api/line/richmenu/compact_index', [
                                                                                    'headers' => ['token' => Session::get('token')]
                                                                                ]);
        $response = json_decode($response->getBody());

        if ($response->success === true) {
            $richmenu = $response->data;
            $menu_active = $response->menu_active;
            $count_richmenu = count($richmenu);
            $corp_name = Session::get('CORP_CURRENT')['name'];

            return view('Line.Richmenu.index', compact('richmenu', 'count_richmenu', 'menu_active', 'corp_name'));
        }
    }
    public function search(Request $request)
    {
        $data = $request->data_search;
        try {
            $response = $this->api_client->post('/api/line/richmenu/compact_search', [
                                                                                        'json' =>   [
                                                                                                        'headers' => ['token' => Session::get('token')],
                                                                                                        'params'  => ['data_search'    => $data]
                                                                                                    ]
                                                                                    ]);
            $response = json_decode($response->getBody());
            if ($response->success === true) {
                $richmenu = $response->data;
                $menu_active = $response->menu_active;
                $count_richmenu = count($richmenu);
                $corp_name = Session::get('CORP_CURRENT')['name'];

                return view('Line.Richmenu.index', compact('richmenu', 'count_richmenu', 'menu_active', 'corp_name'));
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }

    //demo
    public function show_create()
    {
        return view('Line.Richmenu.create');
    }
    public function show_edit($id)
    {
        try {
            $client = new Client();
            $response = $this->api_client->post('/api/line/richmenu/compact_update', [
                                                                                        'json' =>   [
                                                                                                        'headers' => ['token' => Session::get('token')],
                                                                                                        'params'  => ['id'    => $id]
                                                                                                    ]
                                                                                    ]);
            $response = json_decode($response->getBody());
            if ($response->success === true) {
                $richmenu = $response->data;
                $richmenu_action = $response->richmenu_action;
                $count_action = count($richmenu_action);
                $image_edit = $response->image;

                return view('Line.Richmenu.edit', compact('richmenu', 'richmenu_action', 'count_action', 'image_edit'));
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
    public function show_richmenu(Request $request)
    {
        try {
            $client = new Client();
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/show_richmenu',
                [
                                                'json' =>   [
                                                                'data'  => $request->all()
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            'data'      =>  $response->data
                                        ]);
            } else {
                // throw New Exception('(ผิดพลาด) ไม่สามารถดูข้อมูล Rich Menu ได้');
                throw new Exception('(Error) Get Rich Menu Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
    public function create_richmenu(Request $request)
    {
        try {
            $client = new Client();
            $areas = [];
            $bounds = [];
            $action = [];
            $corporate_id = Session::get('CORP_CURRENT')['id'];
            $corp_code = Session::get('CORP_CURRENT')['corp_code'];
            $image  =   $request->upload_image;
            //set size menu
            if ($request->size === 'large') {
                $size = [
                            "width" => 2500,
                            "height"=> 1686
                        ];
            } elseif ($request->size === 'compact') {
                $size = [
                            "width" => 2500,
                            "height"=> 843
                        ];
            }
            //set body action
            for ($i=0;$i<count($request->action);$i++) {
                if ($request->action[$i] === 'message') {
                    $action_type = 'text';
                } else {
                    $action_type = 'uri';
                }
                $bounds[$i] =   [
                                        "x"      =>    $request->x[$i],
                                        "y"      =>    $request->y[$i],
                                        "width"  =>    $request->width[$i],
                                        "height" =>    $request->height[$i]
                                         
                                    ];
                $action[$i]    = [
                                        "type"          => $request->action[$i],
                                        $action_type    => $request->action_text[$i] 
                                    ];
                $areas[$i] =    [
                                        'bounds'  => $bounds[$i],
                                        'action'  => $action[$i]  
                                    ];
            }
            $body   =  [
                            "size"          => $size,
                            "selected"      => true,
                            "name"          => $request->richmenu_name,
                            "chatBarText"   => $request->chatbar_name,
                            "areas"         => $areas
                        ];
            $template_number = $request->template_number;
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/create',
                [
                                                'json' =>   [
                                                                'body'          => $body,
                                                                "richmenu_name" => $request->richmenu_name,
                                                                "chatbar_name"  => $request->chatbar_name,
                                                                "image"         => $image,
                                                                "areas"         => $areas,
                                                                "corporate_id"  => $corporate_id,
                                                                "corp_code"     => $corp_code,
                                                                "template_number" => $template_number
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody()->getContents()); 
            Log::info('ssss ::'.json_encode($response));  
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            // 'message'   =>  'สร้าง Rich Menu สำเร็จ'
                                            'message'   =>  'Create Rich Menu Success'
                                        ], 200);
            } else {
                if ($response->image_res === false) {
                    // throw new \Exception('(ผิดพลาด) รูปภาพมีปัญหา กรุณาลดขนาดรูปภาพหรือใช้รูปภาพอื่น');
                    throw new \Exception('(Error01) The image exceeds max file size. Please reduce image file size down.');
                } else {
                    // throw new \Exception('(ผิดพลาด) ไม่สามารถสร้าง Rich Menu ได้');
                    throw new \Exception('(Error02) Can not create Rich Menu.');
                }
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
    public function update_richmenu(Request $request)
    {
        try {
            $client = new Client();
            $areas = [];
            $bounds = [];
            $action = [];
            $corporate_id = Session::get('CORP_CURRENT')['id'];
            $corp_code = Session::get('CORP_CURRENT')['corp_code'];
            $image  =   $request->upload_image;
            //set size menu
            if ($request->size === 'large') {
                $size = [
                            "width" => 2500,
                            "height"=> 1686
                        ];
            } elseif ($request->size === 'compact') {
                $size = [
                            "width" => 2500,
                            "height"=> 843
                        ];
            }
            //set body action
            for ($i=0;$i<count($request->action);$i++) {
                if ($request->action[$i] === 'message') {
                    $action_type = 'text';
                } else {
                    $action_type = 'uri';
                }
                $bounds[$i] =   [
                                        "x"      =>    $request->x[$i],
                                        "y"      =>    $request->y[$i],
                                        "width"  =>    $request->width[$i],
                                        "height" =>    $request->height[$i]
                                         
                                    ];
                $action[$i]    = [
                                        "type"          => $request->action[$i],
                                        $action_type    => $request->action_text[$i] 
                                    ];
                $areas[$i] =    [
                                        'bounds'  => $bounds[$i],
                                        'action'  => $action[$i]  
                                    ];
            }
            $body   =  [
                            "size"          => $size,
                            "selected"      => true,
                            "name"          => $request->richmenu_name,
                            "chatBarText"   => $request->chatbar_name,
                            "areas"         => $areas
                        ];
            $template_number = $request->template_number;
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/update',
                [
                                                'json' =>   [
                                                                'body'              => $body,
                                                                "richmenu_name"     => $request->richmenu_name,
                                                                "chatbar_name"      => $request->chatbar_name,
                                                                "image"             => $image,
                                                                "areas"             => $areas,
                                                                "corporate_id"      => $corporate_id,
                                                                "corp_code"         => $corp_code,
                                                                "template_number"   => $template_number,
                                                                "id"                => $request->id
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());   
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            'message'   =>  'อับเดต Rich Menu สำเร็จ'
                                        ], 200);
            } else {
                // throw new \Exception('(ผิดพลาด) ไม่สามารถอัปเดต Rich Menu ได้');
                throw new \Exception('(Error) Update Rich Menu Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
    public function delete_richmenu(Request $request)
    {
        try {
            $client = new Client();
            $id = $request->id;
            $corporate_id = Session::get('CORP_CURRENT')['id'];
            $corp_code = Session::get('CORP_CURRENT')['corp_code'];
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/delete',
                [
                                                'json' =>   [
                                                                'corporate_id'  => $corporate_id,
                                                                'corp_code'     => $corp_code,
                                                                'id'            => $id
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());   
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            // 'message'   =>  'ลบ Rich Menu สำเร็จ'
                                            'message'   =>  'Delete Rich Menu Success'
                                        ], 200);
            } else {
                // throw new Exception('(ผิดพลาด) ไม่สามารถลบ Rich Menu ได้');
                throw new Exception('(Error) Delete Rich Menu Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
    public function set_richmenu_all_user(Request $request)
    {
        try {
            $client = new Client();  
            $id = $request->id;
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/set_alluser',
                [  
                                                'json' =>   [
                                                                'email'         =>  Session::get('user_detail')->sub,
                                                                'id'            =>  $id
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());     
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            // 'message'   =>  'ตั้งค่าการใช้งาน Rich Menu สำเร็จ'
                                            'message'   =>  'Set Default Rich Menu Success'
                                        ]);
            } else {
                // throw new Exception('(ผิดพลาด) ไม่สามารถใช้งาน Rich Menu ได้');
                throw new Exception('(Error) Set Rich Menu Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'   => false,
                                        'message'   => $ex->getMessage()
                                    ]);
        }
    }
    
    public function unset_richmenu_all_user(Request $request)
    {
        try {
            $client = new Client();    
            $id = $request->id;
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/unset_alluser',
                [
                                                'json' =>   [
                                                                'email' =>  Session::get('user_detail')->sub,
                                                                'id'    =>  $id
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());      
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            // 'message'   =>  'ยกเลิกการใช้งาน Rich Menu สำเร็จ'
                                            'message'   =>  'Cancel Default Rich Menu Success'
                                        ]);
            } else {
                // throw new Exception('(ผิดพลาด) ไม่สามารถยกเลิกการใช้งาน Rich Menu ได้');
                throw new Exception('(Error) Cancel Default Rich Menu Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'   => false,
                                        'message'   => $ex->getMessage()
                                    ]);
        }
    }
    public function set_richmenu_by_user(Request $request)
    {
        try {
            $client = new Client(); 
            $userId = 'Ua6825c72a5a3e6dbac1122f0af70d065';  // mock
            // $userId = $request->userId;
            $id = $request->id;//richmenu_id
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/set_byuser',
                [   
                                                'json' =>   [
                                                                'email'     =>  Session::get('user_detail')->sub,
                                                                'id'        =>  $id
                                                            ]
                                            ]
            );
            $response = json_decode($response->getBody());     
            if ($response->success === true) {
                return response()->json([
                                            'success'   =>  true,
                                            'message'   =>  'ตั้งค่าการใช้งาน Rich Menu สำเร็จ'
                                        ]);
            } else {
                throw new Exception('(ผิดพลาด) ไม่สามารถใช้งาน Rich Menu ได้');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'   => false,
                                        'message'   => $ex->getMessage()
                                    ]);
        }
    }
    public function unset_richmenu_by_user(Request $request)
    {
        try {
            $userId = 'Ua6825c72a5a3e6dbac1122f0af70d065';//mock
            // $userId = $request->userId;
            $client = new Client();
            $params =   [
                            'userId'     => $userId
                        ];
            $response = $client->request(
                'POST',
                env('API_LINE_URL', '').'/line/richmenu/unset_byuser',
                [
                                                'json' =>   [
                                                                'params'    => $params
                                                            ]
                                            ]
            );
            if (json_encode($response) === '{}') {
                return response()->json([
                                            'success'   =>  true,
                                            'message'      =>  'success'
                                        ]);
            } else {
                throw new Exception('unset Fail.');
            }
        } catch (\Exception $ex) {
            Log::info('ERRR '.$ex);
            return response()->json([
                                        'success'=> false,
                                        'message'=> $ex->getMessage()
                                    ]);
        }
    }
}
