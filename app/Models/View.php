<?php

namespace App\Models;

use App\Support\Enums\MediaLang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'viewable_id',
        'viewable_type',
        'lang',
    ];

    protected $casts = [
        'lang' => MediaLang::class,
    ];

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
