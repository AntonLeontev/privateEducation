<?php

namespace App\Http\Middleware;

use App\Jobs\ResolveVisitorCountry;
use App\Models\Visit;
use App\Models\Visitor;
use App\Services\DeviceTypeResolver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisitor
{
    public function __construct(private readonly DeviceTypeResolver $deviceTypeResolver) {}

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldSkip($request, $response)) {
            return $response;
        }

        try {
            $shouldSetCookie = false;
            $visitor = $this->resolveVisitor($request, $shouldSetCookie);
            $this->syncVisit($request, $visitor);

            if ($shouldSetCookie) {
                $cookie = Cookie::make('visitor_uuid', $visitor->uuid, 60 * 24 * 365);
                $response->headers->setCookie($cookie);
            }
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('TrackVisitor: failed to track visitor', [
                'path' => $request->path(),
                'exception' => $exception->getMessage(),
            ]);
        }

        return $response;
    }

    private function shouldSkip(Request $request, Response $response): bool
    {
        if (! $request->isMethod('get')) {
            return true;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return true;
        }

        if ($response->isRedirection()) {
            return true;
        }

        if (! $this->isHtmlResponse($response)) {
            return true;
        }

        if ($request->is('admin*')) {
            return true;
        }

        $route = $request->route();
        if (! $route) {
            return true;
        }

        $routeMiddleware = $route->gatherMiddleware();
        $excluded = ['auth', 'guest', 'admin', 'admin.guest', 'only_admin', 'admin.detect'];

        foreach ($excluded as $middleware) {
            if (in_array($middleware, $routeMiddleware, true)) {
                return true;
            }
        }

        return false;
    }

    private function isHtmlResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type');

        return $contentType && str_contains($contentType, 'text/html');
    }

    private function resolveVisitor(Request $request, bool &$shouldSetCookie): Visitor
    {
        $uuid = $request->cookie('visitor_uuid');

        if (! $uuid) {
            $uuid = (string) Str::uuid();
            $shouldSetCookie = true;
        }

        $visitor = Visitor::where('uuid', '=', $uuid, 'and')->first();

        if (! $visitor) {
            $visitor = new Visitor(['uuid' => $uuid]);
            $shouldSetCookie = true;
        }

        $visitor->ip = $request->ip();
        $visitor->user_agent = $request->userAgent();
        $visitor->device_type = $this->deviceTypeResolver->resolve();

        if ($request->user()) {
            $visitor->user_id = $request->user()->id;
        }

        $this->syncUtmAndReferrer($request, $visitor);
        $visitor->save();

        if ($visitor->wasRecentlyCreated) {
            ResolveVisitorCountry::dispatch($visitor->id);
        }

        return $visitor;
    }

    private function syncUtmAndReferrer(Request $request, Visitor $visitor): void
    {
        $utm = $this->extractUtm($request);
        $hasUtm = $this->hasUtm($utm);
        $referrerDomain = $this->extractReferrerDomain($request->headers->get('referer'));

        if (! $visitor->first_visit_at) {
            $visitor->first_visit_at = now();
            $this->applyUtm($visitor, $utm, 'first');

            if ($referrerDomain) {
                $visitor->referrer_first = $referrerDomain;
            }
        }

        $visitor->last_visit_at = now();

        if ($hasUtm) {
            $this->applyUtm($visitor, $utm, 'last');
        }

        if ($referrerDomain) {
            $visitor->referrer_last = $referrerDomain;
        }
    }

    private function extractReferrerDomain(?string $referrer): ?string
    {
        if (! $referrer) {
            return null;
        }

        $host = parse_url($referrer, PHP_URL_HOST);

        if (! $host) {
            // Some referrers may come without protocol, parse them as host/path.
            $host = parse_url('//'.ltrim($referrer, '/'), PHP_URL_HOST);
        }

        return $host ?: null;
    }

    private function syncVisit(Request $request, Visitor $visitor): void
    {
        if (! $visitor->id) {
            Log::channel('telegram')->warning('TrackVisitor: visitor without id before syncing visit', [
                'visitor_uuid' => $visitor->uuid ?? null,
                'session_id' => $request->session()->getId(),
            ]);

            return;
        }

        $sessionId = $request->session()->getId();

        $visit = Visit::firstOrCreate([
            'visitor_id' => $visitor->id,
            'session_id' => $sessionId,
        ]);

        $utm = $this->extractUtm($request);
        $hasUtm = $this->hasUtm($utm);
        $referrerDomain = $this->extractReferrerDomain($request->headers->get('referer'));

        if ($visit->wasRecentlyCreated) {
            $this->snapshotVisitAttribution($visit, $utm, $referrerDomain);
            $visit->save();
            $visitor->visits_count = ($visitor->visits_count ?? 0) + 1;
            $visitor->save();

            return;
        }

        if ($hasUtm || $referrerDomain) {
            $this->mergeVisitAttributionFromRequest($visit, $utm, $referrerDomain);
            if ($visit->isDirty()) {
                $visit->save();
            }
        }
    }

    /**
     * Полный снимок UTM/referrer при создании визита.
     */
    private function snapshotVisitAttribution(Visit $visit, array $utm, ?string $referrerDomain): void
    {
        foreach ($this->utmColumnMap() as $utmKey => $column) {
            $value = $utm[$utmKey] ?? null;
            $visit->setAttribute($column, ($value !== null && $value !== '') ? $value : null);
        }
        $visit->referrer = $referrerDomain;
    }

    /**
     * Последнее непустое значение в рамках сессии (GET под TrackVisitor).
     */
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
     * @return array<string, string> utm query key => column on visits
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

    private function applyUtm(Visitor $visitor, array $utm, string $prefix): void
    {
        foreach ($utm as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $visitor->setAttribute("utm_{$prefix}_{$key}", $value);
        }
    }
}
