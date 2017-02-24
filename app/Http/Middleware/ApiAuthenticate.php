<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->getClientIp();
        $whiteList = config('api.whiteList.token');
        if( in_array($ip,$whiteList ) ){
            return $next($request);
        }
        else{
            return response('Unauthorized.', 401);
        }
    }
}
