<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaStoreRequest;
use App\Models\Media;
use Owenoj\LaravelGetId3\GetId3;

class MediaController extends Controller
{
    public function store(MediaStoreRequest $request)
    {
        if ($request->has('audio')) {
            $track = GetId3::fromUploadedFile(request()->file('audio'));
        }

        if ($request->has('video')) {
            $track = GetId3::fromUploadedFile(request()->file('video'));
        }

        $media = Media::updateOrCreate(
            [
                'sound' => $request->get('sound'),
                'device' => $request->get('device'),
                'lang' => $request->get('lang'),
                'mediable_type' => $request->get('type'),
                'mediable_id' => $request->get('fragment_id'),
            ],
            [
                'playtime' => $track->getPlaytime(),
                //TODO saving media
                'path' => 'somepath',
            ]
        );

        return response()->json($media);
    }
}
