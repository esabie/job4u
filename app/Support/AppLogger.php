<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AppLogger
{
    private const SENSITIVE_KEYS = [
        'password',
        'password_confirmation',
        'current_password',
        'token',
        'remember_token',
    ];

    public static function debug(string $message, array $context = []): void
    {
        Log::debug($message, self::context($context));
    }

    public static function info(string $message, array $context = []): void
    {
        Log::info($message, self::context($context));
    }

    public static function warning(string $message, array $context = []): void
    {
        Log::warning($message, self::context($context));
    }

    public static function error(string $message, array $context = []): void
    {
        Log::error($message, self::context($context));
    }

    public static function sanitize(array $data): array
    {
        foreach (self::SENSITIVE_KEYS as $key) {
            if (array_key_exists($key, $data)) {
                $data[$key] = '[redacted]';
            }
        }

        return $data;
    }

    private static function context(array $context): array
    {
        $request = request();

        return array_merge([
            'request_id' => $request?->attributes->get('request_id'),
            'user_id' => Auth::id(),
            'route' => Route::currentRouteName(),
            'method' => $request?->method(),
            'path' => $request?->path(),
        ], $context);
    }
}
