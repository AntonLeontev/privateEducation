<?php

namespace App\Models;

use App\Casts\MediableCast;
use App\Support\Enums\MediaDevice;
use App\Support\Enums\MediaLang;
use App\Support\Enums\MediaSound;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'sound',
        'device',
        'lang',
        'playtime',
        'format',
        'mediable_id',
        'mediable_type',
    ];

    protected $casts = [
        'sound' => MediaSound::class,
        'device' => MediaDevice::class,
        'lang' => MediaLang::class,
        'mediable_type' => MediableCast::class,
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
