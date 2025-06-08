<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // S'assurer que les rôles sont chargés
        if (!$user->relationLoaded('roles')) {
            $user->load('roles');
        }

        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Accès interdit. Vous n\'avez pas les droits nécessaires.');
    }
}
