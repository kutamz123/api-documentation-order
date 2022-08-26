<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::get('/order-refresh', "OrderController");

Route::get("register", function () {
    return view('register');
});

Route::get("login", function () {
    return view('login');
});

Route::get("orders", function () {
    return view('orders');
});

Route::get('log', function (Request $request) {
    Log::channel('slack-success')->warning("Proses masuk ke alat $request->modality Silahkan Cek!", [
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
