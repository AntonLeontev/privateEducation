<?php

namespace App\Console\Commands;

use App\Services\Media\ChunkedMediaUploadService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class PurgeStaleMediaUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-stale-media-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет брошенные каталоги чанковой загрузки медиа старше TTL';

    /**
     * Execute the console command.
     */
    public function handle(ChunkedMediaUploadService $uploads): int
    {
        try {
            $purged = $uploads->purgeExpired();
        } catch (Throwable $exception) {
            Log::error('Failed to purge stale media uploads', [
                'error' => $exception->getMessage(),
            ]);

            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info("Удалено каталогов: {$purged}");

        return self::SUCCESS;
    }
}
