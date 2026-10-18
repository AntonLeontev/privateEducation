<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Owenoj\LaravelGetId3\GetId3;
use Throwable;

class ChunkedMediaUploadService
{
    public function init(
        int $fragmentId,
        string $lang,
        string $sound,
        string $device,
        string $type,
        int $size,
        int $adminId,
    ): array {
        $maxFileSize = $this->maxFileSize();

        if ($size <= 0 || $size > $maxFileSize) {
            Log::warning('Chunked media upload rejected: invalid size', [
                'size' => $size,
                'max_file_size' => $maxFileSize,
                'admin_id' => $adminId,
            ]);

            throw new ChunkedMediaUploadException(
                'File size exceeds the allowed limit.',
                ChunkedMediaUploadException::REASON_SIZE,
            );
        }

        $uploadId = (string) Str::uuid();
        $directory = $this->uploadDirectory($uploadId);
        $meta = [
            'upload_id' => $uploadId,
            'fragment_id' => $fragmentId,
            'lang' => $lang,
            'sound' => $sound,
            'device' => $device,
            'type' => $type,
            'size' => $size,
            'admin_id' => $adminId,
            'created_at' => now()->toIso8601String(),
        ];

        try {
            $this->disk()->makeDirectory($directory);
            $this->putMeta($directory, $meta);
        } catch (Throwable $exception) {
            Log::error('Chunked media upload IO failure on init', [
                'upload_id' => $uploadId,
                'admin_id' => $adminId,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return [
            'upload_id' => $uploadId,
            'chunk_size' => $this->chunkSize(),
        ];
    }

    public function storeChunk(string $uploadId, int $index, UploadedFile $chunk): array
    {
        $meta = $this->readMeta($uploadId);
        $chunkSizeLimit = $this->chunkSize();
        $maxFileSize = $this->maxFileSize();
        $expectedChunks = $this->expectedChunkCount($meta['size'], $chunkSizeLimit);
        $chunkBytes = $chunk->getSize();

        if ($index < 0 || $index >= $expectedChunks) {
            Log::warning('Chunked media upload rejected: bad index', [
                'upload_id' => $uploadId,
                'index' => $index,
                'expected_chunks' => $expectedChunks,
            ]);

            throw new ChunkedMediaUploadException(
                'Invalid chunk index.',
                ChunkedMediaUploadException::REASON_BAD_INDEX,
            );
        }

        $isLastChunk = $index === ($expectedChunks - 1);
        $maxChunkBytes = $isLastChunk
            ? ($meta['size'] - ($index * $chunkSizeLimit))
            : $chunkSizeLimit;

        if ($chunkBytes <= 0 || $chunkBytes > $maxChunkBytes || $chunkBytes > $chunkSizeLimit) {
            Log::warning('Chunked media upload rejected: invalid chunk size', [
                'upload_id' => $uploadId,
                'index' => $index,
                'chunk_bytes' => $chunkBytes,
                'max_chunk_bytes' => $maxChunkBytes,
            ]);

            throw new ChunkedMediaUploadException(
                'Chunk size exceeds the allowed limit.',
                ChunkedMediaUploadException::REASON_SIZE,
            );
        }

        $directory = $this->uploadDirectory($uploadId);
        $accumulated = $this->accumulatedSize($directory, $index, $chunkBytes);

        if ($accumulated > $maxFileSize || $accumulated > $meta['size']) {
            Log::warning('Chunked media upload rejected: accumulated size exceeds limit', [
                'upload_id' => $uploadId,
                'index' => $index,
                'accumulated' => $accumulated,
                'declared_size' => $meta['size'],
                'max_file_size' => $maxFileSize,
            ]);

            throw new ChunkedMediaUploadException(
                'File size exceeds the allowed limit.',
                ChunkedMediaUploadException::REASON_SIZE,
            );
        }

        try {
            $this->disk()->putFileAs($directory, $chunk, $this->chunkFileName($index));
        } catch (Throwable $exception) {
            Log::error('Chunked media upload IO failure on storeChunk', [
                'upload_id' => $uploadId,
                'index' => $index,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return [
            'upload_id' => $uploadId,
            'index' => $index,
            'received' => $chunkBytes,
            'accumulated' => $accumulated,
        ];
    }

    public function complete(string $uploadId): Media
    {
        $meta = $this->readMeta($uploadId);
        $directory = $this->uploadDirectory($uploadId);
        $expectedChunks = $this->expectedChunkCount($meta['size'], $this->chunkSize());

        $this->assertChunksComplete($uploadId, $directory, $expectedChunks, $meta['size']);

        $assembledPath = $directory.'/assembled';

        try {
            $this->assembleChunks($directory, $expectedChunks, $assembledPath);

            $track = GetId3::fromDiskAndPath((string) config('media.disk'), $assembledPath);
            $format = $track->getFileFormat();

            if (empty($format)) {
                throw new \RuntimeException('Unable to detect media file format.');
            }

            $destination = $this->destinationPath(
                $meta['type'],
                (int) $meta['fragment_id'],
                $meta['lang'],
                $meta['sound'],
                $meta['device'],
                (string) $format,
            );

            $media = $this->finalizeMedia(
                $destination,
                $assembledPath,
                $track,
                (int) $meta['fragment_id'],
                $meta['lang'],
                $meta['sound'],
                $meta['device'],
                $meta['type'],
            );
        } catch (ChunkedMediaUploadException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Chunked media upload complete failed', [
                'upload_id' => $uploadId,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        try {
            $this->disk()->deleteDirectory($directory);
        } catch (Throwable $exception) {
            Log::warning('Failed to delete chunk directory after complete', [
                'upload_id' => $uploadId,
                'error' => $exception->getMessage(),
            ]);
        }

        return $media;
    }

    public function persistUploadedFile(
        UploadedFile $file,
        int $fragmentId,
        string $lang,
        string $sound,
        string $device,
        string $type,
    ): Media {
        $track = GetId3::fromUploadedFile($file);
        $format = $track->getFileFormat();

        if (empty($format)) {
            throw new \RuntimeException('Unable to detect media file format.');
        }

        $destination = $this->destinationPath($type, $fragmentId, $lang, $sound, $device, (string) $format);
        $stagingName = '.tmp-'.Str::uuid().'.'.$format;
        $stagingPath = $file->storeAs($type, $stagingName, (string) config('media.disk'));

        return $this->finalizeMedia(
            $destination,
            $stagingPath,
            $track,
            $fragmentId,
            $lang,
            $sound,
            $device,
            $type,
        );
    }

    public function purgeExpired(): int
    {
        $ttlHours = (int) config('media.upload_ttl_hours');
        $cutoff = now()->subHours($ttlHours);
        $purged = 0;

        foreach ($this->disk()->directories($this->uploadsRoot()) as $directory) {
            $createdAt = $this->directoryCreatedAt($directory);

            if ($createdAt === null || $createdAt->greaterThan($cutoff)) {
                continue;
            }

            try {
                $this->disk()->deleteDirectory($directory);
                $purged++;
            } catch (Throwable $exception) {
                Log::warning('Failed to purge stale media upload directory', [
                    'directory' => $directory,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return $purged;
    }

    private function readMeta(string $uploadId): array
    {
        $directory = $this->uploadDirectory($uploadId);
        $metaPath = $this->metaPath($directory);

        if (! Str::isUuid($uploadId) || ! $this->disk()->exists($metaPath)) {
            Log::warning('Chunked media upload rejected: unknown upload_id', [
                'upload_id' => $uploadId,
            ]);

            throw new ChunkedMediaUploadException(
                'Unknown upload.',
                ChunkedMediaUploadException::REASON_UNKNOWN_UPLOAD,
            );
        }

        try {
            $meta = json_decode($this->disk()->get($metaPath), true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            Log::error('Chunked media upload IO failure on readMeta', [
                'upload_id' => $uploadId,
                'error' => $exception->getMessage(),
            ]);

            throw $exception;
        }

        return $meta;
    }

    private function putMeta(string $directory, array $meta): void
    {
        $this->disk()->put(
            $this->metaPath($directory),
            json_encode($meta, JSON_THROW_ON_ERROR)
        );
    }

    private function accumulatedSize(string $directory, int $incomingIndex, int $incomingBytes): int
    {
        $total = $incomingBytes;

        foreach ($this->disk()->files($directory) as $path) {
            $fileName = basename($path);

            if (! preg_match('/^chunk_(\d+)$/', $fileName, $matches)) {
                continue;
            }

            $index = (int) $matches[1];

            if ($index === $incomingIndex) {
                continue;
            }

            $total += $this->disk()->size($path);
        }

        return $total;
    }

    private function assertChunksComplete(string $uploadId, string $directory, int $expectedChunks, int $declaredSize): void
    {
        $missing = [];
        $accumulated = 0;

        for ($index = 0; $index < $expectedChunks; $index++) {
            $path = $directory.'/'.$this->chunkFileName($index);

            if (! $this->disk()->exists($path)) {
                $missing[] = $index;

                continue;
            }

            $accumulated += $this->disk()->size($path);
        }

        if ($missing !== [] || $accumulated !== $declaredSize) {
            Log::warning('Chunked media upload rejected: incomplete chunks', [
                'upload_id' => $uploadId,
                'missing' => $missing,
                'accumulated' => $accumulated,
                'declared_size' => $declaredSize,
            ]);

            throw new ChunkedMediaUploadException(
                'Upload is incomplete.',
                ChunkedMediaUploadException::REASON_INCOMPLETE,
            );
        }
    }

    private function assembleChunks(string $directory, int $expectedChunks, string $assembledPath): void
    {
        $output = fopen($this->disk()->path($assembledPath), 'wb');

        if ($output === false) {
            throw new \RuntimeException('Unable to open assembled file for writing.');
        }

        try {
            for ($index = 0; $index < $expectedChunks; $index++) {
                $input = $this->disk()->readStream($directory.'/'.$this->chunkFileName($index));

                if ($input === false) {
                    throw new \RuntimeException('Unable to read chunk '.$index);
                }

                stream_copy_to_stream($input, $output);
                fclose($input);
            }
        } finally {
            fclose($output);
        }
    }

    private function finalizeMedia(
        string $destination,
        string $newFilePath,
        GetId3 $track,
        int $fragmentId,
        string $lang,
        string $sound,
        string $device,
        string $type,
    ): Media {
        $existing = Media::where('sound', $sound)
            ->where('device', $device)
            ->where('lang', $lang)
            ->where('mediable_type', $type)
            ->where('mediable_id', $fragmentId)
            ->first();

        $oldPath = $existing?->path;

        $this->replaceFile($newFilePath, $destination);

        $mediaType = $type === 'audio' ? 'audio' : 'video';

        $media = Media::updateOrCreate(
            [
                'sound' => $sound,
                'device' => $device,
                'lang' => $lang,
                'mediable_type' => $type,
                'mediable_id' => $fragmentId,
            ],
            [
                'playtime' => $track->getPlaytime(),
                'format' => $mediaType.'/'.$track->getFileFormat(),
                'path' => $destination,
            ]
        );

        if ($oldPath && $oldPath !== $destination && $this->disk()->exists($oldPath)) {
            $this->disk()->delete($oldPath);
        }

        return $media;
    }

    private function replaceFile(string $from, string $to): void
    {
        if ($from === $to) {
            return;
        }

        $disk = $this->disk();
        $directory = dirname($to);

        if ($directory !== '.' && $directory !== '') {
            $disk->makeDirectory($directory);
        }

        if (! $disk->exists($to)) {
            if (! $disk->move($from, $to)) {
                throw new \RuntimeException('Unable to move assembled media file into place.');
            }

            return;
        }

        $staged = $to.'.new';

        if ($disk->exists($staged)) {
            $disk->delete($staged);
        }

        if (! $disk->move($from, $staged)) {
            throw new \RuntimeException('Unable to stage assembled media file.');
        }

        if (! @rename($disk->path($staged), $disk->path($to))) {
            throw new \RuntimeException('Unable to replace existing media file.');
        }
    }

    private function destinationPath(
        string $type,
        int $fragmentId,
        string $lang,
        string $sound,
        string $device,
        string $format,
    ): string {
        return $type.'/'.$type.$fragmentId.'_'.$lang.'_'.$sound.'_'.$device.'.'.$format;
    }

    private function directoryCreatedAt(string $directory): ?Carbon
    {
        $metaPath = $this->metaPath($directory);

        if ($this->disk()->exists($metaPath)) {
            try {
                $meta = json_decode($this->disk()->get($metaPath), true, 512, JSON_THROW_ON_ERROR);
                if (! empty($meta['created_at'])) {
                    return Carbon::parse($meta['created_at']);
                }
            } catch (Throwable) {
                // Fall back to filesystem timestamp below.
            }
        }

        try {
            return Carbon::createFromTimestamp($this->disk()->lastModified($directory));
        } catch (Throwable) {
            return null;
        }
    }

    private function expectedChunkCount(int $size, int $chunkSize): int
    {
        return (int) ceil($size / $chunkSize);
    }

    private function chunkFileName(int $index): string
    {
        return 'chunk_'.$index;
    }

    private function uploadDirectory(string $uploadId): string
    {
        return $this->uploadsRoot().'/'.$uploadId;
    }

    private function uploadsRoot(): string
    {
        return (string) config('media.uploads_directory');
    }

    private function metaPath(string $directory): string
    {
        return $directory.'/meta.json';
    }

    private function chunkSize(): int
    {
        return (int) config('media.chunk_size');
    }

    private function maxFileSize(): int
    {
        return (int) config('media.max_file_size');
    }

    private function disk(): FilesystemAdapter
    {
        return Storage::disk((string) config('media.disk'));
    }
}
