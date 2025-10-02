<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register custom login response
        $this->app->singleton(LoginResponse::class, \App\Http\Responses\LoginResponse::class);
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Custom authentication with 2FA
        Fortify::authenticateUsing(function (Request $request) {
            $credentials = $request->only('email', 'password');
            $user = \App\Models\User::where('email', $request->email)->first();

            if (!$user || !\Hash::check($request->password, $user->password)) {
                return null;
            }

            // Prevent admin from customer login
            if (!$request->is('admin/*') && $user->user_type === 'admin') {
                return null;
            }

            // Handle 2FA
            if ($user->two_factor_enabled) {
                $code = $user->generateTwoFactorCode();

                Mail::send('emails.two-factor-code', ['code' => $code, 'user' => $user], function ($message) use ($user) {
                    $message->to($user->email);
                    $message->subject('Your Login Verification Code - BlissCakes');
                });

                session(['2fa_user_id' => $user->id, '2fa_remember' => $request->filled('remember')]);
                
                // Throw an exception to stop login and redirect
                throw new \App\Exceptions\TwoFactorAuthenticationException('2FA required');
            }

            return $user;
        });
    }
}