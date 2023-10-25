<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdatePriceRequest;
use App\Models\Video;

class VideoController extends Controller
{
    public function price(int $id, VideoUpdatePriceRequest $request)
    {
        Video::find($id)->update(['price' => $request->get('price')]);
    }

    public function update(int $id)
    {

    }
}
