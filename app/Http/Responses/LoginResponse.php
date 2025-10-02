<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if (session('2fa_user_id')) {
            return redirect()->route('two-factor.login');
        }

        $user = auth()->user();
        
        if ($user->user_type === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return redirect()->intended(route('home'));
    }
}