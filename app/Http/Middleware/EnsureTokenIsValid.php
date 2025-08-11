<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\ResponseResource;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('app.secret');

        if (!$secret) {
            return (new ResponseResource(ResponseResource::NOTOKEN))
                ->response()->setStatusCode(500);
        }

        if (!$request->header('Authorization') || $request->header('Authorization') !== $secret) {
            return (new ResponseResource(ResponseResource::UNAUTHORIZED))
                ->response()
                ->setStatusCode(403);
        }

        return $next($request);
    }
}
