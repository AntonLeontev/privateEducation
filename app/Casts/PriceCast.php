<?php

namespace App\Casts;

use App\Models\Payment;
use App\Support\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PriceCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Price
    {
        if ($model instanceof Payment) {
            return new Price($value, $model->currency);
        }

        return new Price($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if ($value instanceof Price) {
            return $value->amount;
        }

        return $value * 100;
    }
}
