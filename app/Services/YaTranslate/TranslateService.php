<?php

namespace App\Services\YaTranslate;

use App\Services\YaTranslate\Enums\Format;
use App\Services\YaTranslate\Enums\Lang;

class TranslateService
{
    public function __construct(
        public TranslateApi $api,
    ) {}

    public function translateToRu(string $text): string
    {
        return $this->api->translate([$text], Lang::ru, Format::PLAIN_TEXT)
            ->json('translations.0.text');
    }

    public function translateWithAi(string $text): string
    {
        $messages = [
            [
                'role' => 'system',
                'text' => 'Переведи иностранное имя или фамилию на русский язык. Если имя или фамилия на русском языке, то верни его как есть. В ответе должно быть только имя или фамилия. Не должно быть знаков препинания. Допускаются дефисы или пробелы в двойном имени или фамилии.',
            ],
            [
                'role' => 'user',
                'text' => $text,
            ],
        ];

        return $this->api->completion($messages)->json('result.alternatives.0.message.text');
    }
}
