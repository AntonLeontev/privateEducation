<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title_ru',
        'title_en',
        'price',
        'price_rub',
        'price_usd',
        'fragment_id',
    ];

    protected $with = [
        'media',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'price_rub' => PriceCast::class,
        'price_usd' => PriceCast::class,
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function fragment(): BelongsTo
    {
        return $this->belongsTo(Fragment::class);
    }

    public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }
}
