<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    public function index()
    {
        Gate::authorize('view-any', Role::class);

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(CreateRoleRequest $request)
    {
        Gate::authorize('view', Role::class);

        $role = Role::create($request->validated());

        // Sync permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return back()->with('success', 'Role created successfully.');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('update', $role);

        $role->update(['role' => $request->role]);

        // Sync permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return back()->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);
        $role->delete();
        return back()->with('success', 'Role Deleted successfully.');
    }
}
