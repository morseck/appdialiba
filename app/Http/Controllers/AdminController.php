<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $showPageTitle = true;
        $stats = [
            'users_count' => User::count(),
            'roles_count' => Role::count(),
            'permissions_count' => Permission::count(),
            'users_with_roles' => User::has('roles')->count(),
        ];

        $recent_users = User::with('roles')->latest()->take(5)->get();
        $recent_roles = Role::with('permissions')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_roles', 'showPageTitle'));
    }
}
