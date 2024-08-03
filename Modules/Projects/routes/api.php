<?php

use Illuminate\Support\Facades\Route;
use Modules\Projects\Http\Controllers\ProjectsController;

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

Route::prefix('v1')->group(function () {
    Route::apiResource('projects', ProjectsController::class)->names('projects');
});
