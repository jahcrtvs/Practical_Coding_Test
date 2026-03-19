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
        // Security Check: Access is granted only if the user owns the profile
        // OR if the user has an 'admin' role (RBAC bonus feature).
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        // Security Check: verify ownership or admin privileges before allowing updates
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Server-side validation of profile data
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        // Persist changes to the database using Eloquent (PDO-safe)
        $profile->update($validated);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request, Profile $profile)
    {
        // Security Check: verify authorization for deletion
        if ($profile->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Additional Security: Users must confirm their password to finalize deletion.
        // This prevents accidental or unauthorized "one-click" deletions.
        $request->validate([
            'password' => 'required',
        ]);

        // Verify the provided password using the mandatory password_verify() function
        if (!password_verify($request->password, Auth::user()->password)) {
            return back()->withErrors(['deletion_password' => 'Incorrect password. Deletion cancelled.'])->with('error_profile_id', $profile->id);
        }

        // Perform the deletion
        $profile->delete();

        return redirect()->route('dashboard')->with('success', 'Profile deleted successfully!');
    }
}
