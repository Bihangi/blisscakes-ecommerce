<?php

namespace App\Exceptions;

use Exception;

class TwoFactorAuthenticationException extends Exception
{
    public function render($request)
    {
        return redirect()->route('two-factor.login');
    }
}