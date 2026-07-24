<?php

use App\Http\Middleware\LogHttpRequests;
use App\Support\AppLogger;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            LogHttpRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->context(fn () => [
            'user_id' => auth()->id(),
        ]);

        $exceptions->render(function (ValidationException $e, $request) {
            AppLogger::warning('Validation failed', [
                'errors' => $e->errors(),
                'input' => AppLogger::sanitize($request->all()),
            ]);

            return null;
        });

        $exceptions->render(function (HttpExceptionInterface $e, $request) {
            AppLogger::warning('HTTP exception', [
                'status' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ]);

            return null;
        });
    })->create();
