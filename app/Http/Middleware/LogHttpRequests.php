<?php

namespace App\Http\Middleware;

use App\Support\AppLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogHttpRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = (string) Str::uuid();
        $request->attributes->set('request_id', $requestId);

        $start = microtime(true);

        AppLogger::debug('HTTP request received', [
            'request_id' => $requestId,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'input' => AppLogger::sanitize($request->all()),
        ]);

        $response = $next($request);

        AppLogger::debug('HTTP response sent', [
            'request_id' => $requestId,
            'status' => $response->getStatusCode(),
            'duration_ms' => round((microtime(true) - $start) * 1000, 2),
        ]);

        return $response;
    }
}
