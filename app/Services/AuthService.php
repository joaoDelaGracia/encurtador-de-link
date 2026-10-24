<?php

namespace App\Services;

use App\Data\Auth\LoginData;
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

    public function login(LoginData $credentials)
    {

        $token = Auth::attempt($credentials->toArray());

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        $user = UsersData::from(Auth::user());

        $cookie = cookie('jwt', $token, 30, null, null, true);

        return [
            "cookie" => $cookie,
            "user" => $user
        ];

    }

    public function register(RegisterDataDto $registerDataDto): User {

        return DB::transaction(function () use($registerDataDto): User {
           
            return $this->repository->create($registerDataDto->toArray());

        });
        
    }
}
