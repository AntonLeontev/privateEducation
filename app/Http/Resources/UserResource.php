<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge(
            parent::toArray($request),
            [
                'subscriptions_sum_price' => $this->subscriptions_sum_price / 100,
                'active_subscriptions_sum_price' => $this->active_subscriptions_sum_price / 100,
                'last_subscription_time' => $this->last_subscription_time?->format('d.m.Y'),
                'first_subscription_created_at' => $this->lastSubscriptions->last()?->created_at->format('d.m.Y'),
                'created_at' => $this->created_at->format('d.m.Y'),
                'fragments' => $this->fragments(),
            ]
        );
    }

    private function fragments()
    {
        $fragments = collect();

        foreach ($this->lastSubscriptions as $subscription) {
            $key = $subscription->subscribable_id.'.'.$subscription->subscribable_type;

            if (request()->filled('media') && request('media') !== $subscription->subscribable_type->value()) {
                continue;
            }

            if (request()->filled('fragment') && request('fragment') != $subscription->subscribable_id) {
                continue;
            }

            if ($fragments->has($key)) {
                continue;
            }

            $fragments->put($key, [
                'created_at' => $subscription->created_at->translatedFormat('d F Y'),
                'ends_at' => $subscription->ends_at->translatedFormat('d F Y'),
                'left' => $subscription->ends_at->diffForHumans(null, 1),
                'ago' => $subscription->ends_at->diffForHumans(),
                'price' => $this->lastSubscriptions
                    ->where('subscribable_id', $subscription->subscribable_id)
                    ->where('subscribable_type', $subscription->subscribable_type)
                    ->first()
                    ->price,
                'views' => $this->views
                    ->where('viewable_id', $subscription->subscribable_id)
                    ->where('viewable_type', $subscription->subscribable_type)
                    ->count(),
                'is_active' => $subscription->ends_at > now(),
            ]);

            if (! $fragments->has($subscription->subscribable_id.'.presentation')) {
                $fragments->put($subscription->subscribable_id.'.id', $subscription->subscribable_id);
                $fragments->put($subscription->subscribable_id.'.presentation', [
                    'views' => $this->presentationViews
                        ->where('presentation_id', $subscription->subscribable_id)
                        ->where('is_reading', false)
                        ->count(),
                    'readings' => $this->presentationViews
                        ->where('presentation_id', $subscription->subscribable_id)
                        ->where('is_reading', true)
                        ->count(),
                ]);
            }
        }

        return $fragments->undot()->values()->toArray();
    }
}
