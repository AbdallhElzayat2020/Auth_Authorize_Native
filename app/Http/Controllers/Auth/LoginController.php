<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\VerifyAccountMail;
use App\Models\Session;
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
        
        $user = User::whereEmail($request->identifier)
            ->orWhere('phone', $request->identifier)
            ->first();

        // or if you want to check both email and phone
        //        $type = filter_var($request->input('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        // $user = User::where($type, $request->identifier)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with(['error' => 'Invalid credentials'])->withInput($request->only('identifier'));
        }

        if (!$user->account_verified_at) {

            Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));

            return to_route('account-verify', $user->email)
                ->with('error', 'Please verify your email address before logging in. A verification email has been sent to your email address.');
        }


        Auth::login($user, $request->filled('remember'));

        if ($user->logout_other_devices) {
            Auth::logoutOtherDevices($request->password);
        }

        $urls = [
            'student' => '/student',
            'teacher' => '/teacher',
            'admin' => '/admin',
        ];

        return redirect()->intended($urls[$user->role] ?? '/profile')->with('success', 'Login successful.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function logoutDevice(Request $request, Session $session)
    {
        $session->delete();

        // If the session is the current session, log out the user
        if ($session->id === $request->session()->getId()) {
            Auth::logout();
        }

        return back()->with('success', 'Device logged out successfully');
    }
}
