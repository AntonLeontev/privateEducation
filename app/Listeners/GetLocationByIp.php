<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\Ip2location\Ip2location;
use App\Services\Ip2location\RegionConverter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class GetLocationByIp implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(public Ip2location $ip2location, public RegionConverter $regionConverter)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $location = $this->ip2location->check($user->ip);

        $user->country_from_ip = $location->countryName;
        $user->country_code = $location->countryCode;
        $user->region = $location->regionName;

        if ($location->countryCode === 'RU' || $location->countryCode === 'US') {
            $user->region_code = $this->regionConverter->getCodeByName($location->countryCode, $location->regionName);

            if ($user->region_code === null) {
                Log::channel('telegram')->alert('Region code not found', [
                    'ip' => $user->ip,
                    'user_id' => $user->id,
                    'country' => $location->countryName,
                    'country_code' => $location->countryCode,
                    'region' => $location->regionName,
                ]);
            }
        }

        $user->save();
    }
}
