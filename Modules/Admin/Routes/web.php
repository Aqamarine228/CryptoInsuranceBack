<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\InsuranceCoverageOptionController;
use Modules\Admin\Http\Controllers\InsuranceOptionController;
use Modules\Admin\Http\Controllers\InsuranceOptionFieldController;
use Modules\Admin\Http\Controllers\InsurancePackController;
use Modules\Admin\Http\Controllers\InsuranceRequestController;
use Modules\Admin\Http\Controllers\InsuranceSubscriptionOptionController;
use Modules\Admin\Http\Controllers\LoginController;
use Modules\Admin\Http\Controllers\ReferralRequestController;

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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'submitLogin'])->name('login');

Route::middleware('auth:admin')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::prefix('/referral-request')->name('referral-request.')->group(function () {
        Route::get('/', [ReferralRequestController::class, 'index'])->name('index');
        Route::get('/{referralRequest}', [ReferralRequestController::class, 'show'])->name('show');
        Route::post('/{referralRequest}/approve', [ReferralRequestController::class, 'approve'])->name('approve');
        Route::post('/{referralRequest}/reject', [ReferralRequestController::class, 'submitReject'])->name('reject');
        Route::get('/{referralRequest}/reject', [ReferralRequestController::class, 'reject'])->name('reject');
    });
    Route::resource('insurance-option', InsuranceOptionController::class)->except('show');
    Route::get('/insurance-option/search', [InsuranceOptionController::class, 'search'])
        ->name('insurance-option.search');

    Route::resource('insurance-subscription-option', InsuranceSubscriptionOptionController::class)
        ->except('show');

    Route::resource('insurance-coverage-option', InsuranceCoverageOptionController::class)->except('show');

    Route::post('/insurance-option/{insuranceOption}/fields', [InsuranceOptionFieldController::class, 'add'])
        ->name('insurance-option.field.add');
    Route::put(
        '/insurance-option/fields/{insuranceOptionField}',
        [InsuranceOptionFieldController::class, 'update']
    )
        ->name('insurance-option.field.update');
    Route::delete(
        '/insurance-option/fields/{insuranceOptionField}',
        [InsuranceOptionFieldController::class, 'delete']
    )
        ->name('insurance-option.field.destroy');
    Route::put('/insurance-option/{insuranceOption}/picture', [InsuranceOptionController::class, 'updatePicture'])
        ->name('insurance-option.update-picture');
    Route::resource('insurance-pack', InsurancePackController::class)->except('show');

    Route::prefix('/insurance-request')->name('insurance-request.')->group(function () {
        Route::get('/', [InsuranceRequestController::class, 'index'])->name('index');
        Route::get('/{insuranceRequest}', [InsuranceRequestController::class, 'show'])
            ->name('show');
        Route::post('/{insuranceRequest}/approve', [InsuranceRequestController::class, 'approve'])
            ->name('approve');
        Route::get('/{insuranceRequest}/reject', [InsuranceRequestController::class, 'reject'])
            ->name('reject');
        Route::post('/{insuranceRequest}/reject', [InsuranceRequestController::class, 'rejectSubmit'])
            ->name('reject');
    });
});

include __DIR__ . '/posts.php';
