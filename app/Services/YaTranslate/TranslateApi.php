<?php

namespace App\Services\YaTranslate;

use App\Services\YaTranslate\Enums\Format;
use App\Services\YaTranslate\Enums\Lang;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TranslateApi
{
    public function client()
    {
        return Http::baseUrl('https://translate.api.cloud.yandex.net/translate/v2')
            ->asJson()
            ->withHeader('Authorization', 'Api-Key '.config('services.translate.key'))
            ->throw();
    }

    public function languages(): Response
    {
        return $this->client()->post('languages', ['q' => '']);
    }

    public function detectLanguage(string $text): Response
    {
        return $this->client()->post('detect', ['text' => $text]);
    }

    public function translate(
        array $texts,
        Lang $targetLanguage,
        Format $format,
    ): Response {
        return $this->client()->post('translate', [
            'texts' => $texts,
            'targetLanguageCode' => $targetLanguage->toYaTranslate(),
            'format' => $format->value,
        ]);
    }
}
