<?php

use Illuminate\Support\Facades\Route;
use Modules\Teams\Http\Controllers\TeamsController;
use Modules\Teams\Http\Controllers\TeamInviteController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('teams', TeamsController::class)->names('teams');
    Route::prefix('team-invites')->group(function () {
        Route::post('/invite', [TeamInviteController::class, 'sendInvite']);
        Route::post('/accept', [TeamInviteController::class, 'acceptInvite']);
    });
});
