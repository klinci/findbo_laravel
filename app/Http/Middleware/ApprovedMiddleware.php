<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ApprovedMiddleware
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
        if (Auth::user()->is_approved == 0 && Auth::user()->userType == 1)
            return redirect('/notapproved');
        return $next($request);
    }
}
