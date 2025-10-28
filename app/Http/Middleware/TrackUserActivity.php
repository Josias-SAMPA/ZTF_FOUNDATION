<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $now = Carbon::now();
            
            // Mise à jour de l'activité uniquement si la dernière mise à jour date d'il y a plus d'une minute
            if (!$user->last_activity_at || $now->diffInMinutes($user->last_activity_at) > 1) {
                $updateData = [
                    'last_activity_at' => $now,
                    'is_online' => true
                ];

                // Si c'est une nouvelle session, mettre à jour last_login_at
                if (!session()->has('last_login_tracked')) {
                    $updateData['last_login_at'] = $now;
                    session(['last_login_tracked' => true]);
                }

                // Mise à jour des informations de l'utilisateur
                $user->update($updateData);
            }

            // Marquer les utilisateurs comme hors ligne après 15 minutes d'inactivité
            User::where('last_activity_at', '<', $now->subMinutes(15))
                ->where('is_online', true)
                ->update(['is_online' => false]);
        }

        return $next($request);
    }
}
