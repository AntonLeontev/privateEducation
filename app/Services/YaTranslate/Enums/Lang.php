<?php

namespace App\Services\YaTranslate\Enums;

enum Lang: string
{
    case da = 'da'; // Danish
    case nb = 'nb'; // Norwegian Bokmål
    case is = 'is'; // Icelandic
    case it = 'it'; // Italian
    case nl = 'nl'; // Dutch
    case pt = 'pt'; // Portuguese
    case sv = 'sv'; // Swedish
    case zh = 'zh'; // Chinese (Simplified)
    case fr = 'fr'; // French
    case es = 'es'; // Spanish
    case ru = 'ru'; // Russian
    case en = 'en'; // English
    case hi = 'hi'; // Hindi

    public function toYaTranslate()
    {
        return match ($this) {
            self::da => 'da',
            self::nb => 'no',
            self::is => 'is',
            self::it => 'it',
            self::nl => 'nl',
            self::pt => 'pt',
            self::sv => 'sv',
            self::zh => 'zh',
            self::fr => 'fr',
            self::es => 'es',
            self::ru => 'ru',
            self::en => 'en',
            self::hi => 'hi',
        };
    }
}
