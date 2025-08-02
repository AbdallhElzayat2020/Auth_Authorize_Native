<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordLessRequest;
use App\Mail\PasswordLessLinkMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordLessLoginController extends Controller
{
    public function showForm()
    {
        return view('auth.passwordless-login');
    }

    public function sendLink(PasswordLessRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = User::whereEmail($request->email)->first();

        $url = URL::temporarySignedRoute(
            'password-less-login.handler', now()->addMinutes(10), ['user' => $user->id]
        );

        Mail::to($user->email)->send(new PasswordLessLinkMail($url));

        return back()->with('success', 'A login link has been sent to your email address. Please check your inbox.');

    }

    public function loginHandler(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        Auth::login($user);
        return redirect()->intended('profile')->with('success', 'Logged in successfully!');
    }
}
