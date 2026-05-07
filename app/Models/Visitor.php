<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'ip',
        'user_agent',
        'device_type',
        'country_code',
        'country_name',
        'first_visit_at',
        'last_visit_at',
        'visits_count',
        'utm_first_source',
        'utm_first_medium',
        'utm_first_campaign',
        'utm_first_term',
        'utm_first_content',
        'utm_last_source',
        'utm_last_medium',
        'utm_last_campaign',
        'utm_last_term',
        'utm_last_content',
        'referrer_first',
        'referrer_last',
    ];

    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function presentationViewTimes(): HasMany
    {
        return $this->hasMany(PresentationViewTime::class);
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }
}
