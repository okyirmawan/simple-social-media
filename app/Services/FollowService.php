<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserFollow;

class FollowService
{
    /**
     * @throws \Exception
     */
    public function follow($request)
    {
        if($request->following_user_id == $request->user()->id){
            throw new \Exception("can't follow yourself");
        }

        User::findOrFail($request->following_user_id);

        return UserFollow::create([
            'user_id' => $request->user()->id,
            'following_user_id' => $request->following_user_id,
        ]);
    }

    public function unfollow($request): int
    {
        return UserFollow::where('following_user_id', $request->following_user_id)
            ->where('user_id', $request->user()->id)
            ->delete();
    }
}
