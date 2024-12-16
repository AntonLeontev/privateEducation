<?php

namespace App\Services\Ip2location;

use Illuminate\Http\Client\Response;

readonly class Ip2locationDTO
{
    public function __construct(
        public string $ip,
        public ?string $countryCode,
        public ?string $countryName,
        public ?string $regionName,
        public ?string $cityName,
        public ?float $latitude,
        public ?float $longitude,
        public ?string $timeZone,
        public ?string $zipCode,
        public ?string $asn,
        public ?string $as,
        public ?bool $isProxy,
    ) {}

    public static function fromResponse(Response $response): static
    {
        $response = $response->object();

        return new static(
            $response->ip,
            $response->country_code,
            $response->country_name,
            $response->region_name,
            $response->city_name,
            $response->latitude,
            $response->longitude,
            $response->time_zone,
            $response->zip_code,
            $response->asn,
            $response->as,
            $response->is_proxy
        );
    }
}
