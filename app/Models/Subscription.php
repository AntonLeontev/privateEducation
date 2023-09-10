<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\Casts\SubscribableTypeCast;
use App\Support\Enums\MediaLang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'subscribable_id',
        'subscribable_type',
        'lang',
        'price',
        'currency_id',
        'location',
        'ends_at',
    ];

    protected $casts = [
        'ends_at' => 'date',
        'lang' => MediaLang::class,
        'price' => PriceCast::class,
		'subscribable_type' => SubscribableTypeCast::class,
    ];

    protected $with = [];

    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Subscription $sub) {
            $sub->ends_at = $sub->created_at->addDays(30);
        });
    }
}
