<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Override;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RefreshTokenExpiredException extends JWTException
{

    public function __construct()
    {
        parent::__construct('Refresh token expirado', Response::HTTP_UNAUTHORIZED);
    }

    public function report(): bool
    {
        return false;
    }

    public function render(): JsonResponse
    {

        return response()
            ->json([
                'message' => $this->getMessage()
            ], $this->getCode())
            ->withoutCookie('auth_token');
    }
}
