<?php

namespace App\Http\Controllers;

use App\Http\Requests\FragmentUpdateRequest;
use App\Models\Fragment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class FragmentController extends Controller
{
    public function update(Fragment $fragment, FragmentUpdateRequest $request): JsonResponse
    {
        try {
            $fragment->update($request->validated());
        } catch (Throwable $exception) {
            Log::error('Fragment update failed', [
                'fragment_id' => $fragment->id,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return response()->json($fragment);
    }
}
