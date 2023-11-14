<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;

class VideoController extends Controller
{
    public function update(Video $video, VideoUpdateRequest $request)
    {
        $video->update($request->validated());
    }
}
