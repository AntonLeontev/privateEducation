<?php

namespace App\Services\Grecaptcha;

use App\Services\Grecaptcha\Exceptions\GrecaptchaException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class GrecaptchaService
{
    public function verify(string $token): bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
        ];

        $response = Http::asForm()->post($url, $data);

        if ($response->json('error-codes')) {
            throw new GrecaptchaException(implode(', ', $response->json('error-codes')));
        }

        return $response->json('success') && $response->json('score', 0.5) >= 0.5;
    }

    public function check(string $token): void
    {
        try {
            $captchaSuccess = $this->verify($token);
        } catch (GrecaptchaException $e) {
            $captchaSuccess = true;
            Log::alert('Проблемы с капчей: '.$e->getMessage());
        }

        if (! $captchaSuccess) {
            throw ValidationException::withMessages(['email' => 'Ошибка прохождения капчи']);
        }
    }
}
