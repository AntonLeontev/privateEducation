<?php

namespace App\Services\CurrencyRatesService;

use Illuminate\Support\Facades\Http;

class RatesApi
{
    /**
     *  Получает данные от Европейского центрального банка
     */
    public static function getECB()
    {
        return Http::retry(5, 3000)
            // ->get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist-90d.xml');
            ->get('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
    }

    /**
     *  Получает данные от Центрального банка РФ
     */
    public static function getCBR()
    {
        $date = now()->format('d/m/Y');

        return Http::retry(5, 3000)
            ->get("http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date");
    }
}
