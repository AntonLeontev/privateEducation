<?php

namespace App\Support\ValueObjects;

use App\Enums\Currency;
use App\Exceptions\Support\PriceException;
use JsonSerializable;

readonly class Price implements JsonSerializable
{
    public function __construct(public int $amount, public Currency $currency = Currency::eur)
    {
        if ($amount < 0) {
            throw new PriceException('Amount must be greater than zero');
        }
    }

    public function jsonSerialize(): array
    {
        if ($this->currency !== Currency::eur) {
            return [
                'amount' => $this->amount(),
                'currency' => $this->currency,
            ];
        }

        if (loc() === 'ru') {
            return [
                'amount' => round($this->amount() * eur_rub_rate(), 2),
                'currency' => Currency::rub,
                'raw' => [
                    'amount' => $this->amount(),
                    'currency' => $this->currency,
                ],
            ];
        }

        if (loc() === 'en') {
            return [
                'amount' => round($this->amount() * eur_usd_rate(), 2),
                'currency' => Currency::usd,
                'raw' => [
                    'amount' => $this->amount(),
                    'currency' => $this->currency,
                ],
            ];
        }

        throw new \Exception('Unknown locale or currency', 1);
    }

    public function amount(): int|float
    {
        return $this->amount / 100;
    }

    public function __toString(): string
    {
        return $this->amount().' '.$this->currency->getSign();
    }
}
