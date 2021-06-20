<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Workflow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$workflow)
    {
        $user_workflow = Session::get('user_detail')->job;
        $corp_workflow = Session::get('workflow');

        // Log::info('WF '.\GuzzleHttp\json_encode($workflow));
        // Log::info('USER '.json_encode($user_workflow));

        if ($user_workflow == null || $user_workflow == '') {
            return redirect('/AccessDenied');
        }

        if (count($workflow) == 0) {
            if (count(array_intersect($user_workflow, $corp_workflow)) > 0) {
                return $next($request);
            }
        } else {
            if (count(array_intersect($user_workflow, $workflow)) > 0) {
                return $next($request);
            }
        }


        return redirect('/AccessDenied');
    }
}
