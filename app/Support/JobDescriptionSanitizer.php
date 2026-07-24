<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class JobDescriptionSanitizer
{
    private static ?HtmlSanitizer $sanitizer = null;

    public static function clean(string $html): string
    {
        return self::sanitizer()->sanitize($html);
    }

    public static function isEmpty(string $html): bool
    {
        return trim(strip_tags($html)) === '';
    }

    private static function sanitizer(): HtmlSanitizer
    {
        if (self::$sanitizer !== null) {
            return self::$sanitizer;
        }

        $config = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowRelativeLinks()
            ->allowElement('span', ['style'])
            ->allowAttribute('span', 'style', ['color', 'background-color']);

        self::$sanitizer = new HtmlSanitizer($config);

        return self::$sanitizer;
    }
}
