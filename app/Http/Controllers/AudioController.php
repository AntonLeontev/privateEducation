<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudioUpdatePriceRequest;
use App\Models\Audio;

class AudioController extends Controller
{
    public function price(int $id, AudioUpdatePriceRequest $request)
    {
        Audio::find($id)->update(['price' => $request->get('price')]);
    }
}