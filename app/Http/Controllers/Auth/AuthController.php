<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        if (!$token = Auth::attempt($credentials)) {
            return response(
                [
                    "error" => "Email ou senha errado"
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $cookie = cookie('access_token', $token, 30, null, null, true);

        return response([
            "message" => "Logado com sucesso"
        ], Response::HTTP_OK)->withCookie($cookie);
    }

    public function register() {}

    public function logout() {}

    public function refresh() {
        
    }

}
