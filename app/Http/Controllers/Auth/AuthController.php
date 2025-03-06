<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(
        private AuthService $authService,
    ) {

    }

    /**
     * @param RegisterFormRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterFormRequest $request): JsonResponse
    {
        $token = $this->authService->create($request->validated());

        return $this->response($token);
    }

    /**
     * @param LoginFormRequest $request
     *
     * @return JsonResponse
     * @throws AppException
     */
    public function login(LoginFormRequest $request): JsonResponse
    {
        return $this->response($this->authService->login($request->validated()));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->response('Successfully logged out');
    }
}
