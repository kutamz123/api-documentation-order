<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\MwlitemController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\API\WorkloadRadiographerController;

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
    Route::resource("workloads", WorkloadRadiographerController::class)->except(["edit", "create", "store", "update", "delete"]);
});

Route::get('export-excel', [WorkloadRadiographerController::class, 'downloadExcel']);

Route::get("documentation", function () {
    return view('documentation');
});

Route::post("register", RegisterController::class);
Route::post("login", LoginController::class);
Route::post("logout", LogoutController::class)->middleware("auth:sanctum");
