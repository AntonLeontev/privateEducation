<?php

namespace App\Models;

use App\Events\PresentationViewCreated;
use App\Support\Enums\MediaLang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresentationView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'presentation_id',
        'lang',
        'is_reading',
    ];

    protected $casts = [
        'lang' => MediaLang::class,
        'is_reading' => 'boolean',
    ];

    protected $dispatchesEvents = [
        'created' => PresentationViewCreated::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }
}
