<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::get('/test-token', function () {
        return response()->json(['message' => 'Token is valid! Access granted.']);
    });
});
