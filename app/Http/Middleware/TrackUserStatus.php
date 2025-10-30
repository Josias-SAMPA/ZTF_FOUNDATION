<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TrackUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            User::where('id', Auth::id())->update(['is_online' => true]);
        }

        $response = $next($request);

        if (Auth::guest()) {
            User::where('id', Auth::id())->update(['is_online' => false]);
        }

        return $response;
    }
}