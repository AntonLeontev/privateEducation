<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Audio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'price',
    ];

    protected $with = [
        'media',
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function subscription(): MorphOne
    {
        return $this->morphOne(Subscription::class, 'subscribable')
            ->where('user_id', auth()->id())
            ->where('ends_at', '>', now());
    }

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
