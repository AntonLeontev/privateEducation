<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMediaRequest;
use App\Http\Requests\MediaChunkRequest;
use App\Http\Requests\MediaStoreRequest;
use App\Http\Requests\MediaUploadInitRequest;
use App\Models\Audio;
use App\Models\Fragment;
use App\Models\Media;
use App\Services\Media\ChunkedMediaUploadException;
use App\Services\Media\ChunkedMediaUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class MediaController extends Controller
{
    public function initUpload(MediaUploadInitRequest $request, ChunkedMediaUploadService $uploads): JsonResponse
    {
        try {
            $result = $uploads->init(
                fragmentId: (int) $request->validated('fragment_id'),
                lang: $request->validated('lang'),
                sound: $request->validated('sound'),
                device: $request->validated('device'),
                type: $request->validated('type'),
                size: (int) $request->validated('size'),
                adminId: (int) admin()->id(),
            );
        } catch (ChunkedMediaUploadException $exception) {
            return $this->chunkedUploadErrorResponse($exception);
        } catch (Throwable $exception) {
            Log::error('Chunked media upload init failed', [
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return response()->json($result);
    }

    public function storeChunk(string $upload, MediaChunkRequest $request, ChunkedMediaUploadService $uploads): JsonResponse
    {
        try {
            $result = $uploads->storeChunk(
                $upload,
                (int) $request->validated('index'),
                $request->file('chunk'),
            );
        } catch (ChunkedMediaUploadException $exception) {
            return $this->chunkedUploadErrorResponse($exception);
        } catch (Throwable $exception) {
            Log::error('Chunked media upload chunk failed', [
                'upload_id' => $upload,
                'index' => $request->input('index'),
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return response()->json($result);
    }

    public function completeUpload(string $upload, ChunkedMediaUploadService $uploads): JsonResponse
    {
        try {
            $result = $uploads->complete($upload);
        } catch (ChunkedMediaUploadException $exception) {
            return $this->chunkedUploadErrorResponse($exception);
        } catch (Throwable $exception) {
            Log::error('Chunked media upload complete failed', [
                'upload_id' => $upload,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return response()->json($result);
    }

    public function store(MediaStoreRequest $request, ChunkedMediaUploadService $uploads)
    {
        $file = $request->has('audio') ? $request->file('audio') : $request->file('video');

        $media = $uploads->persistUploadedFile(
            $file,
            (int) $request->get('fragment_id'),
            $request->get('lang'),
            $request->get('sound'),
            $request->get('device'),
            $request->get('type'),
        );

        return response()->json($media);
    }

    public function show(string $type, int $fragmentId, string $lang, string $sound, string $device, GetMediaRequest $request)
    {
        $fragment = Fragment::find($fragmentId);

        abort_if($fragment->is_active === false, Response::HTTP_FORBIDDEN, 'Fragment is not active');

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
                [
                    'Content-Type' => $media->get('format'),
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                ]
            );
    }

    public function text(int $fragmentId, string $lang): JsonResponse
    {
        if (! auth()->check() && ! admin()->user()?->isAdmin()) {
            abort(401);
        }

        $subscription = auth()->user()->activeSubscriptions
            ->where('subscribable_type', 'audio')
            ->where('subscribable_id', $fragmentId)
            ->first();
        if ($subscription === null) {
            abort(401);
        }

        $text = Audio::where('fragment_id', $fragmentId)
            ->first()
            ->{'text_'.$lang};

        return response()->json($text);
    }

    private function chunkedUploadErrorResponse(ChunkedMediaUploadException $exception): JsonResponse
    {
        $status = match ($exception->reason()) {
            ChunkedMediaUploadException::REASON_SIZE => 413,
            ChunkedMediaUploadException::REASON_UNKNOWN_UPLOAD => 404,
            ChunkedMediaUploadException::REASON_BAD_INDEX,
            ChunkedMediaUploadException::REASON_INCOMPLETE => 422,
            default => 422,
        };

        return response()->json([
            'message' => $exception->getMessage(),
            'reason' => $exception->reason(),
        ], $status);
    }
}
