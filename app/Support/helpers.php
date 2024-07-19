<?php

use App\Models\CurrencyRate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

if (! function_exists('admin')) {
    function admin()
    {
        return Auth::guard('admin');
    }
}

if (! function_exists('loc')) {
    function loc(): string
    {
        return app()->getLocale();
    }
}

if (! function_exists('rates')) {
    function rates(): Collection
    {
        if (cache('rates')) {
            return cache('rates');
        }

        $rates = CurrencyRate::all(['name', 'rate']);
        cache(['rates' => $rates]);

        return $rates;
    }
}

if (! function_exists('eur_rub_rate')) {
    function eur_rub_rate(): int|float
    {
        return rates()->where('name', 'EUR/RUB')->first()->rate;
    }
}

if (! function_exists('eur_usd_rate')) {
    function eur_usd_rate(): int|float
    {
        return rates()->where('name', 'EUR/USD')->first()->rate;
    }
}
