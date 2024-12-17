<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
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
            ->search()
            ->take(25)
            ->get();

        return response()->json($users);
    }

    public function personal()
    {
        $subscriptions = auth()->user()->activeSubscriptions()->get();

        return view('personal', compact('subscriptions'));
    }

    public function update(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->password = bcrypt($request->get('new_password'));
        auth()->user()->save();
    }
}
