<?php

namespace App\Services\Ip2location;

use App\Services\Ip2location\Exceptions\Ip2locationException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Ip2location
{
    private const BASE_URL = 'https://api.ip2location.io';

    public function check(string $ip = ''): Ip2locationDTO
    {
        $response = Http::baseUrl(self::BASE_URL)
            ->throw(function (Response $response) {
                throw new Ip2locationException($response);
            })
            ->get('/', [
                'key' => config('services.ip2location.key'),
                'ip' => $ip,
            ]);

        return Ip2locationDTO::fromResponse($response);
    }
}
