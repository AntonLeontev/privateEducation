<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property ?string $name
 * @property ?string $surname
 * @property string $email
 * @property string $password
 * @property ?string $ip
 * @property ?string $country_from_ip
 * @property ?string $country_code
 * @property ?string $region
 * @property ?string $region_code
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'phone',
        'country',
        'city',
        'street',
        'building',
        'apartment',
        'zip',
        'last_subscription_time',
        'ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_subscription_time' => 'datetime',
        'password' => 'hashed',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->orderByDesc('created_at');
    }

    public function activeSubscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->where('ends_at', '>=', now());
    }

    public function lastSubscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->orderByDesc('created_at');
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function presentationViews(): HasMany
    {
        return $this->hasMany(PresentationView::class);
    }

    public function actionLogs(): HasMany
    {
        return $this->hasMany(ActionLog::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'code', 'country_code');
    }

    public function newEloquentBuilder($query)
    {
        return new UserQueryBuilder($query);
    }
}
