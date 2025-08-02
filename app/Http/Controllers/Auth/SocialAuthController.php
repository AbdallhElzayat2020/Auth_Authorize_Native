<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        if (!in_array($provider, ['facebook', 'google', 'github'])) {
            return to_route('login')->with('error', 'Invalid social driver');
        }


        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        if (!in_array($provider, ['facebook', 'google', 'github'])) {
            return to_route('login')->with('error', 'Invalid social driver');
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $exception) {
            return to_route('login')->with('error', 'Failed to authenticate');
        }

        $user = User::firstOrCreate(

            ['email' => $socialUser->getEmail()],

            [
                'name' => $socialUser->getName(),
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'otp' => rand(100000, 999999),
            ]
        );

        Auth::login($user);
        return redirect()->intended(route('profile'))->with('success', 'Login successful');
    }
}
