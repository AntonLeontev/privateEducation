<?php

namespace App\Support\Enums;

enum AdminRole: string
{
    case admin = 'admin';
    case seo = 'seo';

    public static function values(): array
    {
        $result = [];

        foreach (self::cases() as $case) {
            $result[] = $case->value;
        }

        return $result;
    }
}
