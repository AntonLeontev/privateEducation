<?php

namespace App\Http\Controllers;

use App\Models\PresentationViewTime;
use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PresentationViewTimeController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'presentation_id' => ['required', 'integer', 'exists:presentations,id'],
            'seconds' => ['required', 'integer', 'min:1'],
            'is_passive' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid payload'], 422);
        }

        $visitorUuid = $request->cookie('visitor_uuid');

        if (! $visitorUuid) {
            Log::channel('telegram')->warning('PresentationViewTime: missing visitor cookie');

            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $visitor = Visitor::where('uuid', '=', $visitorUuid, 'and')->first();

        if (! $visitor) {
            Log::channel('telegram')->warning('PresentationViewTime: visitor not found', [
                'visitor_uuid' => $visitorUuid,
            ]);

            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $payload = $validator->validated();

        try {
            $updated = PresentationViewTime::query()
                ->where('visitor_id', '=', $visitor->id, 'and')
                ->where('presentation_id', '=', $payload['presentation_id'], 'and')
                ->where('is_passive', '=', $payload['is_passive'], 'and')
                ->increment('seconds', $payload['seconds']);

            if (! $updated) {
                PresentationViewTime::create([
                    'visitor_id' => $visitor->id,
                    'presentation_id' => $payload['presentation_id'],
                    'is_passive' => $payload['is_passive'],
                    'seconds' => $payload['seconds'],
                ]);
            }
        } catch (Throwable $exception) {
            Log::channel('telegram')->warning('PresentationViewTime: failed to save', [
                'visitor_id' => $visitor->id,
                'presentation_id' => $payload['presentation_id'],
                'is_passive' => $payload['is_passive'],
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['message' => 'Failed to save view time'], 500);
        }

        return response()->json(['status' => 'ok']);
    }
}
