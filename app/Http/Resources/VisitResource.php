<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $visitor = $this->visitor;

        return [
            'id' => $this->id,
            'started_at' => $this->created_at?->format('d.m.Y H:i'),
            'visit_number' => (int) $this->visit_number,
            'utm' => [
                'source' => $this->utm_source,
                'medium' => $this->utm_medium,
                'campaign' => $this->utm_campaign,
                'term' => $this->utm_term,
                'content' => $this->utm_content,
            ],
            'referrer' => $this->referrer,
            'fragments' => $this->fragments ?? [],
            'visitor' => $visitor ? [
                'id' => $visitor->id,
                'email' => $visitor->user?->email,
                'country_code' => $visitor->country_code,
                'country' => $visitor->country,
                'country_name' => $visitor->country_name,
                'device_type' => $visitor->device_type,
            ] : null,
        ];
    }
}
