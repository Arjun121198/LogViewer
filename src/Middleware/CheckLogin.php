<?php

namespace  Logviewer\Logviewer\Http\Middleware;

use Closure;

class checkLogin
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
        if (!$request->session()->get('logginguserid')) {
            return redirect('/login')->with('error','Please Login to access ');
        }
        return $next($request);
    }
}