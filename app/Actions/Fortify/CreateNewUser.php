<?php

namespace App\Actions\Fortify;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateNewUser
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
        ])->validate();

        $password = str()->password(10);

        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $input['email'],
                'password' => Hash::make($password),
            ]);

            event(new UserRegistered($user, $password));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();

        return $user;
    }
}
