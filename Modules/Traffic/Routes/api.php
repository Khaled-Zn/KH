<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Traffic\Http\Controllers\TrafficController;

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
Route::middleware(['auth:admin-api'])->group(function () {
    Route::get('work-space/traffic',[TrafficController::class, 'GetTraffic']);
});
