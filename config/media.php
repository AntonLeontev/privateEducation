<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chunked media upload
    |--------------------------------------------------------------------------
    |
    | Admin uploads go to the `media` disk in sequential ~8 MiB chunks.
    | Complete assembles them only after every chunk arrives.
    |
    */

    'disk' => 'media',

    'chunk_size' => 8 * 1024 * 1024,

    'max_file_size' => 4 * 1024 * 1024 * 1024,

    'upload_ttl_hours' => 24,

    'uploads_directory' => 'uploads',

];
