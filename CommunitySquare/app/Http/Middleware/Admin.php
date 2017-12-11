<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AccountController;
use Closure;
use Auth;
class Admin
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
        if(!Auth::user()){
            return redirect('');
        }
        $userCo = new \App\Http\Controllers\AccountController();
        if(!$userCo->isAdmin())
            return redirect('');
        return $next($request);
    }
}
