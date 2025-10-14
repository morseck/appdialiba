<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Définir les langues disponibles
        $availableLocales = ['fr', 'ar'];

        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}
