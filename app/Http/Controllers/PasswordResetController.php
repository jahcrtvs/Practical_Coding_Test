<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password email entry form.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the user's email (log it for testing).
     */
    public function sendResetLink(Request $request)
    {
        // 1. Validate that the email exists in our system
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // 2. Generate a secure, unique, and random 64-character token
        $token = Str::random(64);

        // 3. Store the token in the password_reset_tokens table with a timestamp
        // updateOrInsert prevents duplicate entries for the same email
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // 4. Generate the fully qualified reset URL with the token and email
        $resetUrl = route('password.reset', ['token' => $token]) . '?email=' . urlencode($request->email);
        
        // 5. Dispatch a real email using Gmail SMTP as configured in .env
        // The email contains a modern HTML template with the one-time authorization link
        \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($request, $resetUrl) {
            $message->to($request->email)
                ->subject('Password Reset Request')
                ->html("
                    <div style='font-family: sans-serif; background: #000; color: #fff; padding: 40px; border: 1px solid #333;'>
                        <h1 style='text-transform: uppercase; letter-spacing: 2px;'>Security Update</h1>
                        <p style='color: #888; font-style: italic;'>You requested a password reset for the Practical Test App.</p>
                        <hr style='border: 0; border-top: 1px solid #222; margin: 30px 0;'>
                        <p>Click the button below to authorize and update your security credentials:</p>
                        <a href='{$resetUrl}' style='display: inline-block; background: #fff; color: #000; padding: 15px 30px; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px;'>Reset Password</a>
                        <p style='margin-top: 40px; color: #444; font-size: 11px;'>If you did not request this, please ignore this email.</p>
                    </div>
                ");
        });

        return back()->with('success', 'A real reset link has been sent to your email address. Please check your inbox or spam folder.');
    }

    /**
     * Show the password reset form.
     */
    public function showResetForm($token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Update the user's password.
     */
    public function resetPassword(Request $request)
    {
        // 1. Validate inputs, ensuring the reset password matches confirmation
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Verify that the token and email record exists in our database
        $record = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // 3. Security: Token expiry check (Tokens are valid for only 60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Reset link has expired.']);
        }

        // 4. Update user password using the mandatory password_hash() method
        User::where('email', $request->email)->update([
            'password' => password_hash($request->password, PASSWORD_BCRYPT)
        ]);

        // 5. Invalidate the token by removing it from the database after a successful reset
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('success', 'Your password has been successfully reset.');
    }
}
