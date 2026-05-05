<?php

namespace App\Services\YaTranslate\Enums;

enum Format: string
{
    case FORMAT_UNSPECIFIED = 'FORMAT_UNSPECIFIED';
    case PLAIN_TEXT = 'PLAIN_TEXT';
    case HTML = 'HTML';
}
