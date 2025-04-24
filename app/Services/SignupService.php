<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function registerUser(string $email, string $password)
    {
        return User::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
