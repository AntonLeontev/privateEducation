<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case init = 'init';
    case success = 'success';
    case declined = 'declined';
    case canceled = 'canceled';

    public function toString(): string
    {
        return match ($this) {
            self::init => 'Создана',
            self::success => 'Успешно',
            self::declined => 'Не успешно',
            self::canceled => 'Отменено',
        };
    }
}
