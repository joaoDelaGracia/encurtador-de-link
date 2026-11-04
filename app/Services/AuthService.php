<?php

namespace App\Services;

use App\Data\Auth\LoginDto;
use App\Data\Auth\LoginResultDto;
use App\Data\Auth\RegisterDto;
use App\Data\Users\UsersData;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\RefreshTokenExpiredException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function login(LoginDto $credentials): LoginResultDto
    {

        $token = Auth::attempt($credentials->toArray());

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();
        $cookie = cookie('auth_token', $token, 20160, null, null, true);

        return new LoginResultDto($cookie, $user);
    }

    public function refresh()
    {
        try {

            $token = Auth::refresh();
            return cookie('auth_token', $token, 20160, null, null, true);
        } catch (JWTException $e) {
            throw new RefreshTokenExpiredException();
        }
    }

    public function register(RegisterDto $registerDto): User
    {

        return DB::transaction(function () use ($registerDto): User {

            return $this->repository->create($registerDto->toArray());
        });
    }
}
