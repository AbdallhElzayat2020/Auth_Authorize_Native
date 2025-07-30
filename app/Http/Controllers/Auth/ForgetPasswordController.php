<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendResetLinkMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgetPasswordController extends Controller
{

    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');
    }

    public function sendResetLink(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email', 'string', 'max:255'],
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::to($request->email)->send(new SendResetLinkMail($token, $request->email));

        return redirect()->back()->with('success', 'We have sent a link to reset your password.');
    }
}
