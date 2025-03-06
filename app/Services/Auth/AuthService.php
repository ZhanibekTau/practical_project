<?php

namespace App\Services\Auth;

use App\Exceptions\AppException;
use App\Repositories\Auth\AuthRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param array $request
     *
     * @return string
     */
    public function create(array $request): string
    {
        $payload = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password'=>Hash::make($request['password']),
        ];

        return $this->authRepository->create($payload)->createToken('auth_token')->accessToken;
    }

    /**
     * @param array $data
     *
     * @return string
     * @throws AppException
     */
    public function login(array $data): string
    {
        $user = $this->authRepository->getUserByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AppException(
                message:"Unauthorized",
                code:Response::HTTP_UNAUTHORIZED,

            );
        }

        return $user->createToken('auth_token')->accessToken;
    }
}
