<?php
namespace Modules\Cms\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Redirect;

class SentinelHasAccess {

     /**
   * Sentry - Check role permission
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
    public function handle($request, Closure $next)
    {
        $actions = $request->route()->getAction();

        if (array_key_exists('hasAccess', $actions))
        {
            $permissions = $actions['hasAccess'];
            $user = Sentinel::getUser();
            foreach ($permissions as $p)
            {
                if ($user->hasAccess($p)) {
                    return $next($request);
                }
            }
            return Redirect::to('account')->withErrors(['Bạn không được quyền truy cập trang này.']);
        }
        return $next($request);
    }
}
