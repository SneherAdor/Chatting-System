<?php

namespace App\Http\Middleware;

use Closure;

class OAuth
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
        $provider = $request->route()->parameter('provider');
         $checkStatus = env(strtoupper($provider).'_STATUS');
        if($checkStatus == 'enable')
           {
               return $next($request);
           }
           // throw new \Exception("$provider is $checkStatus");
           abort(403);
    }
}
