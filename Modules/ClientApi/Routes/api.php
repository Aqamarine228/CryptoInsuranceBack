<?php

use Modules\ClientApi\Http\Controllers\DatabaseNotificationController;
use Modules\ClientApi\Http\Controllers\EmailVerificationController;
use Modules\ClientApi\Http\Controllers\InsuranceRequestController;
use Modules\ClientApi\Http\Controllers\LoginController;
use Modules\ClientApi\Http\Controllers\LogoutController;
use Modules\ClientApi\Http\Controllers\ReferralRequestController;
use Modules\ClientApi\Http\Controllers\RegisterController;
use Modules\ClientApi\Models\InsuranceRequest;

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

Route::middleware('auth:api-v1')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::prefix('/email')->middleware('throttle:6,1')->group(function () {
        Route::post('/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('api.v1.email.verify');
        Route::post('/resend-verification', [EmailVerificationController::class, 'resendVerificationEmail']);
    });
});


Route::middleware(['auth:api-v1', 'verified'])->group(function () {
    Route::post('/referral-request', ReferralRequestController::class);

    Route::prefix('/notifications')->group(function () {
        Route::get('/', [DatabaseNotificationController::class, 'index']);
        Route::delete('/', [DatabaseNotificationController::class, 'destroy']);
        Route::post('/mark-as-read', [DatabaseNotificationController::class, 'markAsRead']);
    });

    Route::post('/insurance-request/{insuranceOption}', InsuranceRequestController::class)
        ->can('create', [InsuranceRequest::class, 'insuranceOption']);
});
