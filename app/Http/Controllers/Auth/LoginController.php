<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\VerifyAccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::whereEmail($request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with(['error' => 'Invalid credentials']);
        }

        if (!$user->email_verified_at) {

            Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));

            return to_route('email-verify', $user->email)
                ->with('error', 'Please verify your email address before logging in. A verification email has been sent to your email address.');
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('profile')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->with(['error' => 'Invalid credentials'])->withInput($request->only('email'));

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
