<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle($request, Closure $next)
    // {
    //     $token = $request->header('token');
    //     if (!$token) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
    
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $token = $matches[1]; // Extracted token from "Bearer <token>"
        $validToken = config('services.api_token') ?: env('API_TOKEN');

        if (empty($validToken) || ! hash_equals((string) $validToken, (string) $token)) {
            return response()->json(['error' => 'Invalid Token'], 401);
        }

        return $next($request);
    }
}
