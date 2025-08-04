<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\ChangeUserRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function changeRole(ChangeUserRoleRequest $request, User $user)
    {
        $user->roles()->sync($request->role_ids);

        return back()->with('success', 'User roles updated successfully.');
    }
}
