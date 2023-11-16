<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'amount',
        'currency',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->translatedFormat('d.m.y H:i');
    }

    public function getStatusAttribute($value)
    {
        return match ($value) {
            'init' => 'Создана',
            'success' => 'Успешно',
            'declined' => 'Не успешно',
            'canceled' => 'Отменено',
        };
    }
}
