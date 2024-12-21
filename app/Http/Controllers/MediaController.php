<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMediaRequest;
use App\Http\Requests\MediaStoreRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Owenoj\LaravelGetId3\GetId3;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MediaController extends Controller
{
    public function store(MediaStoreRequest $request)
    {
        $fileName = "{$request->get('type')}{$request->get('fragment_id')}_{$request->get('lang')}_{$request->get('sound')}_{$request->get('device')}";
        $mediaType = $request->get('type') === 'audio' ? 'audio' : 'video';

        $media = Media::where('sound', $request->get('sound'))
            ->where('device', $request->get('device'))
            ->where('lang', $request->get('lang'))
            ->where('mediable_type', $request->get('type'))
            ->where('mediable_id', $request->get('fragment_id'))
            ->first();

        if (! is_null($media)) {
            Storage::disk('media')->delete($media->path);
        }

        if ($request->has('audio')) {
            $track = GetId3::fromUploadedFile(request()->file('audio'));
            $path = $request->file('audio')->storeAs($request->get('type'), "$fileName.{$track->getFileFormat()}", 'media');
        } else {
            $track = GetId3::fromUploadedFile(request()->file('video'));
            $path = $request->file('video')->storeAs($request->get('type'), "$fileName.{$track->getFileFormat()}", 'media');
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
                'format' => $mediaType.'/'.$track->getFileFormat(),
                'path' => $path,
            ]
        );

        return response()->json($media);
    }

    public function show(string $type, int $fragmentId, string $lang, string $sound, string $device, GetMediaRequest $request)
    {
        $media = Media::where('sound', $sound)
            ->where('device', $device)
            ->where('lang', $lang)
            ->where('mediable_type', $type)
            ->where('mediable_id', $fragmentId)
            ->first();

        throw_if(is_null($media), NotFoundHttpException::class);

        return response()
            ->file(
                storage_path("app/media/{$media->path}"),
                ['Content-Type' => $media->get('format')]
            );
    }
}
