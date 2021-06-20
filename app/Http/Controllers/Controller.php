<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use Session;
use Log;
use App\Repositories\Helper;
use App\Repositories\ApplicationLog;
use Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Artisan::call('view:clear');
    }

    public function APIClient()
    {
        $token = Session::get('token');
        $api_url = env('API_URL');

        if (!blank($token)) {
            return new Client([
                'base_uri'  => $api_url,
                'headers'   => ['Authorization' => 'Bearer '.$token]
            ]);
        } else {
            return new Client([
                'base_uri'  => $api_url
            ]);
        }
    }
    
    public function Helper()
    {
        return new Helper();
    }

    public function Logger()
    {
        return new ApplicationLog();
    }
}
