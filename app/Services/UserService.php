<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function getUsers()
    {
        return User::orderBy('id')->get();
    }

    public function getFollowers($request)
    {
        if ($request->name) {
            $followers = UserFollow::join('users', 'users.id', '=', 'user_id')
                ->where('following_user_id', $request->user()->id)
                ->where('name', 'LIKE', "%{$request->name}%")
                ->get();
        } else {
            $followers = $request->user()->followers;
        }

        return $followers;
    }
}
