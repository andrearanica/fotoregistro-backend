<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUploader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->id() !== (int) $request->id) {
            return response()->json([
                'message' => 'You are not authorized to perform this action'], Response::HTTP_UNAUTHORIZED
            );
        }
        return $next($request);
    }
}
