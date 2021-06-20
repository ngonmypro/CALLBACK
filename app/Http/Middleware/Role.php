<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $user_roles = Session::get('user_detail')->role;

        if ($user_roles == null || $user_roles == '') {
            return redirect('/AccessDenied');
        }

        if (count(array_intersect($user_roles, $roles)) > 0) {
            return $next($request);
        }

        return redirect('/AccessDenied');
    }
}
