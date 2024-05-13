<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductApiController;
use App\Http\Middleware\AuthorizationToken;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::middleware([AuthorizationToken::class])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthenticatedSessionController::class, 'authenticateApi']);
            Route::post('loginId', [AuthenticatedSessionController::class, 'authenticateIdApi']);
            Route::post('register', [RegisteredUserController::class, 'registerApi']);
            Route::post('reset-password', [PasswordResetLinkController::class, 'store']);
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductApiController::class, 'getProducts']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('user')->group(function () {
            Route::post('logout', [AuthenticatedSessionController::class, 'logoutApi']);
            Route::get('me', [AuthenticatedSessionController::class,'me']);
        });
    });


});
