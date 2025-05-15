<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GlobalHelper
{
    public static function getLoggedInUser(): ?User
    {
        return Auth::user();
    }
}
