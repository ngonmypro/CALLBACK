<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class UserAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$view_name)
    {
        $_permissions = json_decode(json_encode(Session::get('permission')), true);
        if (blank($_permissions)) {
            return redirect('/AccessDenied');
        }
        foreach ($view_name as $val) {
            list($view, $perm) = array_pad(explode('.', $val), 2, '');
            $_perm = isset($_permissions[$view]) ? $_permissions[$view] : null;
            if ($_perm != null) {
                if ($perm === '*') {
                    return $next($request);
                } else if (in_array($perm, $_permissions[$view])) {
                    return $next($request);
                }
            }
        }
        return redirect('/AccessDenied');
    }
}
