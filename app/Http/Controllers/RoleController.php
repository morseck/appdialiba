<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $showPageTitle = true;
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles', 'showPageTitle'));
    }

    public function create()
    {
        $showPageTitle = true;
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions', 'showPageTitle'));
    }

    public function store(Request $request)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|unique:roles|max:255',
            'display_name' => 'nullable|max:255',
            'description' => 'nullable|max:1000',
            'permissions' => 'array'
        ]);

        $role = Role::create($request->only(['name', 'display_name', 'description']));

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès!');
    }

    public function show(Role $role)
    {
        $showPageTitle = true;
        $role->load('permissions', 'users');
        return view('admin.roles.show', compact('role', 'showPageTitle'));
    }

    public function edit(Role $role)
    {
        $showPageTitle = true;
        $permissions = Permission::all();
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions', 'showPageTitle'));
    }

    public function update(Request $request, Role $role)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id.'|max:255',
            'display_name' => 'nullable|max:255',
            'description' => 'nullable|max:1000',
            'permissions' => 'array'
        ]);

        $role->update($request->only(['name', 'display_name', 'description']));

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);

                log_transaction($role, 'assign_or_remove_permissions', json_encode($role->permissions()->select('permissions.id')->get()
                ), json_encode($request->permissions), 'Assignation ou revocation de permissions à role', json_encode([
                'role' => $role->name,
            ]));
        } else {
            $role->permissions()->detach();
            $role->permissions()->sync($request->permissions);
            log_transaction($role, 'assign_permissions', json_encode($role->permissions()->select('permissions.id')->get()
            ), json_encode($request->permissions), 'Assignation de permissions à role', json_encode([
                'role' => $role->name,
            ]));
        }

        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès!');
    }

    public function destroy(Role $role)
    {
        $showPageTitle = true;
        // Vérifier si le rôle est utilisé par des utilisateurs
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Impossible de supprimer ce rôle car il est assigné à des utilisateurs.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès!');
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->permissions()->sync($request->permissions);

        log_transaction($role, 'assign_or_remove_role', json_encode($role->permissions()->select('permissions.id')->get()
        ), json_encode($request->permissions), 'Assignation ou revocation de role à utilisation', json_encode([
            'role' => $role->name,
        ]));

        return redirect()->back()->with('success', 'Permissions assignées avec succès!');
    }

    public function removePermission(Role $role, Permission $permission)
    {
        $showPageTitle = true;
        $role->permissions()->detach($permission->id);

        return redirect()->back()->with('success', 'Permission retirée avec succès!');
    }
}
