<?php

namespace App\Jobs;

use App\Models\Visitor;
use App\Services\Ip2location\Ip2location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResolveVisitorCountry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $visitorId) {}

    public function handle(Ip2location $ip2location): void
    {
        $visitor = Visitor::find($this->visitorId, ['*']);

        if (! $visitor) {
            return;
        }

        if (! $visitor->ip) {
            Log::channel('telegram')->warning('GetLocationByIp: missing visitor ip', [
                'visitor_id' => $visitor->id,
            ]);

            return;
        }

        try {
            $location = $ip2location->check($visitor->ip);
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('GetLocationByIp: ip2location error', [
                'visitor_id' => $visitor->id,
                'ip' => $visitor->ip,
                'exception' => $exception->getMessage(),
            ]);

            return;
        }

        $visitor->country_code = $location->countryCode;
        $visitor->country_name = $location->countryName;
        $visitor->save();
    }
}
