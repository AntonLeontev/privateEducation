<?php

namespace App\Models;

use App\Support\Enums\AdminRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_activity',
        'remember_token',
        'two_factor_code',
        'two_factor_code_expires',
        'two_factor_code_is_used',
    ];

    protected $hidden = [
        'password',
        'two_factor_code',
    ];

    protected $casts = [
        'two_factor_code_expires' => 'datetime',
        'role' => AdminRole::class,
    ];

    public function isAdmin(): bool
    {
        return $this->role === AdminRole::admin;
    }

    public function isSeo(): bool
    {
        return $this->role === AdminRole::seo;
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->translatedFormat('d F Y');
    }

    public function getLastActivityAttribute($value): ?string
    {
        if (is_null($value)) {
            return $value;
        }

        return Carbon::parse($value)->diffForHumans();
    }
}
