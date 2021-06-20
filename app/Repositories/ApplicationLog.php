<?php

namespace App\Repositories;

use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;

class ApplicationLog
{
    public function __construct()
    {
    }

    /**
     * UserLog - save user activity log
     *
     * @param array $param = [
     *      'action'     =>         (string) action name. Required.
     *      'detail'     =>         (string) detail description. Required.
     *      'function'   =>         (string) function name. Required.
     *      'error'      =>         (exception) error. Default: null.
     * ]
     * @Example in Controller
     * 
     *   $this->applog->UserLog($this->request->auth, [
     *       'action'    => '',
     *       'function'  => '',
     *       'detail'    => '',
     *       'error'     => ''
     *   ]);
     * 
     * 
     * 
     * @return void
     */
    public function UserLog($request_user, $array = ['error' => null])
    {
        try
        {
            $error = isset($array['error']) && $array['error'] != null
                            ? ($array['error'] instanceof \Exception 
                                ? $array['error']->getMessage() 
                                : $array['error'])
                            : null;

            $data = [
                'user_type'     => $request_user['user_type'],
                'action'        => $array['action'],
                'detail'        => $array['detail'],
                'function'      => $array['function'],
                'exception'     => $error,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_by'    => $request_user['id']
            ];

            $current_date = date('Ymd');
            $path = 'logger/userlog/'.$current_date.'_userlog.log';
            $userlog = new Logger('userlog');
            if (!isset($error)) {
                $userlog->pushHandler(new StreamHandler(storage_path($path)), Logger::INFO);
                $userlog->info(PHP_EOL.'INFO', $data);
            } else {
                $userlog->pushHandler(new StreamHandler(storage_path($path)), Logger::ERROR);
                $userlog->error(PHP_EOL.'ERROR', $data);
            }
        }
        catch(\Exception $e)
        {
            report($e);
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());
        }
        return;
    }

    public function logRequest($url, $request, $ip)
    {
        try
        {
            $data = [
                'url'                       => $url,
                'request'                   => $request,
                'ipaddress'                 => $ip,
                'created_date'              => date('Y-m-d H:i:s')
            ];

            $current_date = date('Ymd');
            $path = 'logger/requestlog/'.$current_date.'_requestlog.log';
            $userlog = new Logger('requestlog');

            $userlog->pushHandler(new StreamHandler(storage_path($path)), Logger::INFO);
            $userlog->info(PHP_EOL.'INFO', $data);
        }
        catch(\Exception $e)
        {
            report($e);
            Log::error($e->getMessage() . ', Stacktrace: ' . $e->getTraceAsString());
        }
        return;
    }
}
