<?php

namespace App\Http\Controllers\Auth;

use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginData $credentials)
    {

        $userAndCookie = $this->authService->login($credentials);

        return response()->json([
            "message" => "Logado com sucesso",
            "user" => $userAndCookie['user']
        ], Response::HTTP_OK)->withCookie($userAndCookie['cookie']);
    }

    public function register(RegisterUserFormRequest $request)
    {

        $user = $this->authService->register($request->paraDto());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function logout() {}

    public function refresh() {}
}
