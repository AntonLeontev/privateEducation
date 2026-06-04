<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Services\VisitSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VisitSessionController extends Controller
{
    public function __construct(private readonly VisitSyncService $visitSyncService) {}

    public function sync(Request $request): JsonResponse
    {
        $visitorUuid = $request->cookie('visitor_uuid');
        $visitSessionId = $request->cookie('visit_session_id');

        if (! $visitSessionId) {
            return response()->json([
                'message' => 'Missing cookies',
                'missing' => ['visit_session_id'],
                'retry' => true,
            ], 400);
        }

        if (! $visitorUuid) {
            return response()->json([
                'message' => 'Missing cookies',
                'missing' => ['visitor_uuid'],
                'retry' => true,
            ], 400);
        }

        $visitor = Visitor::where('uuid', '=', $visitorUuid, 'and')->first();

        if (! $visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $visit = $this->visitSyncService->sync($request, $visitor, $visitSessionId);

        if (! $visit) {
            return response()->json(['message' => 'Visit not synced'], 500);
        }

        return response()->json([
            'status' => 'ok',
            'visit_id' => $visit->id,
            'created' => $visit->wasRecentlyCreated,
            'session_id' => $visit->session_id,
        ]);
    }
}
