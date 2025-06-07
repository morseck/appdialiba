<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $showPageTitle = true;
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users', 'showPageTitle'));
    }

    public function create()
    {
        $showPageTitle = true;
        $roles = Role::all();
        return view('admin.users.create', compact('roles', 'showPageTitle'));
    }

    public function store(Request $request)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'is_admin' => 'boolean',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin') ? 1 : 0,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès!');
    }

    public function show(User $user)
    {
        $showPageTitle = true;
        $user->load('roles.permissions');
        return view('admin.users.show', compact('user', 'showPageTitle'));
    }

    public function edit(User $user)
    {
        $showPageTitle = true;
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles', 'showPageTitle'));
    }

    public function update(Request $request, User $user)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id.'|max:255',
            'password' => 'nullable|min:6|confirmed',
            'is_admin' => 'boolean',
            'roles' => 'array'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    public function destroy(User $user)
    {
        $showPageTitle = true;
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }

    public function assignRoles(Request $request, User $user)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->back()->with('success', 'Rôles assignés avec succès!');
    }

    public function removeRole(User $user, Role $role)
    {
        $showPageTitle = true;
        $user->roles()->detach($role->id);

        return redirect()->back()->with('success', 'Rôle retiré avec succès!');
    }
}
