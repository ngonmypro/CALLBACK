<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Log;

class ExceptionMessage
{
    protected $lang;

    public function __construct($lang = 'en')
    {
        $this->lang = $lang;
    }

    public function getMessage(\Exception $e)
    {
        $message = null;

        if ( $e instanceof \GuzzleHttp\Exception\RequestException ) {
            
            $message = $this->APIException($e);

        }
        
        return $message ?? $e->getMessage();
    }

    public function APIException(\Exception $e)
    {
        $code = $e->getCode();
        $message = null;

        if ( $e instanceof \GuzzleHttp\Exception\ClientException ) {
            
            if ( $e->hasResponse() ) {

                $response = $e->getResponse();
                $ctype = ($response->getHeader('Content-Type')[0] ?? null);

                if ( $ctype === 'application/json' ) {

                    $statusCode = $response->getStatusCode();
                    $resbody = json_decode((string) $response->getBody());
                
                    if ( $statusCode === 422 ) {

                        $message = 'Input is invalid';
        
                    } else if ( $statusCode === 401 ) {
        
                        $message = $resbody->message ?? null;
        
                    } else if ( $statusCode === 403 ) {
        
                        $message = $resbody->message ?? null;
        
                    } else {
                        $message = $resbody->message ?? null;
                    }

                } else {

                    $statusCode = $response->getStatusCode();
                
                    if ( $statusCode === 401 ) {
                        $message = 'Your session has timed out.';
                    } else {
                        $message = 'Something\'s wrong here...';
                    }

                }

            } else {

                $message = 'Something\'s wrong here...';

            }

        } else if ( $e instanceof \GuzzleHttp\Exception\ServerException ) {

            $message = 'The system can\'t connect to the services.';

        }

        return $message ?? $e->getMessage();
    }
}
