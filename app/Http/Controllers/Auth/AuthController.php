<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(
        private AuthService $authService
    )
    {
        
    }

    public function login(LoginData $credentials)
    {

        $userAndCookie = $this->authService->login($credentials);
        
        return response()->json([
            "message" => "Logado com sucesso",
            "user" => $userAndCookie['user']
        ], Response::HTTP_OK)->withCookie($userAndCookie['cookie']);

    }

    public function register(RegisterData $registerData) {

        $this->authService->register($registerData);

    }

    public function logout() {}

    public function refresh() {}
}
