<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class EnsureUserIsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->is_admin) {
            return redirect('/home');
        }

        return $next($request);
    }
}
