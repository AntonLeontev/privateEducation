<?php

namespace App\Services;

use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VisitSyncService
{
    public function sync(Request $request, Visitor $visitor, string $browserSessionId): ?Visit
    {
        if (! Str::isUuid($browserSessionId)) {
            Log::channel('telegram')->warning('[FIX] VisitSync: rejected non-UUID session_id before insert', [
                'visitor_uuid' => $visitor->uuid ?? null,
                'visit_session_id_length' => strlen($browserSessionId),
                'visit_session_id_prefix' => substr($browserSessionId, 0, 24),
            ]);

            return null;
        }

        if (! $visitor->id) {
            Log::channel('telegram')->warning('VisitSync: visitor without id before syncing visit', [
                'visitor_uuid' => $visitor->uuid ?? null,
                'visit_session_id' => $browserSessionId,
            ]);

            return null;
        }

        $visit = Visit::firstOrCreate([
            'visitor_id' => $visitor->id,
            'session_id' => $browserSessionId,
        ]);

        $utm = $this->extractUtm($request);
        $hasUtm = $this->hasUtm($utm);
        $referrerDomain = $this->extractReferrerDomain($request->headers->get('referer'));

        if ($visit->wasRecentlyCreated) {
            $this->snapshotVisitAttribution($visit, $utm, $referrerDomain);
            $visit->save();
            $visitor->visits_count = ($visitor->visits_count ?? 0) + 1;
            $visitor->save();

            return $visit;
        }

        if ($hasUtm || $referrerDomain) {
            $this->mergeVisitAttributionFromRequest($visit, $utm, $referrerDomain);
            if ($visit->isDirty()) {
                $visit->save();
            }
        }

        return $visit;
    }

    private function snapshotVisitAttribution(Visit $visit, array $utm, ?string $referrerDomain): void
    {
        foreach ($this->utmColumnMap() as $utmKey => $column) {
            $value = $utm[$utmKey] ?? null;
            $visit->setAttribute($column, ($value !== null && $value !== '') ? $value : null);
        }
        $visit->referrer = $referrerDomain;
    }

    private function mergeVisitAttributionFromRequest(Visit $visit, array $utm, ?string $referrerDomain): void
    {
        if ($this->hasUtm($utm)) {
            foreach ($this->utmColumnMap() as $utmKey => $column) {
                $value = $utm[$utmKey] ?? null;
                if ($value !== null && $value !== '') {
                    $visit->setAttribute($column, $value);
                }
            }
        }

        if ($referrerDomain) {
            $visit->referrer = $referrerDomain;
        }
    }

    /**
     * @return array<string, string>
     */
    private function utmColumnMap(): array
    {
        return [
            'source' => 'utm_source',
            'medium' => 'utm_medium',
            'campaign' => 'utm_campaign',
            'term' => 'utm_term',
            'content' => 'utm_content',
        ];
    }

    private function extractUtm(Request $request): array
    {
        return [
            'source' => $request->query('utm_source'),
            'medium' => $request->query('utm_medium'),
            'campaign' => $request->query('utm_campaign'),
            'term' => $request->query('utm_term'),
            'content' => $request->query('utm_content'),
        ];
    }

    private function hasUtm(array $utm): bool
    {
        foreach ($utm as $value) {
            if ($value !== null && $value !== '') {
                return true;
            }
        }

        return false;
    }

    private function extractReferrerDomain(?string $referrer): ?string
    {
        if (! $referrer) {
            return null;
        }

        $host = parse_url($referrer, PHP_URL_HOST);

        if (! $host) {
            $host = parse_url('//'.ltrim($referrer, '/'), PHP_URL_HOST);
        }

        return $host ?: null;
    }
}
