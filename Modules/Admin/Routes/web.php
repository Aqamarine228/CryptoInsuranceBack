<?php

use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\InsuranceOptionController;
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
});
