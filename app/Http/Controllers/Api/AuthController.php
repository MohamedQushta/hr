<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Role;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('register');
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
            'role_id' => $request->role_id,
        ]);
        if (!$user) {
            return response()->json(["result" => 'false', 'message' => 'Failed to Store User'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(["result" => 'true', 'message' => 'User Created', 'roles' => $user], Response::HTTP_CREATED);
    }
}
