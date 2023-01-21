<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register($request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        return User::create($input);
    }

    public function generateToken(): array
    {
        $user = Auth::user();
        $success['token'] = $user->createToken('SocialMedia')->plainTextToken;
        $success['name'] = $user->name;

        return $success;
    }
}
