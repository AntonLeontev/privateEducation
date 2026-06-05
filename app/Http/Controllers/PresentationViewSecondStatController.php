<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresentationViewSecondStatsRequest;
use App\Models\Visit;
use App\Models\Visitor;
use App\Services\PresentationViewSecondStatService;
use App\Services\VisitSessionIdResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class PresentationViewSecondStatController extends Controller
{
    public function __construct(
        private readonly PresentationViewSecondStatService $statService,
        private readonly VisitSessionIdResolver $visitSessionIdResolver,
    ) {}

    public function store(StorePresentationViewSecondStatsRequest $request): JsonResponse
    {
        $visitorUuid = $request->cookie('visitor_uuid');

        if (! $visitorUuid) {
            Log::channel('telegram')->warning('PresentationViewSecondStat: missing visitor cookie');

            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $visitor = Visitor::where('uuid', '=', $visitorUuid, 'and')->first();

        if (! $visitor) {
            Log::channel('telegram')->warning('PresentationViewSecondStat: visitor not found', [
                'visitor_uuid' => $visitorUuid,
            ]);

            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $visitSessionId = $this->visitSessionIdResolver->resolve($request->cookie('visit_session_id'));

        if (! $visitSessionId) {
            Log::channel('telegram')->warning('[FIX] PresentationViewSecondStat: invalid visit session cookie', [
                'visitor_id' => $visitor->id,
                'visit_session_id_length' => strlen((string) $request->cookie('visit_session_id')),
            ]);

            return response()->json(['message' => 'Visit not found'], 404);
        }

        $visit = Visit::query()
            ->where('visitor_id', '=', $visitor->id, 'and')
            ->where('session_id', '=', $visitSessionId, 'and')
            ->first();

        if (! $visit) {
            Log::channel('telegram')->warning('PresentationViewSecondStat: visit not found for session', [
                'visitor_id' => $visitor->id,
                'visit_session_id' => $visitSessionId,
            ]);

            return response()->json(['message' => 'Visit not found'], 404);
        }

        $payload = $request->validated();

        try {
            $this->statService->mergeBuckets(
                $visit,
                (int) $payload['presentation_id'],
                (bool) $payload['is_passive'],
                $payload['buckets']
            );
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('PresentationViewSecondStat: failed to save', [
                'visitor_id' => $visitor->id,
                'visit_session_id' => $visitSessionId,
                'visit_id' => $visit->id,
                'presentation_id' => $payload['presentation_id'],
                'is_passive' => $payload['is_passive'],
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['message' => 'Failed to save view seconds'], 500);
        }

        return response()->json(['status' => 'ok']);
    }
}
