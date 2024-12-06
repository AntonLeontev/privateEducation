<?php

namespace App\Enums;

use JsonSerializable;

enum Currency: string implements JsonSerializable
{
    case rub = 'rub';
    case eur = 'eur';
    case usd = 'usd';

    public function getCode(): string
    {
        return match ($this->value) {
            'rub' => 'RUB',
            'eur' => 'EUR',
            'usd' => 'USD',
        };
    }

    public function getSign(): string
    {
        return match ($this->value) {
            'rub' => '₽',
            'eur' => '€',
            'usd' => '$',
        };
    }

    public function jsonSerialize(): mixed
    {
        return $this->getCode();
    }
}
