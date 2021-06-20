<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use League\OAuth2\Server\Exception\OAuthServerException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $e)
    {
        if($this->shouldReport($e))
        {
            $this->WriteLog($e);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    { 
        $func = debug_backtrace()[0]['function'];

        if ($this->isHttpException($e)) {

            switch ($e->getStatusCode()) {

                // not found
                case 404:
                    return redirect()->guest('/Exception/NotFound');
                    break;

                // method not allow
                case 405:
                    return redirect()->guest('/Exception/MethodNotAllowed');
                    break;

                // internal error
                case 500:
                    return redirect()->guest('/Exception/InternalError');
                    break;

                default:
                    return $this->renderHttpException($e);
                    break;
            }

        } else if ($e instanceof OAuthServerException) {

            if ($request->expectsJson()) {
                return response()->json([
                    'error'                 => $e->getCode(),
                    'error_description'     => $e->getMessage(),
                    'message'               => $e->getMessage()
                ], 401);
            } else {
                return redirect('/AccessDenied');
            }          

        } else if ($e instanceof ValidationException) {
            Log::error('validation message: ', $e->validator->getMessageBag()->toArray());

            if ($request->expectsJson()) {
                return response()->json(['error' => $e->validator->getMessageBag()->toArray()], 422);
            } else {
                return redirect()->back()->withErrors($e->validator->getMessageBag()->toArray());
            }          

        } else if ($e instanceof TokenMismatchException) {

            return redirect()->back()->with('throw_detail', trans('common.session_exp'));

        } else if ($e instanceof MethodNotAllowedHttpException) {

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => trans('common.method_notallow')], 405);
            } else {
                return redirect()->back()->with('throw_detail', trans('common.method_notallow'));
            }          

        } else {

            return redirect()->guest('/Exception/InternalError');

        }
    }
    public function WriteLog($e)
    {
        Log::error('Type: '.get_class($e));
        Log::error('Line: '.$e->getLine().', File: '.$e->getFile());
        Log::error('Error: '.$e->getMessage().PHP_EOL.'Stacktrace: '.PHP_EOL.$e->getTraceAsString());
    }
}
