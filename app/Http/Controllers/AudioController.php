<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudioUpdateRequest;
use App\Models\Audio;

class AudioController extends Controller
{
    public function update(Audio $audio, AudioUpdateRequest $request)
    {
        $audio->update($request->validated());
    }
}
