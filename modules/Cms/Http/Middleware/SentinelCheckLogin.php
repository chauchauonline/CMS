<?php

namespace Modules\Cms\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Routing\Middleware;
class SentinelCheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Sentinel::check())
        {
            return $next($request);
        }
        return Redirect::to('login')->withErrors('Bạn phải đăng nhập');
    }
}
