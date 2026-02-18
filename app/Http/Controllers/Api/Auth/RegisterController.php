<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /**
     * Handle the incoming registration request.
     */
    public function register(RegisterRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        // Return a success response
        return ApiResponse::success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'User registered successfully', 201);
    }
}
