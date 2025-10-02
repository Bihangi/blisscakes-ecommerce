<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found in our system.']);
        }

        // Delete any existing OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP (expires in 1 minute)
        PasswordResetOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(1),
        ]);

        // Send OTP via email
        Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset OTP - BlissCakes');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify-otp')->with('success', 'OTP sent to your email!');
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $email = session('reset_email');

        $otpRecord = PasswordResetOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('verified', false)
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if ($otpRecord->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Mark OTP as verified
        $otpRecord->update(['verified' => true]);

        session(['otp_verified' => true]);

        return redirect()->route('password.reset-form')->with('success', 'OTP verified! Now set your new password.');
    }

    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('reset_email');

        if (!session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Unauthorized access.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['error' => 'User not found.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear OTP records
        PasswordResetOtp::where('email', $email)->delete();

        // Clear session
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password reset successfully! You can now login with your new password.');
    }

    public function resendOtp()
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        return $this->sendOtp(new Request(['email' => $email]));
    }
}