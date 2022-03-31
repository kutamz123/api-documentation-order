<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware("auth:sanctum")->namespace('API')->group(function () {
    Route::resource("mwlitems", "MwlitemController")->except(["edit", "create", "store", "update", "delete"]);
    Route::resource("orders", "OrderController")->except(["edit"]);
    Route::resource("exams", "ExamController")->except(["edit", "delete"]);
    Route::resource("workloads", "WorkloadRadiographerController")->except(["edit", "create", "store", "update", "delete"]);
});


Route::get("documentation", function () {
    return view('documentation');
});

Route::namespace("Auth")->group(function () {
    Route::post("register", "RegisterController");
    Route::post("login", "LoginController");
    Route::post("logout", "LogoutController")->middleware("auth:sanctum");
});
