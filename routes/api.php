<?php

use App\Order;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\MwlitemController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\API\WorkloadController;
use App\Http\Controllers\API\CreateXMLController;
use App\Http\Controllers\Auth\RegisterController;
use App\Study;
use Illuminate\Support\Facades\DB;

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


Route::middleware("auth:sanctum")->group(function () {
    Route::resource("mwlitems", MwlitemController::class)->except(["edit", "create", "store", "update", "delete"]);
    Route::resource("orders", OrderController::class)->except(["edit"]);
    Route::resource("exams", ExamController::class)->except(["edit", "delete"]);
    Route::resource("workloads", WorkloadController::class)->except(["edit", "create", "store", "update", "delete"]);
});

Route::get('export-excel', [WorkloadController::class, 'downloadExcel']);

Route::post('update-workload/{uid}', [WorkloadController::class, 'update']);

Route::get('create-xml/{uid}', function ($uid) {
    $order = Order::where('uid', $uid)->firstOrFail();
    (new CreateXMLController($order))->store();
    return "<script>
        history.back();
    </script>";
});

Route::get("documentation", function () {
    return view('documentation');
});

Route::post("register", RegisterController::class);
Route::post("login", LoginController::class);
Route::post("logout", LogoutController::class)->middleware("auth:sanctum");
