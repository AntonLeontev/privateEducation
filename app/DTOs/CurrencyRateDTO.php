<?php

namespace App\DTOs;

use Carbon\Carbon;

class CurrencyRateDTO
{
    public function __construct(
        public readonly Carbon $date,
        public readonly string $name,
        public readonly float $rate,
    ) {}
}
