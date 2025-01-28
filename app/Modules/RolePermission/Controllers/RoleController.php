<?php

namespace App\Modules\RolePermission\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('RolePermission::roles.index', compact('roles'));
    }

    public function create()
    {
        $groupedPermissions = Permission::select('group_name', 'id', 'name')
            ->orderBy('group_name')->get()->groupBy('group_name');

        return view('RolePermission::roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required|in:web,admin',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);
        $role = Role::create($data);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $groupedPermissions = Permission::select('group_name', 'id', 'name')
            ->orderBy('group_name')->get()->groupBy('group_name');

        return view('RolePermission::roles.edit', compact('role', 'groupedPermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'guard_name' => 'required|in:web,admin',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ]);
        $role->update($data);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
