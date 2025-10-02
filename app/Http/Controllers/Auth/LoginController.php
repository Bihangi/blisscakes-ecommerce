<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();

            // Reject admin login on customer page
            if ($user->user_type === 'admin' || (method_exists($user, 'isAdmin') && $user->isAdmin())) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Admin accounts cannot log in here. Please use the admin login page.',
                ])->withInput($request->only('email'));
            }

            // Two-Factor Check
            if ($user->two_factor_enabled) {
                Auth::logout();

                // Store their ID in session for verification
                session(['2fa_user_id' => $user->id]);

                // Generate & send 2FA code
                $user->generateTwoFactorCode();
                \Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($user));

                return redirect()->route('two-factor.show');
            }

            // Normal login if no 2FA
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Welcome back!');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}