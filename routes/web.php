<?php

use App\Http\Controllers\LogDailyLaravelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TelegramUpdateController;

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

Route::get('/order-refresh', [OrderController::class]);

Route::get("register", function () {
    return view('register');
});

Route::get("login", function () {
    return view('login');
});

Route::get("orders", function () {
    return view('orders');
});

Route::get('/telegram-update', TelegramUpdateController::class);

Route::get('log-laravel', [LogDailyLaravelController::class, 'index'])->name('log-laravel');
Route::get('log-laravel-detail/{id}', [LogDailyLaravelController::class, 'show'])->name('log-laravel-detail');
Route::get('log-laravel-download/{id}', [LogDailyLaravelController::class, 'download'])->name('log-laravel-download');
