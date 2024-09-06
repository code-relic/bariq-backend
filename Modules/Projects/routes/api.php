<?php

use Illuminate\Support\Facades\Route;
use Modules\Projects\Http\Controllers\ListsController;
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
    Route::resources(['projects' => ProjectsController::class]);
    Route::prefix('{project_id}/lists')->group(function () {
        Route::get('/', [ListsController::class, 'index'])->name('lists.index');
        Route::post('/', [ListsController::class, 'store'])->name('lists.store');
        Route::get('{list_id}', [ListsController::class, 'show'])->name('lists.show');
        Route::put('{list_id}', [ListsController::class, 'update'])->name('lists.update');
        Route::patch('{list_id}', [ListsController::class, 'update'])->name('lists.update');
        Route::delete('{list_id}', [ListsController::class, 'destroy'])->name('lists.destroy');
    });

    Route::prefix('{id}/tasks')->group(function () {
        Route::post('/', [TasksController::class, 'store']);
        Route::patch('/{task_id}', [TasksController::class, 'update']);
        Route::get('/{task_id}', [TasksController::class, 'get']);
        Route::delete('/{task_id}', [TasksController::class, 'delete']);
    });
});
