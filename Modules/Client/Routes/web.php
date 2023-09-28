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


use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Controllers\AboutController;
use Modules\Client\Http\Controllers\ContactController;
use Modules\Client\Http\Controllers\Error404Controller;
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
        Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
        Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact');
        Route::get('/about', AboutController::class)->name('about');
        Route::get('/404', Error404Controller::class)->name('error404');
    });
