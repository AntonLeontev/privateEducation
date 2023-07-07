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
		'price_en',
		'price_ru',
		'currency_en',
		'currency_ru',
		'fragment_id',
	];

	protected $with = [
		'currencyRu',
		'currencyEn',
	];

	protected $casts = [
		'price_ru' => PriceCast::class,
		'price_en' => PriceCast::class,
	];

	public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

	public function fragment(): BelongsTo
	{
		return $this->belongsTo(Fragment::class);
	}

	public function currencyRu(): HasOne
	{
		return $this->hasOne(Currency::class, 'id', 'currency_ru');
	}

	public function currencyEn(): HasOne
	{
		return $this->hasOne(Currency::class, 'id', 'currency_en');
	}
}
