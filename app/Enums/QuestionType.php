<?php

namespace App\Enums;

enum QuestionType: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case YesNo = 'yes_no';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'Short answer',
            self::Textarea => 'Long answer',
            self::YesNo => 'Yes / No',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
