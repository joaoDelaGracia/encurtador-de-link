<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterUserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginFormRequest $request)
    {
        $loginResultDto = $this->authService->login($request->paraDto());

        return (new UserResource($loginResultDto->user))
            ->additional(["message" => "Login efetuado com sucesso"])
            ->response()
            ->setStatusCode(Response::HTTP_OK)
            ->withCookie($loginResultDto->cookie);
    }

    public function register(RegisterUserFormRequest $request)
    {

        $user = $this->authService->register($request->paraDto());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function logout() {}


    public function refresh()
    {

        $cookie = $this->authService->refresh();

        return response()
            ->json([], Response::HTTP_OK)
            ->withCookie($cookie);
    }
}
