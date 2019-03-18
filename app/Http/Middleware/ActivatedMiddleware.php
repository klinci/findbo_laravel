<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActivatedMiddleware
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
        if (Auth::user()->active == 1 || Auth::user()->token == 1)
            return $next($request);
        return redirect(route('notactivated'));
    }
}
