<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TwoFactorAuthController extends Controller
{
    public function show()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(session('2fa_user_id'));
        
        return view('auth.two-factor-challenge', compact('user'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|numeric|digits:6',
        ]);

        $userId = session('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('login')->withErrors(['two_factor_code' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);

        if (!$user || !$user->two_factor_code) {
            return back()->withErrors(['two_factor_code' => 'Invalid request.']);
        }

        if ($user->two_factor_expires_at < now()) {
            return back()->withErrors(['two_factor_code' => 'Code has expired. Please request a new one.']);
        }

        if ($user->two_factor_code !== $request->two_factor_code) {
            return back()->withErrors(['two_factor_code' => 'Invalid verification code.']);
        }

        // Clear 2FA code and login the user
        $user->resetTwoFactorCode();
        Auth::login($user, true);
        
        session()->forget('2fa_user_id');
        session(['2fa_verified' => true]);

        // Redirect based on user type
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        }

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    public function resend()
    {
        $userId = session('2fa_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        $code = $user->generateTwoFactorCode();

        Mail::send('emails.two-factor-code', ['code' => $code, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Your Login Verification Code - BlissCakes');
        });

        return back()->with('success', 'A new code has been sent to your email.');
    }

    public function enable(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = true;
        $user->save();

        return back()->with('success', 'Two-factor authentication enabled successfully.');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->resetTwoFactorCode();
        $user->save();

        return back()->with('success', 'Two-factor authentication disabled successfully.');
    }
}