<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSMiddleware
{
    public function __construct()
    {
    }

    public function handle(Request $request, \Closure $next)
    {
        if (!in_array(strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
            $input = htmlentities($input);
        });

        $request->merge($input);

        return $next($request);
    }
}
