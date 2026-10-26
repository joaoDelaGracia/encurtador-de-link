<?php

namespace App\Services;

use App\Data\Auth\LoginData;
use App\Data\Auth\LoginResultDto;
use App\Data\Auth\RegisterDataDto;
use App\Data\Users\UsersData;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function login(LoginData $credentials): LoginResultDto
    {

        $token = Auth::attempt($credentials->toArray());

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();
        $cookie = cookie('auth_token', $token, 30, null, null, true);

        return new LoginResultDto($cookie, $user);

    }

    public function refresh()
    {
        
    }

    public function register(RegisterDataDto $registerDataDto): User {

        return DB::transaction(function () use($registerDataDto): User {
           
            return $this->repository->create($registerDataDto->toArray());

        });
        
    }
}
