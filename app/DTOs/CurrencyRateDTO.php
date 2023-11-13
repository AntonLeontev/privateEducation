<?php

namespace App\DTOs;

use Carbon\Carbon;

class CurrencyRateDTO
{
    public function __construct(
        readonly public Carbon $date,
        readonly public string $name,
        readonly public float $rate,
    ) {
    }
}
