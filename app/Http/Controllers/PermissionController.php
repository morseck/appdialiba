<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $showPageTitle = true;
        $permissions = Permission::with('roles')->paginate(10);
        return view('admin.permissions.index', compact('permissions' ,'showPageTitle'));
    }

    public function create()
    {
        $showPageTitle = true;
        return view('admin.permissions.create', compact('showPageTitle'));
    }

    public function store(Request $request)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|unique:permissions|max:255',
            'display_name' => 'nullable|max:255',
            'description' => 'nullable|max:1000'
        ]);

        Permission::create($request->only(['name', 'display_name', 'description']));

        return redirect()->route('permissions.index')->with('success', 'Permission créée avec succès!');
    }

    public function show(Permission $permission)
    {
        $showPageTitle = true;
        $permission->load('roles');
        return view('admin.permissions.show', compact('permission','showPageTitle'));
    }

    public function edit(Permission $permission)
    {
        $showPageTitle = true;
        return view('admin.permissions.edit', compact('permission','showPageTitle'));
    }

    public function update(Request $request, Permission $permission)
    {
        $showPageTitle = true;
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,'.$permission->id.'|max:255',
            'display_name' => 'nullable|max:255',
            'description' => 'nullable|max:1000'
        ]);

        $permission->update($request->only(['name', 'display_name', 'description']));

        return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès!');
    }

    public function destroy(Permission $permission)
    {
        $showPageTitle = true;
        // Vérifier si la permission est utilisée par des rôles
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permissions.index')->with('error', 'Impossible de supprimer cette permission car elle est assignée à des rôles.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission supprimée avec succès!');
    }
}
