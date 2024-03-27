<?php

namespace Logviewer\Logviewer\Http\Middleware;

use Closure;

class CheckLogin
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
        if (!$request->session()->has('logginguseremail')) {
            return redirect('/login')->with('error', 'Please login to access.');
        }

        return $next($request);
    }
}
