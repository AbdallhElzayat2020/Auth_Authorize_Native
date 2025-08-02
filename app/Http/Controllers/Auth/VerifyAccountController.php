<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyAccountController extends Controller
{
    public function showVerifyForm($email)
    {
        return view('auth.verify-account', ['email' => $email]);
    }

    public function verifyAccount(VerifyAccountRequest $request)
    {
        $otp = implode($request->otp);
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return back()->with(['error' => 'Email not found.']);
        }

        if ($user->otp !== $otp) {
            return back()->with('error', 'Invalid OTP or email address');
        }

        $user->email_verified_at = now();
        $user->save();

        return to_route('login')
            ->with('success', 'Email verified successfully, you can now login.');
    }
}
