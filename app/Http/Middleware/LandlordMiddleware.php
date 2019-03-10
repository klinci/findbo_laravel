<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LandlordMiddleware
{
    /**
     * Handle an incoming request.
     * Checks if the user activated the account using the activation link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Auth::check() && (Auth::user()->userType == 1 || Auth::user()->isAdmin == 'admin'))
            return $next($request);
        return redirect('/');
    }
}
