<?php

namespace App\Http\Controllers;

use App\Support\AppLogger;
use Illuminate\Http\Request;

abstract class Controller
{
    protected function logDebug(string $message, array $context = []): void
    {
        AppLogger::debug($message, $context);
    }

    protected function logInfo(string $message, array $context = []): void
    {
        AppLogger::info($message, $context);
    }

    protected function logWarning(string $message, array $context = []): void
    {
        AppLogger::warning($message, $context);
    }

    protected function logError(string $message, array $context = []): void
    {
        AppLogger::error($message, $context);
    }

    protected function sanitizedInput(?Request $request = null): array
    {
        return AppLogger::sanitize(($request ?? request())->all());
    }
}
