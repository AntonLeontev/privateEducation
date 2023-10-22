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

        foreach ($this->lastSubscriptions->sortByDesc('created_at') as $sub) {
            $key = $sub->subscribable_id.'.'.$sub->subscribable_type;

            if (! $fragments->has($sub->subscribable_id.'.presentation')) {
                $fragments->put($sub->subscribable_id.'.id', $sub->subscribable_id);
                $fragments->put($sub->subscribable_id.'.presentation', [
                    'views' => $this->presentationViews
                        ->where('presentation_id', $sub->subscribable_id)
                        ->where('is_reading', false)
                        ->count(),
                    'readings' => $this->presentationViews
                        ->where('presentation_id', $sub->subscribable_id)
                        ->where('is_reading', true)
                        ->count(),
                ]);
            }

            if ($fragments->has($key)) {
                continue;
            }

            $fragments->put($key, [
                'created_at' => $sub->created_at->translatedFormat('d F Y'),
                'ends_at' => $sub->ends_at->translatedFormat('d F Y'),
                'left' => $sub->ends_at->diffForHumans(null, 1),
                'ago' => $sub->ends_at->diffForHumans(),
                'price' => $this->lastSubscriptions
                    ->where('subscribable_id', $sub->subscribable_id)
                    ->where('subscribable_type', $sub->subscribable_type)
                    ->first()
                    ->price,
                'views' => $this->views
                    ->where('viewable_id', $sub->subscribable_id)
                    ->where('viewable_type', $sub->subscribable_type)
                    ->count(),
                'is_active' => $sub->ends_at > now(),
            ]);
        }

        return $fragments->undot()->values()->toArray();
    }
}
