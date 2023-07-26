<?php

use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\LoginController;

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
    Route::get('/', DashboardController::class);
});
