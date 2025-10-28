<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette section.');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur est super administrateur
        if ($user->isSuperAdmin()) {
            // Accès autorisé pour le super administrateur
            return $next($request);
        } else {
            // Accès refusé pour les autres utilisateurs
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Accès refusé',
                    'message' => 'Seuls les super administrateurs peuvent accéder à cette section.',
                ], 403);
            }

            return redirect()->back()->with('error', 'Accès refusé. Seuls les super administrateurs peuvent accéder à cette section.');
        }
    }
}
