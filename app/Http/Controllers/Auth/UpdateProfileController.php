<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends Controller
{
    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');

    }


}
