<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /// Helper method for successful responses
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }


    /// Helper method for error responses
    public static function error(string $error, mixed $errors = null, int $status = 400): JsonResponse
    {
        $payload = [
            'success' => false,
            'error' => $error,
        ];

        if ($errors !== null) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }
}
