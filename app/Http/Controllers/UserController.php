<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
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
        return view('personal');
    }

    public function update() {}

    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->password = bcrypt($request->get('new_password'));
        auth()->user()->save();
    }
}
