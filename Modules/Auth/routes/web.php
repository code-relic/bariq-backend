<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\EmailVerificationController;
use Modules\Auth\Http\Middleware\VerifyAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('auth', AuthController::class)->names('auth');
});
Route::post('/email/verify/resend', [EmailVerificationController::class, 'resend'])->middleware('auth:sanctum')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
 ->middleware([VerifyAuth::class])
->name('verification.verify');