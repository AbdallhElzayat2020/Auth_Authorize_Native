<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyAccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => random_int(100000, 999999),
        ]);

        Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));

        return to_route('account-verify', $user->email)
            ->with('success', 'Registration successful, please verify your email address.');
    }
}
