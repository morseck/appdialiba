<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnUserType
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Éviter les redirections infinies
            $currentRoute = $request->route()->getName();
            $allowedRoutes = [
                'logout', 'password.request', 'password.email',
                'password.reset', 'password.update'
            ];

            if (in_array($currentRoute, $allowedRoutes)) {
                return $next($request);
            }

            $userType = $user->getUserType();

            switch ($userType) {
                case 'medecin':
                         redirect()->route('talibe.index');

                    break;

                case 'dieuw':
                        //return redirect()->route('dieuw.index');
                         redirect()->route('dieuw.show', ['id' => $user->dieuw->id]);
                    break;

                case 'admin':
                    // Les admins peuvent accéder partout
                    break;

                default:
                    if (!$request->is('home*') && !$request->is('profile*')) {
                        return redirect()->route('home');
                    }
                    break;
            }
        }

        return $next($request);
    }
}

// Dans app/Http/Kernel.php, ajouter à $routeMiddleware :
// 'user.redirect' => \App\Http\Middleware\RedirectBasedOnUserType::class,
