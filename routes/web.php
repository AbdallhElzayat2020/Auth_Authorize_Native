<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\VerifyAccountController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/', 'welcome');


Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'handleLogin')->name('login');
    });


    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('register', 'register')->name('register');
    });

    Route::controller(ForgetPasswordController::class)->group(function () {
        Route::get('forget-password', 'showForgetPasswordForm')->name('forget-password.email');
        Route::post('forget-password', 'sendResetLink')->name('forget-password.submit');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}/{email}', 'showResetPasswordForm')->name('show-reset-password-form');
        Route::post('reset-password', 'resetPassword')->name('reset-password.submit');
    });

    Route::controller(VerifyAccountController::class)->group(function () {
        Route::get('verify-account/{email}', 'showVerifyForm')->name('email-verify');
        Route::post('verify-account', 'verifyAccount')->name('verify-account.submit');
    });

});


/* ########################## Protected Routes ########################## */


Route::middleware(['auth'])->group(function () {

    Route::view('profile', 'auth.profile')->name('profile');
    Route::put('update-profile', [UpdateProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});
