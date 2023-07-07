<?php

namespace App\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Audio extends Model
{
    use HasFactory;

	protected $fillable = [
		'id',
		'title_ru',
		'title_en',
		'price',
		'currency_id',
		'fragment_id',
	];

	protected $with = [
		'currency',
	];

	protected $casts = [
		'price' => PriceCast::class,
	];

	public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

	public function fragment(): BelongsTo
	{
		return $this->belongsTo(Fragment::class);
	}

	public function currency(): BelongsTo
	{
		return $this->belongsTo(Currency::class);
	}

	public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }
}
