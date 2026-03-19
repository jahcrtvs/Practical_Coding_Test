<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard with their profiles.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Admins see all profiles, regular users see only theirs
        if ($user->isAdmin()) {
            $profiles = \App\Models\Profile::with('user')->latest()->get();
        } else {
            $profiles = $user->profiles()->latest()->get();
        }

        return view('dashboard', compact('profiles'));
    }
}
