<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ResourceRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$source)
    {
        $code = Session::get('CORP_CURRENT')['corp_code'];

        // Log::info('user '.json_encode($code));
        // Log::info('route '.json_encode($source));

        if ($source == null || $source == '') {
            return redirect('/AccessDenied');
        }

        if (strpos(json_encode($source), '!FLAS1QBLUA') !== false) {
            if ($code == 'FLAS1QBLUA') {
                // Log::info('==FLASH');
                return redirect('/AccessDenied');
            } else {
                // Log::info('!FLASH');
                return $next($request);
            }
        }

        if (strpos(json_encode($source), 'b2b') !== false) {
            // Log::info('has b2b '.Session::get('CORP_CURRENT')['is_b2b']);
            if (Session::get('CORP_CURRENT')['is_b2b'] == 0) {
                return redirect('/AccessDenied');
            } else {
                return $next($request);
            }
        }

        if (strpos(json_encode($source), 'b2c') !== false) {
            // Log::info('has b2c '.Session::get('CORP_CURRENT')['is_b2c']);
            if (Session::get('CORP_CURRENT')['is_b2c'] == 0) {
                return redirect('/AccessDenied');
            } else {
                return $next($request);
            }
        }

        if (in_array($code, $source)) {
            return $next($request);
        }

        return redirect('/AccessDenied');
    }
}
