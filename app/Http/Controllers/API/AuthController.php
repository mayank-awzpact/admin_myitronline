<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Claims\Factory as ClaimsFactory;
use Tymon\JWTAuth\Manager;
use Carbon\Carbon;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }

    // Logout API
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    // Get Authenticated User
    public function me()
    {
        return response()->json(Auth::user());
    }

    // Refresh Token
    public function refresh()
    {
        return response()->json([
            'token' => JWTAuth::refresh(),
        ]);
    }

    public function generateToken()
{
    $user = User::where('email', 'developerdev@gmail.com')->first();  // Example using email
 // example user

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $ttl = (int) env('JWT_TTL', 60);  // ✅ (int) casting added
    $expiration = Carbon::now()->addMinutes($ttl);

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'token' => $token,
        'expires_at' => $expiration,
    ]);
}
}
