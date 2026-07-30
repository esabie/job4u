<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Applied = 'applied';
    case Shortlisted = 'shortlisted';
    case Interview = 'interview';
    case Rejected = 'rejected';
    case Hired = 'hired';

    public function label(): string
    {
        return match ($this) {
            self::Applied => 'Applied',
            self::Shortlisted => 'Shortlisted',
            self::Interview => 'Interview',
            self::Rejected => 'Rejected',
            self::Hired => 'Hired',
        };
    }

    public function employerLabel(): string
    {
        return match ($this) {
            self::Applied => 'Review',
            self::Shortlisted => 'Shortlist',
            self::Interview => 'Interview',
            self::Rejected => 'Rejected',
            self::Hired => 'Hired',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Applied => 'bg-blue-100 text-blue-700',
            self::Shortlisted => 'bg-yellow-100 text-yellow-700',
            self::Interview => 'bg-purple-100 text-purple-700',
            self::Rejected => 'bg-red-100 text-red-700',
            self::Hired => 'bg-green-100 text-green-700',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function tryFromMixed(?string $value): ?self
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value === 'new') {
            return self::Applied;
        }

        return self::tryFrom($value);
    }
}
