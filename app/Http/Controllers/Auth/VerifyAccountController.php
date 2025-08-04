<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationOtpRequest;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Mail\VerifyAccountMail;
use App\Models\User;
use App\Services\PhoneVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerifyAccountController extends Controller
{

    public function __construct(public PhoneVerificationService $phoneVerificationService)
    {

    }

    public function showVerifyForm($identifier)
    {
        return view('auth.verify-account', ['identifier' => $identifier]);
    }

    public function verifyOtp(VerifyAccountRequest $request): \Illuminate\Http\RedirectResponse
    {

        $user = User::whereEmail($request->identifier)
            ->orWhere('phone', $request->identifier)
            ->first();

        // or
        //        $type = filter_var($request->input('identifier'), FILTER_VALIDATE_EMAIL) ? 'email': 'phone';
        // $user = User::where($type, $request->identifier)->first();

        if (!$user) {
            return back()->with(['error' => 'Email not found.']);
        }

        $otp = implode($request->otp);
        if ($user->otp !== $otp) {
            return back()->with('error', 'Invalid OTP or account data');
        }

        $user->account_verified_at = now();
        $user->save();

        return to_route('login')
            ->with('success', 'Account verified successfully, you can now login.');
    }


    public function SendOtp(SendVerificationOtpRequest $request)
    {
        $user = User::whereEmail($request->identifier)
            ->orWhere('phone', $request->identifier)
            ->first();

        if ($user->account_verified_at) {
            return redirect()->to('login')->with('error', 'Your account is already verified.');
        }
        if ($request->type === 'email') {

            Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));
        }
        if ($request->type === 'phone') {
            if (!$user->phone || $user->phone === '') {
                return back()->with('error', 'Your account does not have a phone number');
            }

            try {
                $response = $this->phoneVerificationService->sendOtpMessage($user->phone, $user->otp);
                if ($response->failed()) {
                    Log::info($response);
                    return back()->with('error', 'Failed to send OTP via WhatsApp. Please try again later.');
                }
            } catch (\Exception $exception) {
                return back()->with('error', 'Failed to send OTP via WhatsApp. Please try again later.' . $exception->getMessage());
            }
        }

        return to_route('account-verify', $request->type === 'phone' ? $user->phone : $user->email)
            ->with('success', 'Verification OTP sent successfully, please check your ' . $request->type . '.');

    }
}





