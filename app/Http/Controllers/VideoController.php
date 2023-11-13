<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdatePriceRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;

class VideoController extends Controller
{
    public function price(int $id, VideoUpdatePriceRequest $request)
    {
        Video::find($id)->update(['price' => $request->get('price')]);
    }

    public function update(Video $video, VideoUpdateRequest $request)
    {
        $video->update($request->validated());
    }
}
