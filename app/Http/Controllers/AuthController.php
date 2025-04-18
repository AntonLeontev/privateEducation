<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Mail\PasswordReset;
use App\Models\User;
use App\Services\Grecaptcha\GrecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

        if ($request->has('fragment_id') && $request->has('media_type') && $request->has('step')) {
            return to_route('home', [
                'fragment_id' => $request->get('fragment_id'),
                'media_type' => $request->get('media_type'),
                'step' => $request->get('step'),
            ]);
        }

        return to_route('personal');
    }

    public function store(Request $request, CreateNewUser $action)
    {
        $action->create($request->all());
    }

    public function storeAndBuy(Request $request, CreateNewUser $action)
    {
        $action->create($request->all());
    }

    public function login(Request $request, GrecaptchaService $grecaptcha)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $grecaptcha->check($request->get('recaptcha_token'));

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            return;
        }

        throw ValidationException::withMessages(['email' => 'Не удалось войти в аккаунт, введенные e-mail или пароль неверны']);
    }

    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect(LaravelLocalization::localizeUrl('/'));
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();

        if ($user) {
            $password = str()->password(10);

            $user->password = Hash::make($password);
            $user->save();

            Mail::to($user->email)->send(new PasswordReset($password, app()->getLocale()));
        }
    }
}
