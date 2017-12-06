<?php

namespace App\Http\Middleware;

use App\Roles\Role;
use Closure;
use Auth;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard=null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        if(Auth::user()->role == Role::ADMIN){
            return response("Page not founcd", 405);
        }

        return $next($request);
    }
}
