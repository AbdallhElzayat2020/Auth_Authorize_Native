<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $sessions = collect(); // Initialize empty collection

        if (Auth::check()) {
            $sessions = Session::where('user_id', Auth::id())->orderBy('last_activity', 'desc')->get();
        }

        return view('auth.profile', compact('sessions'));
    }
}