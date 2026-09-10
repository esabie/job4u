<?php

use App\Http\Middleware\LogHttpRequests;
use App\Support\AppLogger;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            LogHttpRequests::class,
            'throttle:global',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->context(fn () => [
            'user_id' => auth()->id(),
        ]);

        $exceptions->render(function (ValidationException $e, Request $request) {
            AppLogger::warning('Validation failed', [
                'errors' => $e->errors(),
                'input' => AppLogger::sanitize($request->all()),
            ]);

            return null;
        });

        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            AppLogger::warning('CSRF token mismatch / session expired', [
                'path' => $request->path(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your session expired due to inactivity. Please refresh the page and try again.',
                ], 419);
            }

            return response()->view('errors.419', status: 419);
        });

        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            AppLogger::warning('Too many requests', [
                'path' => $request->path(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You are doing that too quickly. Please wait a moment and try again.',
                ], 429);
            }

            return response()->view('errors.429', status: 429);
        });

        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            AppLogger::warning('HTTP exception', [
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ]);

            return null;
        });
    })->create();
