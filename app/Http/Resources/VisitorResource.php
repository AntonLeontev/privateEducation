<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'email' => $this->user?->email,
            'ip' => $this->ip,
            'user_agent' => $this->user_agent,
            'device_type' => $this->device_type,
            'country' => $this->country,
            'country_code' => $this->country_code,
            'country_name' => $this->country_name,
            'first_visit_at' => $this->first_visit_at?->format('d.m.Y H:i'),
            'last_visit_at' => $this->last_visit_at?->format('d.m.Y H:i'),
            'visits_count' => $this->visits_count,
            'utm_first' => [
                'source' => $this->utm_first_source,
                'medium' => $this->utm_first_medium,
                'campaign' => $this->utm_first_campaign,
                'term' => $this->utm_first_term,
                'content' => $this->utm_first_content,
            ],
            'utm_last' => [
                'source' => $this->utm_last_source,
                'medium' => $this->utm_last_medium,
                'campaign' => $this->utm_last_campaign,
                'term' => $this->utm_last_term,
                'content' => $this->utm_last_content,
            ],
            'referrer_first' => $this->referrer_first,
            'referrer_last' => $this->referrer_last,
        ];
    }
}
