<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Register user",
     * description="Register user to create account",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Send user data for register",
     *    @OA\JsonContent(
     *       required={"name","email","username","password","confirmPassword","address","phone","website","company"},
     *       @OA\Property(property="name", type="string", example="John Doe"),
     *       @OA\Property(property="email", type="string", format="email", example="johndoe@gmail.com"),
     *       @OA\Property(property="username", type="string", example="john"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *       @OA\Property(property="confirmPassword", type="string", format="password", example="password"),
     *       @OA\Property(property="address", type="object",
     *          @OA\Property(property="street", type="string", example="Kulas Light"),
     *          @OA\Property(property="suite", type="string", example="Apt. 556"),
     *          @OA\Property(property="city", type="string", example="Gwenborough"),
     *          @OA\Property(property="zipcode", type="string", example="92998-3874"),
     *          @OA\Property(property="geo", type="object",
     *              @OA\Property(property="lat", type="string", example="-37.3159"),
     *              @OA\Property(property="lng", type="string", example="81.1496"),
     *          ),
     *       ),
     *       @OA\Property(property="phone", type="number", example="0891231310"),
     *       @OA\Property(property="website", type="number", example="johndoe.com"),
     *       @OA\Property(property="company", type="object",
     *          @OA\Property(property="name", type="string", example="Romaguera-Crona"),
    *           @OA\Property(property="catchPhrase", type="string", example="Multi-layered client-server neural-net"),
    *           @OA\Property(property="bs", type="string", example="harness real-time e-markets"),
     *       ),
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
     *       @OA\Property(property="message", type="string", example="Validation Error."),
     *       @OA\Property(property="data", type="object"),
     *        )
     *     )
     * )
     */
    public function register(RegisterRequest $request, AuthService $authService)
    {
        $user = $authService->register($request);
        return $this->sendResponse($user, 'User register successfully.');
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Log in user",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="johndoe@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="successful response"
     * ),
     * @OA\Response(
     *    response=401,
     *    description="unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Unauthorized."),
     *       @OA\Property(property="data", type="object"),
     *        )
     *     )
     * )
     */
    public function login(LoginRequest $request, AuthService $authService)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $login = $authService->generateToken();

            return $this->sendResponse($login, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized'], 401);
        }
    }
}
