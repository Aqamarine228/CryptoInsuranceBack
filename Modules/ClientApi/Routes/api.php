<?php

use Modules\ClientApi\Http\Controllers\EmailVerificationController;
use Modules\ClientApi\Http\Controllers\LoginController;
use Modules\ClientApi\Http\Controllers\LogoutController;
use Modules\ClientApi\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::prefix('/email')->middleware('throttle:6,1')->group(function () {
        Route::post('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('api.v1.email.verify');
        Route::post('/resend-verification', [EmailVerificationController::class, 'resendVerificationEmail']);
    });
});
