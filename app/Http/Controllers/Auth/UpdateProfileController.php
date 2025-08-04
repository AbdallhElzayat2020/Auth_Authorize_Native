<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends Controller
{
    public function updateProfile(UpdateProfileRequest $request)
    {

        $user = User::find(Auth::id());

        $data = $request->validated();
        $data['logout_other_devices'] = $request->has('logout_other_devices') ? true : false;
        $user->update($data);

        return back()->with('success', 'Profile updated successfully');

    }


}
