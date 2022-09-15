<?php

use App\Http\Controllers\LogDailyLaravelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use NotificationChannels\Telegram\TelegramUpdates;

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

Route::get('ris-modality', function (Request $request) {
    Log::channel('slack-ris-modality-success')->warning("Proses masuk ke alat $request->modality Silahkan Cek!", [
        'request' => [
            'uid' => $request->uid,
            'name' => $request->name,
            'patientid' => $request->patientid,
            'mrn' => $request->mrn,
            'modality' => $request->modality,
            'prosedur' => $request->prosedur
        ]
    ]);
    // auto close
    echo '<script>window.close()</script>';
});

Route::get('/update-telegram', function () {
    // Response is an array of updates.
    $updates = TelegramUpdates::create()
        // (Optional). Get's the latest update. NOTE: All previous updates will be forgotten using this method.
        // ->latest()

        // (Optional). Limit to 2 updates (By default, updates starting with the earliest unconfirmed update are returned).
        ->limit()

        // (Optional). Add more params to the request.
        ->options([
            'timeout' => 0,
        ])
        ->get();

    dd($updates);
});

Route::get('log-laravel', [LogDailyLaravelController::class, 'index'])->name('log-laravel');
Route::get('log-laravel-detail/{id}', [LogDailyLaravelController::class, 'show'])->name('log-laravel-detail');
Route::get('log-laravel-download/{id}', [LogDailyLaravelController::class, 'download'])->name('log-laravel-download');
