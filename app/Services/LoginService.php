<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login(string $email, string $password): bool
    {
        $attempt = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if ($attempt) {
            session()->regenerate();
        }

        return $attempt;
    }
}
