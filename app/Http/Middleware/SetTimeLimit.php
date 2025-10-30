<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTimeLimit
{
    public function handle(Request $request, Closure $next)
    {
        set_time_limit(300);
        return $next($request);
    }
}