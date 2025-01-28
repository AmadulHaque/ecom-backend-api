<?php

namespace App\Modules\RolePermission\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\RolePermission\Requests\UserRequest;
use App\Modules\RolePermission\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAdmins($request);

        return view('RolePermission::users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get();
        $groupedPermissions = Permission::select('group_name', 'id', 'name')
            ->orderBy('group_name')->get()->groupBy('group_name');

        return view('RolePermission::users.create', compact('roles', 'groupedPermissions'));
    }

    public function store(UserRequest $request)
    {
        $this->userService->createAdmin($request->validated());

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $roles = Role::get();
        $user = $this->userService->getAdminById($id);

        $groupedPermissions = Permission::select('group_name', 'id', 'name')
            ->orderBy('group_name')->get()->groupBy('group_name');

        return view('RolePermission::users.edit', compact('user', 'roles', 'groupedPermissions'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->userService->updateAdmin($request->validated(), $id);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $this->userService->deleteAdmin($id);

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
