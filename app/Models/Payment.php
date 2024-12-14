<?php

namespace App\Models;

use App\Casts\PriceCast;
use App\Enums\Currency;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'amount',
        'currency',
        'status',
        'fragment_id',
        'media_type',
    ];

    protected $casts = [
        'amount' => PriceCast::class,
        'currency' => Currency::class,
        'status' => PaymentStatus::class,
        'confirmed_by_webhook_at' => 'datetime',
        'confirmed_by_redirect_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
