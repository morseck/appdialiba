<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        abort(403, 'Accès interdit. Vous n\'avez pas la permission nécessaire.');
    }
}
