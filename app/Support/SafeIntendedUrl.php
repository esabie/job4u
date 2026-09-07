<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SafeIntendedUrl
{
    /**
     * Store a post-auth redirect from a redirect query/input value when it targets this app.
     */
    public static function rememberFromRequest(Request $request): void
    {
        $redirect = $request->query('redirect', $request->input('redirect'));

        if (! is_string($redirect) || $redirect === '') {
            return;
        }

        $safe = self::sanitize($redirect, $request);

        if ($safe !== null) {
            $request->session()->put('url.intended', $safe);
        }
    }

    public static function sanitize(string $redirect, ?Request $request = null): ?string
    {
        $redirect = trim($redirect);

        if ($redirect === '') {
            return null;
        }

        // Allow relative app paths (optionally with a query/fragment).
        if (str_starts_with($redirect, '/') && ! str_starts_with($redirect, '//')) {
            return $redirect;
        }

        $parts = parse_url($redirect);

        if ($parts === false || empty($parts['host'])) {
            return null;
        }

        if (! self::isAllowedHost($parts['host'], $request)) {
            return null;
        }

        $path = $parts['path'] ?? '/';

        if ($path === '') {
            $path = '/';
        }

        if (! str_starts_with($path, '/')) {
            $path = '/'.$path;
        }

        if (isset($parts['query'])) {
            $path .= '?'.$parts['query'];
        }

        if (isset($parts['fragment'])) {
            $path .= '#'.$parts['fragment'];
        }

        return $path;
    }

    /**
     * Build a relative return path for a named route (safe to put in ?redirect=).
     */
    public static function forRoute(string $name, mixed $parameters = [], string $fragment = ''): string
    {
        $path = route($name, $parameters, absolute: false);

        if ($fragment !== '') {
            $path .= '#'.ltrim($fragment, '#');
        }

        return $path;
    }

    private static function isAllowedHost(string $host, ?Request $request): bool
    {
        $allowed = collect([
            $request?->getHost(),
            parse_url((string) config('app.url'), PHP_URL_HOST),
            'localhost',
            '127.0.0.1',
        ])
            ->filter()
            ->map(fn ($value) => Str::lower((string) $value))
            ->unique()
            ->all();

        return in_array(Str::lower($host), $allowed, true);
    }
}
