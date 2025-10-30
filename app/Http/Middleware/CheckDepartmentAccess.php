<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDepartmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Authentification requise.');
        }

        // Les super admins et admin1 ont accès à tout
        if ($user->isSuperAdmin() || $user->isAdmin1()) {
            return $next($request);
        }

        // Pour les chefs de département, vérifier le code dans le matricule
        if (preg_match('/^CM-HQ-(.*)-CD$/i', $user->matricule, $matches)) {
            $deptCode = $matches[1];
            
            // Vérification du département
            if ($department = $request->route('department')) {
                if ($department->code !== $deptCode) {
                    abort(403, 'Vous n\'avez pas accès à ce département.');
                }
            }
            
            // Vérification du service
            if ($service = $request->route('service')) {
                if ($service->department->code !== $deptCode) {
                    abort(403, 'Vous n\'avez pas accès à ce service.');
                }
            }
            
            // Vérification de l'utilisateur
            if ($targetUser = $request->route('user')) {
                if ($targetUser->department->code !== $deptCode) {
                    abort(403, 'Vous n\'avez pas accès à cet utilisateur.');
                }
            }
            
            return $next($request);
        }

        // Pour les autres utilisateurs, vérifier le department_id
        if ($department = $request->route('department')) {
            if ($user->department_id !== $department->id) {
                abort(403, 'Vous n\'avez pas accès à ce département.');
            }
        }

        if ($service = $request->route('service')) {
            if ($user->department_id !== $service->department_id) {
                abort(403, 'Vous n\'avez pas accès à ce service.');
            }
        }

        if ($targetUser = $request->route('user')) {
            if ($user->department_id !== $targetUser->department_id) {
                abort(403, 'Vous n\'avez pas accès à cet utilisateur.');
            }
        }

        return $next($request);
    }
}