<?php

namespace App\Events;

use App\DTOs\PurchaseParams;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user, public string $password, public ?PurchaseParams $purchaseParams = null)
    {
        //
    }
}
