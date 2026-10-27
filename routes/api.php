<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::prefix('auth')->group(function (): void {

    Route::post('/login', [AuthController::class, "login"]);
    Route::post('/register', [AuthController::class, "register"]);
});

Route::middleware('auth:api')->prefix('adm')->group(function (): void {

    Route::post('/link', [LinkController::class, 'store']);
});
