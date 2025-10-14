<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $availableLocales = ['fr', 'ar'];
        $defaultLocale = 'fr';

        // Récupérer la langue depuis l'URL
        $locale = $request->route('locale');

        if ($locale && in_array($locale, $availableLocales)) {
            // Langue valide dans l'URL
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Pas de langue dans l'URL, utiliser la session ou défaut
            $sessionLocale = Session::get('locale', $defaultLocale);

            if (in_array($sessionLocale, $availableLocales)) {
                App::setLocale($sessionLocale);
            } else {
                App::setLocale($defaultLocale);
                Session::put('locale', $defaultLocale);
            }
        }

        return $next($request);
    }
}
