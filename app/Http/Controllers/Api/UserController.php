<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFollowResource;
use App\Services\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"user"},
     *     summary="Returns all user",
     *     description="Return all users that already registers successfully.",
     * @OA\Response(
     *     response=200,
     *     description="successful response"
     * )
     * )
     */
    public function getUsers(UserService $userService)
    {
        $users = $userService->getUsers();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/api/followers",
     *     tags={"user"},
     *     summary="List followers",
     *     description="Returns list of users who are followers of the currently logged in account, and you can filter by name",
     *     security={{"sanctum": {}}},
     * @OA\Parameter(
     *    description="name",
     *    in="query",
     *    name="name",
     *    required=false,
     *    example="john",
     *    @OA\Schema(
     *       type="string",
     *    )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="successful response"
     * ),
     * )
     */
    public function getFollowers(Request $request, UserService $userService)
    {
        $followers = $userService->getFollowers($request);
        return $this->sendResponse(UserFollowResource::collection($followers), 'Followers retrieved successfully.');
    }
}
