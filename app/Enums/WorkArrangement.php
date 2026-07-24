<?php

namespace App\Enums;

enum WorkArrangement: string
{
    case Onsite = 'Onsite';
    case Hybrid = 'Hybrid';
    case Remote = 'Remote';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
