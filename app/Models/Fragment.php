<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Fragment extends Model
{
    use HasFactory;

	protected $fillable = [
		'title_ru',
		'title_en',
	];

	public function presentation(): HasOne
	{
		return $this->hasOne(Presentation::class);
	}

	public function audio(): HasOne
	{
		return $this->hasOne(Audio::class);
	}

	public function video(): HasOne
	{
		return $this->hasOne(Video::class);
	}
}
