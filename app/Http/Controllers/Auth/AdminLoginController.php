<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
        
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();
            
            // Only allow admin login
            if ($user->user_type === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Admin!');
            } else {
                Auth::logout();
                
                return back()->withErrors([
                    'email' => 'These credentials do not belong to an admin account.',
                ])->withInput($request->only('email'));
            }
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
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
}