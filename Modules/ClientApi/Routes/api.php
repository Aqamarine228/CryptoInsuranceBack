<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientApi\Http\Controllers\DashboardController;
use Modules\ClientApi\Http\Controllers\DatabaseNotificationController;
use Modules\ClientApi\Http\Controllers\EmailVerificationController;
use Modules\ClientApi\Http\Controllers\InsuranceController;
use Modules\ClientApi\Http\Controllers\InsuranceCoverageOptionController;
use Modules\ClientApi\Http\Controllers\InsuranceInformationController;
use Modules\ClientApi\Http\Controllers\InsuranceInvoiceController;
use Modules\ClientApi\Http\Controllers\InsuranceOptionController;
use Modules\ClientApi\Http\Controllers\InsurancePackController;
use Modules\ClientApi\Http\Controllers\InsuranceRequestController;
use Modules\ClientApi\Http\Controllers\InsuranceSubscriptionOptionController;
use Modules\ClientApi\Http\Controllers\LoginController;
use Modules\ClientApi\Http\Controllers\LogoutController;
use Modules\ClientApi\Http\Controllers\NewsController;
use Modules\ClientApi\Http\Controllers\PaymentTransactionController;
use Modules\ClientApi\Http\Controllers\ReferralIncomeController;
use Modules\ClientApi\Http\Controllers\ReferralRequestController;
use Modules\ClientApi\Http\Controllers\ReferralsController;
use Modules\ClientApi\Http\Controllers\RegisterController;
use Modules\ClientApi\Http\Controllers\UserController;
use Modules\ClientApi\Http\Controllers\WithdrawalRequestController;
use Modules\ClientApi\Http\Middleware\ShkeeperMiddleware;
use Modules\ClientApi\Models\DatabaseNotification;
use Modules\ClientApi\Models\Insurance;
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
    Route::get('/referral-income/history-data', [ReferralIncomeController::class, 'historyData']);

    Route::prefix('/notifications')->group(function () {
        Route::get('/', [DatabaseNotificationController::class, 'index']);
        Route::get('/{databaseNotification}', [DatabaseNotificationController::class, 'show']);
        Route::delete('/', [DatabaseNotificationController::class, 'destroy']);
        Route::post('/mark-as-read', [DatabaseNotificationController::class, 'markAsRead']);
        Route::post('/{databaseNotification}', [DatabaseNotificationController::class, 'show'])
            ->can('show', [DatabaseNotification::class, 'databaseNotification']);
    });

    Route::post('/insurance-request/{insuranceOption}', InsuranceRequestController::class)
        ->can('create', [InsuranceRequest::class, 'insuranceOption']);

    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{post}', [NewsController::class, 'show']);

    Route::get('/withdrawal-request', [WithdrawalRequestController::class, 'index']);
    Route::post('/withdrawal-request', [WithdrawalRequestController::class, 'create']);

    Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);

    Route::get('/insurance-pack', [InsurancePackController::class, 'index']);
    Route::get('/insurance-option', [InsuranceOptionController::class, 'index']);
    Route::get('/insurance-option/{insuranceOption}', [InsuranceOptionController::class, 'show']);
    Route::get('/insurance-subscription-option', [InsuranceSubscriptionOptionController::class, 'index']);
    Route::get('/insurance-coverage-option', [InsuranceCoverageOptionController::class, 'index']);

    Route::get('/insurance', [InsuranceController::class, 'index']);

    Route::get('/insurance/statistics', [InsuranceController::class, 'statistic']);
    Route::get('/insurance/recent-activity', [InsuranceController::class, 'recentActivity']);

    Route::get('/insurance/{insurance}', [InsuranceController::class, 'show'])
        ->can('show', [Insurance::class, 'insurance']);

    Route::get('/insurance/{insurance}/information', [InsuranceController::class, 'showWithInformation'])
        ->can('show', [Insurance::class, 'insurance']);
    Route::post('/insurance/{insurance}/information', [InsuranceInformationController::class, 'store'])
        ->can('storeInformation', [Insurance::class, 'insurance']);

    Route::prefix('/insurance-invoice')->group(function () {
        Route::post('/custom', [InsuranceInvoiceController::class, 'createCustom']);
        Route::post('/from-pack', [InsuranceInvoiceController::class, 'createFromPack']);
        Route::post(
            '/{insuranceInvoice}/transaction',
            [InsuranceInvoiceController::class, 'createShkeeperTransaction']
        );
        Route::post(
            '/{insuranceInvoice}/coinbase',
            [InsuranceInvoiceController::class, 'createCoinbaseInvoice']
        );
        Route::get('/{insuranceInvoice}', [InsuranceInvoiceController::class, 'show']);
    });
});
