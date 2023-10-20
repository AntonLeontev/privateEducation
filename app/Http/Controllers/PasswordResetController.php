<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();

        if ($user) {
            $password = str()->password(10);

            $user->password = Hash::make($password);
            $user->save();

            Mail::to($user->email)->send(new PasswordReset($password));
        }
    }
}
