<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UpdateProfileController;
use App\Http\Controllers\Auth\ChangePasswordController;


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

});


/* ########################## Protected Routes ########################## */


Route::middleware(['auth'])->group(function () {

    Route::view('profile', 'auth.profile')->name('profile');
    Route::put('update-profile', [UpdateProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

});