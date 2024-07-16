<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function verifyEmail(User $user, Request $request)
    {
        if ($user->password !== $request->get('password')) {
            return to_route('home');
        }

        if (empty($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        auth()->login($user, true);

        return to_route('personal');
    }

    public function store(Request $request, CreateNewUser $action)
    {
        $action->create($request->all());
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        throw new \Exception('The provided credentials do not match our records.');
    }

    public function destroy()
    {
        auth()->logout();

        return to_route('home');
    }
}
