<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['nullable', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:50'],
            'apartment' => ['nullable', 'string', 'max:50'],
            'zip' => ['nullable', 'string', 'max:50'],
        ])->validate();

        $user->update([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'phone' => $input['phone'],
            'country' => $input['country'],
            'city' => $input['city'],
            'street' => $input['street'],
            'building' => $input['building'],
            'apartment' => $input['apartment'],
            'zip' => $input['zip'],
        ]);
    }
}
