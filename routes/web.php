<?php

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\VerifyAccountController;
use App\Http\Controllers\Auth\PasswordLessLoginController;
use App\Http\Controllers\Auth\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/', 'welcome');

// Temporary route for testing profile without authentication
Route::get('test-profile', [ProfileController::class, 'index'])->name('test-profile');


Route::middleware('guest')->group(function () {


    /*  Social Login Routes  */
    Route::controller(SocialAuthController::class)->prefix('auth')->group(function () {
        Route::get('/{provider}/redirect', 'redirect')->name('social-auth.redirect');
        Route::get('/{provider}/callback', 'callback')->name('social-auth.callback');
    });


    /*   Login Routes  */
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'handleLogin')->name('login');
    });

    /*   Register Routes  */
    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register')->name('register');
    });

    /*   ForgetPassword Routes  */
    Route::controller(ForgetPasswordController::class)->group(function () {
        Route::get('forget-password', 'showForgetPasswordForm')->name('forget-password.email');
        Route::post('forget-password', 'sendResetLink')->name('forget-password.submit');
    });

    /* Reset Password */
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}/{email}', 'showResetPasswordForm')->name('show-reset-password-form');
        Route::post('reset-password', 'resetPassword')->name('reset-password.submit');
    });


    /*  Verify Account */
    Route::controller(VerifyAccountController::class)->group(function () {
        Route::get('verify-account/{identifier}', 'showVerifyForm')->name('account-verify');
        Route::post('verify-account', 'verifyOtp')->name('verify-account.submit');

        /* WhatsApp Verification otp */
        Route::post('send-verification-otp', 'SendOtp')->name('send-verification-otp');
    });

    /* Password Less Login */
    Route::controller(PasswordLessLoginController::class)->group(function () {
        Route::get('password-less-login', 'showForm')->name('password-less-login.show');
        Route::post('password-less-login', 'sendLink');
        Route::get('password-less-login/{user}', 'loginHandler')->name('password-less-login.handler')->middleware('signed');
    });
});


/* ########################## Protected Routes ########################## */


/* Profile Routes */
Route::middleware(['auth'])->group(function () {

    //    Route::view('profile', 'auth.profile')->name('profile');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('update-profile', [UpdateProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    //    Route::post('logout/{session}', [LoginController::class, 'logoutDevice'])->name('logout-device');
    Route::post('logout/{session}', [LoginController::class, 'logoutDevice'])->name('logout-device');
});