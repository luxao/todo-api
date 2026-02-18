<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming login request.
     */
    public function login(LoginRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // find the user by email
        $user = User::where('email', $validatedData['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return ApiResponse::error('Invalid credentials', null, 401);
        }

        // Create a new token for the user
        $token = $user->createToken('api')->plainTextToken;

        return ApiResponse::success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Login successful');
    }

    /**
     * Logout the authenticated user by deleting their current access token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return ApiResponse::success(null, 'Logged out', 200);
    }
}
