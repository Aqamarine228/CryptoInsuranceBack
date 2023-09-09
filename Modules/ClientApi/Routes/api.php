<?php

use Modules\ClientApi\Http\Controllers\DatabaseNotificationController;
use Modules\ClientApi\Http\Controllers\EmailVerificationController;
use Modules\ClientApi\Http\Controllers\InsuranceController;
use Modules\ClientApi\Http\Controllers\InsuranceInvoiceController;
use Modules\ClientApi\Http\Controllers\InsuranceOptionController;
use Modules\ClientApi\Http\Controllers\InsuranceRequestController;
use Modules\ClientApi\Http\Controllers\LoginController;
use Modules\ClientApi\Http\Controllers\LogoutController;
use Modules\ClientApi\Http\Controllers\PaymentTransactionController;
use Modules\ClientApi\Http\Controllers\ReferralIncomeController;
use Modules\ClientApi\Http\Controllers\ReferralRequestController;
use Modules\ClientApi\Http\Controllers\ReferralsController;
use Modules\ClientApi\Http\Controllers\RegisterController;
use Modules\ClientApi\Http\Controllers\UserController;
use Modules\ClientApi\Http\Middleware\ShkeeperMiddleware;
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

Route::middleware(ShkeeperMiddleware::class)
    ->post('/shkeeper', [PaymentTransactionController::class, 'shkeeperAcceptTransaction'])
    ->name('accept-shkeeper-payment');

Route::middleware('auth:api-v1')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::prefix('/email')->middleware('throttle:6,1')->group(function () {
        Route::post('/resend-verification', [EmailVerificationController::class, 'resendVerificationEmail']);
    });
    Route::get('/user', [UserController::class, 'show']);
});

Route::middleware('signed')
    ->post('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('email.verify');


Route::middleware(['auth:api-v1', 'verified'])->group(function () {
    Route::post('/referral-request', ReferralRequestController::class);
    Route::prefix('/referrals')->group(function () {
        Route::get('/', [ReferralsController::class, 'index']);
        Route::get('/widgets-data', [ReferralsController::class, 'widgetsData']);
    });
    Route::get('/referral-income', [ReferralIncomeController::class, 'index']);

    Route::prefix('/notifications')->group(function () {
        Route::get('/', [DatabaseNotificationController::class, 'index']);
        Route::delete('/', [DatabaseNotificationController::class, 'destroy']);
        Route::post('/mark-as-read', [DatabaseNotificationController::class, 'markAsRead']);
    });

    Route::post('/insurance-request/{insuranceOption}', InsuranceRequestController::class)
        ->can('create', [InsuranceRequest::class, 'insuranceOption']);

    Route::get('/insurance-option', [InsuranceOptionController::class, 'paginate']);
    Route::post('/insurance/price', [InsuranceController::class, 'calculatePrice']);
    Route::prefix('/insurance-invoice')->group(function () {
        Route::post('/custom', [InsuranceInvoiceController::class, 'createCustom']);
        Route::post('/from-pack', [InsuranceInvoiceController::class, 'createFromPack']);
        Route::post(
            '/{insuranceInvoice}/transaction',
            [InsuranceInvoiceController::class, 'createShkeeperTransaction']
        );
    });
});
