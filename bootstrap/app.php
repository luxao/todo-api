<?php

use App\Http\Middleware\AlwaysAcceptJson;
use App\Support\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(AlwaysAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //Validation errors (FormRequest / validate())
        $exceptions->render(function (ValidationException $e) {

            return ApiResponse::error(
                'Validation failed',
                $e->errors(),
                400
            );
        });

        // 401 Not authenticated (auth middleware)
        $exceptions->render(function (AuthenticationException $e) {
            return ApiResponse::error('Unauthenticated', null, 401);
        });

        // 404 Route not found
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    'Resource not found',
                    null,
                    404
                );
            }
        });
    })->create();
