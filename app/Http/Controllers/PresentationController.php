<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentationUpdateRequest;
use App\Models\Presentation;
use Illuminate\Http\JsonResponse;

class PresentationController extends Controller
{
    public function update(Presentation $presentation, PresentationUpdateRequest $request): JsonResponse
    {
        $presentation->update($request->validated());

        return response()->json($presentation);
    }
}
