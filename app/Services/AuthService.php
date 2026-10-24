<?php

namespace App\Services;

use App\Data\Auth\LoginData;
use App\Data\Users\UsersData;
use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function login(LoginData $credentials)
    {

        $token = Auth::attempt($credentials);

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

    public function register() {
        
    }
}
