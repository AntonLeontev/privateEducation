<?php

namespace App\DTOs;

class PurchaseParams
{
    public function __construct(
        public int $fragmentId,
        public string $mediaType,
        public string $step,
    ) {}
}
