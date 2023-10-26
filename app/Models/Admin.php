<?php

namespace App\Models;

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
    ];
}
