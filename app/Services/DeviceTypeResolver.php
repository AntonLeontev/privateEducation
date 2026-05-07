<?php

namespace App\Services;

use Jenssegers\Agent\Agent;

class DeviceTypeResolver
{
    public function __construct(private readonly Agent $agent) {}

    public function resolve(): string
    {
        if ($this->agent->isTablet()) {
            return 'tablet';
        }

        if ($this->agent->isMobile()) {
            return 'mobile';
        }

        if ($this->agent->isDesktop()) {
            return 'desktop';
        }

        return 'desktop';
    }
}
