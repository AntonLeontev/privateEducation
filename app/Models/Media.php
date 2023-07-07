<?php

namespace App\Models;

use App\Support\Enums\MediaLang;
use App\Support\Enums\MediaSound;
use App\Support\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

	protected $fillable = [
		'path',
		'type',
		'sound',
		'lang',
		'mediable_id',
		'mediable_type',
	];

	protected $casts = [
		'type' => MediaType::class,
		'sound' => MediaSound::class,
		'lang' => MediaLang::class,
	];

	public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
