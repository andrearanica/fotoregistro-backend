<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAuthenticatedUser
{
    /**
     * Check if user's ID is the one specified in the request
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = JWTAUth::parseToken()->authenticate()) {
            if ($user->id == $request->route('id')) {
                return $next($request);
            } else {
                return response()->json(['message' => "Not authorized"], 403);
            }
        }
        return response()->json(['message' => 'Not authorized'], 403);
    }
}
