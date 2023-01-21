<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;
use App\Http\Resources\UserFollowResource;
use App\Services\FollowService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

class FollowController extends Controller
{
    use ApiResponser;

    /**
     * @OA\Post(
     *     path="/api/follow",
     *     tags={"follow"},
     *     summary="Following user",
     *     description="Following user",
     *     security={{"sanctum": {}}},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user id you want to follow",
     *    @OA\JsonContent(
     *       required={"following_user_id"},
     *       @OA\Property(property="following_user_id", type="int", format="number", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="successful response"
     * ),
     * @OA\Response(
     *    response=400,
     *    description="bad request",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Follow was error."),
     *       @OA\Property(property="data", type="object"),
     *        )
     *     )
     * )
     * )
     */
    public function follow(FollowRequest $request, FollowService $followService)
    {
        try {
            $following = $followService->follow($request);

            return $this->sendResponse(new UserFollowResource($following->following), 'Follow was successful.');
        } catch (\Exception $e) {
            return $this->sendError('Follow was error.', ['error' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/unfollow",
     *     tags={"follow"},
     *     summary="Unfollow user",
     *     description="Unfollow user",
     *     security={{"sanctum": {}}},
     * @OA\Response(
     *     response=200,
     *     description="successful response"
     * ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user id you want to unfollow",
     *    @OA\JsonContent(
     *       required={"following_user_id"},
     *       @OA\Property(property="following_user_id", type="int", format="number", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=400,
     *    description="bad request",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Unfollow was error."),
     *       @OA\Property(property="data", type="object"),
     *        )
     *     )
     * )
     * )
     */
    public function unfollow(FollowRequest $request, FollowService $followService)
    {
        $unfollow = $followService->unfollow($request);

        if ($unfollow > 0) {
            return $this->sendResponse([], 'Unfollow was successful.');
        } else {
            return $this->sendError('Unfollow was error.', ['error' => 'Data not found']);
        }
    }
}
