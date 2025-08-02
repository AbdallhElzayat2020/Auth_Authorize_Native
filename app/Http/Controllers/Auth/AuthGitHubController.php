<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthGitHubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {

        $googleUser = Socialite::driver('github')->stateless()->user();

        $user = User::firstOrCreate(

            ['email' => $googleUser->getEmail()],

            [
                'name' => $googleUser->getName(),
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'otp' => rand(100000, 999999),
            ]
        );

        Auth::login($user);
        return redirect()->intended(route('profile'))->with('success', 'Login successful');
    }
}
