<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function subscriptions()
    {
        return view('admin.subscriptions');
    }

    public function subscriptionsSearch(Request $request): JsonResponse
    {
        $users = User::query()
            ->with('activeSubscriptions')
            ->where('email', 'LIKE', "%{$request->get('search')}%")
            ->orWhere('name', 'LIKE', "%{$request->get('search')}%")
            ->when(is_numeric($request->get('search')), function (Builder $query) {
                return $query->orWhere('id', (int) request()->get('search'));
            })
            ->take(25)
            ->get();

        return response()->json($users);
    }

    public function verifyEmail(User $user, Request $request)
    {
        if ($user->password !== $request->password) {
            return to_route('home');
        }

        if (empty($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        auth()->login($user, true);

        return to_route('my.media');
    }
}
