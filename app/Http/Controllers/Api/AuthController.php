<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }
    public function getAllUsers()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return response()->json(["result" => 'false', 'message' => 'No Users Found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'Users Data', 'users' => $users], Response::HTTP_OK);
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => (int)$request->role_id,
        ]);

        if (!$user) {
            return response()->json(["result" => 'false', 'message' => 'Failed to Store User'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(["result" => 'true', 'message' => 'User Created', 'user' => $user], Response::HTTP_CREATED);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return response()->json(["result" => 'false', 'message' => 'You are unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            "result" => "true",
            'user' => Auth::user(),
            'token' => $token
        ], Response::HTTP_OK);
    }
    public function profile()
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(["result" => 'false', 'message' => 'You are unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json(["result" => 'true', 'message' => 'User Profile', 'user' => $authUser], Response::HTTP_OK);
    }
    public function logout()
    {
        if (!auth()->check())
            return response()->json(["result" => 'false', 'message' => 'You are unauthenticated'], Response::HTTP_UNAUTHORIZED);
        $user = Auth::user();
        auth()->logout();
        return response()->json(["result" => 'true', 'message' => 'User Logged out', 'user' => $user], Response::HTTP_OK);
    }
}
