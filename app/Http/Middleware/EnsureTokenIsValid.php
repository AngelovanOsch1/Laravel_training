<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Authorization') !== env('SECRET')) {
            return response()->json([
                'error' => 'Unauthorized: Invalid token.'
            ], 401);
        }
        return $next($request);
    }
}
