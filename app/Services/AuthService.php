<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function login($credentials)
    {

        $token = Auth::attempt($credentials);

        if (!$token) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();

        $cookie = cookie('jwt', $token, 60 * 24, null, null, true);

        return [
            "cookie" => $cookie,
            "user" => $user
        ];
    }

    public function register() {
        
    }
}
