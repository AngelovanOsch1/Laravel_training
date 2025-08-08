<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = env('SECRET');

        if (!$secret || !$request->header('Authorization') || $request->header('Authorization') !== $secret) {
            return response()->json([
                'error' => 'Unauthorized: Invalid token.'
            ], 401);
        }

        return $next($request);
    }
}
