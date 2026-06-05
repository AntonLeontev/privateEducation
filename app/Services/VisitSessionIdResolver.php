<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VisitSessionIdResolver
{
    public function resolve(?string $raw): ?string
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        $raw = trim($raw);

        if (Str::isUuid($raw)) {
            return strtolower($raw);
        }

        if (preg_match('/^[a-f0-9]{40}\|([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})$/i', $raw, $matches) === 1) {
            return strtolower($matches[1]);
        }

        if (str_starts_with($raw, 'eyJ')) {
            try {
                $decrypted = Crypt::decryptString($raw);

                return $this->resolve($decrypted);
            } catch (DecryptException $exception) {
                Log::warning('[FIX] VisitSessionIdResolver: failed to decrypt visit session cookie', [
                    'input_length' => strlen($raw),
                    'error' => $exception->getMessage(),
                ]);

                return null;
            }
        }

        Log::warning('[FIX] VisitSessionIdResolver: rejected invalid visit session id', [
            'input_length' => strlen($raw),
            'input_prefix' => substr($raw, 0, 24),
        ]);

        return null;
    }
}
