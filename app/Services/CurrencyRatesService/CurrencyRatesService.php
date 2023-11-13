<?php

namespace App\Services\CurrencyRatesService;

use App\DTOs\CurrencyRateDTO;
use Illuminate\Support\Carbon;

class CurrencyRatesService
{
    public function getEurToUsd(): CurrencyRateDTO
    {
        $response = RatesApi::getECB();

        $obj = $this->toObject($response->body());

        $date = Carbon::parse($obj->Cube->Cube[0]->{'@attributes'}->time);
        $rate = 0;

        foreach ($obj->Cube->Cube[0]->Cube as $value) {
            if ($value->{'@attributes'}->currency === 'USD') {
                $rate = (float) $value->{'@attributes'}->rate;
            }
        }

        return new CurrencyRateDTO($date, 'EUR/USD', $rate);
    }

    public function getEurToRub()
    {
        $response = RatesApi::getCBR();

        $obj = $this->toObject($response->body());

        $date = Carbon::parse($obj->{'@attributes'}->Date);
        $rate = 0;

        foreach ($obj->Valute as $currency) {
            if ($currency->CharCode === 'EUR') {
                $rate = (float) str_replace(',', '.', $currency->Value);
            }
        }

        return new CurrencyRateDTO($date, 'EUR/RUB', $rate);
    }

    private function toObject(string $body): object
    {
        $xml = simplexml_load_string($body);

        return json_decode(json_encode($xml), false);
    }
}
