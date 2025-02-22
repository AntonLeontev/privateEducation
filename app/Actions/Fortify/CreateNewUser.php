<?php

namespace App\Actions\Fortify;

use App\DTOs\PurchaseParams;
use App\Events\UserRegistered;
use App\Models\User;
use App\Services\Grecaptcha\GrecaptchaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateNewUser
{
    use PasswordValidationRules;

    public function __construct(private GrecaptchaService $grecaptcha) {}

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input, bool $withBuy = false): User
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'fragment_id' => ['sometimes', 'min:1', 'max:17'],
            'media_type' => ['sometimes', 'in:audio,video'],
        ])->validate();

        $password = str()->password(10);

        $this->grecaptcha->check($input['recaptcha_token']);

        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $input['email'],
                'password' => Hash::make($password),
                'ip' => request()->ip(),
            ]);

            if (isset($input['fragment_id']) && isset($input['media_type'])) {
                $purchaseParams = new PurchaseParams(
                    $input['fragment_id'],
                    $input['media_type'],
                    'step4',
                );
            } else {
                $purchaseParams = null;
            }

            event(new UserRegistered($user, $password, $purchaseParams));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();

        return $user;
    }
}
