<?php

namespace App\Services\Media;

use RuntimeException;

class ChunkedMediaUploadException extends RuntimeException
{
    public const REASON_SIZE = 'size';

    public const REASON_UNKNOWN_UPLOAD = 'unknown_upload';

    public const REASON_BAD_INDEX = 'bad_index';

    public const REASON_INCOMPLETE = 'incomplete';

    public function __construct(
        string $message,
        private readonly string $reason,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
