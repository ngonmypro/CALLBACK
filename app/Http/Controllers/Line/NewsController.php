<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;

class NewsController extends Controller
{
    private $CORP_CURRENT;
    private $helper;
    private $api_client;

    public function __construct()
    {
        $this->helper				  = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
    }

    public function index()
    {
        return view('Line.News.index');
    }
    public function create()
    {
        return view('Line.News.create');
    }
    public function objectData(Request $request)
    {
        try {
            $request['corporate_id'] = $this->CORP_CURRENT;

            $response = $this->api_client->post('api/news/objectData', [
                'form_params' => $request->all()
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                return response()->json($data_response->object);
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

    public function create_save(Request $request)
    {
        try {
            $file                         = $request->file('title_pic');
            $effective_date               = date('Y-m-d', strtotime(str_replace("/", "-", trim($request->effective_date))));
            $request['corporate_id']      = $this->CORP_CURRENT;
            $request['corp_code']         = $this->CORP_CODE;
            $request['effective_date']    = $effective_date;

            if ($file != null) {
                $request['extension'] = strtolower($file->getClientOriginalExtension());
                $request['base64'] = base64_encode(file_get_contents($file));
            }

            $response = $this->api_client->post('api/news/create', [
                                                'form_params' => $request->all()
                                            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Create news complete');

                return redirect('Line/News');
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function news_detail($news_code)
    {
        try {
            $response = $this->api_client->post('api/news/detail', [
                'form_params' => ['news_code' => $news_code]
            ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                $news_detail = $data_response->data;

                return view('Line.News.detail', compact('news_detail'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function edit_news($news_code)
    {
        try {
            $response = $this->api_client->post('api/news/detail', [
                    'form_params' => ['news_code' => $news_code]
                ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                $news_detail = $data_response->data;

                return view('Line.News.edit', compact('news_detail', 'news_code'));
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function update_status(Request $request)
    {
        try {
            $response = $this->api_client->post('api/news/update_status', [
                    'form_params' => $request->all()
                ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Update news status complete');

                return redirect('Line/News/Detail/'.$request->news_code);
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function edit_save(Request $request)
    {
        try {
            $file = $request->file('title_pic');
            $effective_date = date('Y-m-d', strtotime(str_replace("/", "-", trim($request->effective_date))));
            $request['corporate_id'] = $this->CORP_CURRENT;
            $request['corp_code'] = $this->CORP_CODE;
            $request['effective_date'] = $effective_date;

            if ($file != null) {
                $request['extension'] = strtolower($file->getClientOriginalExtension());
                $request['base64'] = base64_encode(file_get_contents($file));
            }

            $response = $this->api_client->post('api/news/edit_save', [
                    'form_params' => $request->all()
                ]);

            $data_response = \GuzzleHttp\json_decode($response->getBody()->getContents());

            if ($data_response->success) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', 'Create news complete');

                return redirect('Line/News');
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $data_response->message);

                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }
}
