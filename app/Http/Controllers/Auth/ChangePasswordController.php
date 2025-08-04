<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {

            return redirect()->back()->with(['error' => 'The provided password does not match your current password.']);
        }
        $user->update(['password' => Hash::make($request->new_password)]);

        Auth::login($user);

        return redirect()->back()->with('success', 'Password updated successfully.');

    }
}
