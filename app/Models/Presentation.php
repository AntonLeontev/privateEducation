<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title_ru',
        'title_en',
        'text_ru',
        'text_en',
        'fragment_id',
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function fragment(): BelongsTo
    {
        return $this->belongsTo(Fragment::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(PresentationView::class);
    }
}
