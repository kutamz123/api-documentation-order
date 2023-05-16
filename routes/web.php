<?php

use App\Http\Controllers\DokterRadiologyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FailedJobController;
use App\Http\Controllers\KopSuratController;
use App\Http\Controllers\TelegramUpdateController;
use App\Http\Controllers\LogDailyLaravelController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SimrsHasilGambarExpertiseController;
use Illuminate\Support\Facades\DB;

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

Route::get('admin/intiwid/intimedika', function () {
    return view('admin.index');
})->name('admin');

// kop-surat
Route::get('kop-surat', [KopSuratController::class, 'index']);
Route::get('kop-surat/create', [KopSuratController::class, 'create']);
Route::post('kop-surat', [KopSuratController::class, 'store']);

// dokter radiologi
Route::put('dokter-radiology/{pk}', [DokterRadiologyController::class, 'update']);
Route::get('dokter-radiology/edit/{pk}', [DokterRadiologyController::class, 'edit']);
Route::get('dokter-radiology/{pk}', [DokterRadiologyController::class, 'show']);

// Telegram
Route::get('/telegram-update', TelegramUpdateController::class);

// Pasien
Route::get('/pasien/{uid}', [PasienController::class, 'show']);

// Log Laravel
Route::get('log-laravel', [LogDailyLaravelController::class, 'index'])->name('log-laravel');
Route::get('log-laravel-detail/{id}', [LogDailyLaravelController::class, 'show'])->name('log-laravel-detail');
Route::get('log-laravel-download/{id}', [LogDailyLaravelController::class, 'download'])->name('log-laravel-download');

// Jobs Queue
Route::get('jobs-queue', [JobController::class, 'index'])->name('jobs');
Route::delete('jobs-queue/delete', [JobController::class, 'destroy'])->name('queue-clear');

// Jobs Failed Queue
Route::get('jobs-failed-queue', [FailedJobController::class, 'index'])->name('failed-jobs');
Route::post('jobs-failed-queue/retry', [FailedJobController::class, 'updateAll'])->name('queue-retry-all');
Route::post('jobs-failed-queue/retry/{id}', [FailedJobController::class, 'update'])->name('queue-retry-id');
Route::delete('jobs-failed-queue/delete', [FailedJobController::class, 'destroyAll'])->name('queue-flush');
Route::delete('jobs-failed-queue/delete/{id}', [FailedJobController::class, 'destroy'])->name('queue-forget-id');

// hasil dicom dan expertise untuk simrs
Route::get('simrs-expertise/{acc}/{mrn}', [SimrsHasilGambarExpertiseController::class, 'expertise']);
Route::get('simrs-dicom/{acc}/{mrn}', [SimrsHasilGambarExpertiseController::class, 'gambarDicom']);
