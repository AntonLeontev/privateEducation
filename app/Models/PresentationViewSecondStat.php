<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationViewSecondStat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'visit_id',
        'presentation_id',
        'second_index',
        'is_passive',
        'hit_count',
    ];

    protected $casts = [
        'second_index' => 'integer',
        'is_passive' => 'boolean',
        'hit_count' => 'integer',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }
}
