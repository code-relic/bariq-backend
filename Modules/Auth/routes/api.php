<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\TwoFactorAuthController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::prefix('v1/auth')->group(function () {
    Route::post("/register",[AuthController::class,"register"]);
    Route::post("/login",[AuthController::class,"login"]);
    Route::prefix("2fa")->group(function(){
        Route::get("/",[TwoFactorAuthController::class,"GetMethods"]);
    });
});
