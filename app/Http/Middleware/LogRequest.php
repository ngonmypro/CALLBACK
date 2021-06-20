<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\ApplicationLog;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request)
    {
        $log = new ApplicationLog();
        $log->logRequest($request->fullUrl(), $request->all(), $request->getClientIp());
    }
}
