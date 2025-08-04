<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(CreateRoleRequest $request)
    {
        $role = Role::create($request->validated());

        return back()->with('success', 'Role created successfully.');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role Deleted successfully.');

    }
}
