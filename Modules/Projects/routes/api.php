<?php

use Illuminate\Support\Facades\Route;
use Modules\Projects\Http\Controllers\ProjectsController;
use Modules\Projects\Http\Controllers\TasksController;

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

Route::middleware(['auth:sanctum'])->prefix('v1/projects')->group(function () {
    Route::apiResource('projects', ProjectsController::class)->names('projects');
    Route::prefix('{id}/tasks')->group(function () {
        Route::post('/', [TasksController::class, 'store']);
        Route::patch('/{task_id}', [TasksController::class, 'update']);
        Route::get('/{task_id}', [TasksController::class, 'get']);
        Route::delete('/{task_id}', [TasksController::class, 'delete']);
    });
});
