<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        Auth::user()->profiles()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Profile created successfully!');
    }

    public function edit(Profile $profile)
    {
        // Security: Ensure the user owns this profile or is an admin
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        // Security: Ensure the user owns this profile or is an admin
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $profile->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request, Profile $profile)
    {
        // Security: Ensure the user owns this profile or is an admin
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate password for deletion confirmation
        $request->validate([
            'password' => 'required',
        ]);

        if (!password_verify($request->password, Auth::user()->password)) {
            return back()->withErrors(['deletion_password' => 'Incorrect password. Deletion cancelled.'])->with('error_profile_id', $profile->id);
        }

        $profile->delete();

        return redirect()->route('dashboard')->with('success', 'Profile deleted successfully!');
    }
}
