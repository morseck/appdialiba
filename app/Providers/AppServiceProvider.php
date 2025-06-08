<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Helper global pour vérifier les rôles de manière sécurisée
        if (!function_exists('user_has_role')) {
            function user_has_role($role) {
                if (!auth()->check()) {
                    return false;
                }

                $user = auth()->user();
                if (!$user->relationLoaded('roles')) {
                    $user->load('roles');
                }

                return $user->hasRole($role);
            }
        }

        if (!function_exists('user_has_permission')) {
            function user_has_permission($permission) {
                if (!auth()->check()) {
                    return false;
                }

                $user = auth()->user();
                if (!$user->relationLoaded('roles')) {
                    $user->load('roles.permissions');
                }

                return $user->hasPermission($permission);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
