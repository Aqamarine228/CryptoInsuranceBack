<?php

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


use Modules\Client\Http\Controllers\NewsController;
use Modules\Client\Http\Middleware\LocalizationMiddleware;
use Modules\Client\Http\Controllers\HomeController;

Route::get('/', fn () => redirect(locale()->default()));

Route::prefix('/{locale}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(LocalizationMiddleware::class)
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');
    });
