<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Fortify;

class AuthenticateLoginAttempt
{
    public function __invoke($request)
    {
        $credentials = $request->only(Fortify::username(), 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Check if 2FA is enabled for this user
            if ($user->two_factor_enabled) {
                // Generate and send 2FA code
                $code = $user->generateTwoFactorCode();

                Mail::send('emails.two-factor-code', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Your Login Verification Code - BlissCakes');
                });

                // Store user ID in session for 2FA verification
                session(['2fa_user_id' => $user->id]);
                
                // Logout temporarily until 2FA is verified
                Auth::logout();

                return redirect()->route('two-factor.login');
            }

            // No 2FA - proceed with normal login
            return redirect()->intended(
                $user->user_type === 'admin' ? route('admin.dashboard') : route('home')
            );
        }

        return back()->withErrors([
            Fortify::username() => 'The provided credentials do not match our records.',
        ])->onlyInput(Fortify::username());
    }
}