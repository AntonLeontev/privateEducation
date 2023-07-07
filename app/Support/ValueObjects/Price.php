<?php

namespace App\Support\ValueObjects;

use App\Exceptions\Support\PriceException;
use App\Models\Currency;
use JsonSerializable;

readonly class Price implements JsonSerializable
{
	public function __construct(public int $amount, public Currency $currency)
	{
		if ($amount < 0) {
			throw new PriceException('Amount must be greater than zero');
		}
	}

	public function jsonSerialize(): array
	{
		return [
			'amount' => $this->amount / $this->currency->fraction,
			'currency' =>  $this->currency,
		];
	}

	public function amount(): int | float
	{
		return $this->amount / $this->currency->fraction;
	}

	public function __toString(): string
	{
		return $this->amount / $this->currency->fraction . ' ' . $this->currency->sign;
	}
}
