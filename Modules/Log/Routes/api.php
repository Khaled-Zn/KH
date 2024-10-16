<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Log\Http\Controllers\DailyLogController;
use Modules\Log\Http\Controllers\LogController;
use Modules\Log\Http\Controllers\SalesLogController;

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
    Route::post('log/daily-log/create-daily-log',[DailyLogController::class, 'CreateDailyLog']);
    Route::get('log/daily-log/daily-log-status',[DailyLogController::class, 'DailyLogStatus']);
    Route::get('log/show-logs',[LogController::class, 'ShowLogs']);
    Route::post('log/create-log',[LogController::class, 'CreateLog']);
    Route::get('find-user-by-number',[LogController::class, 'FindUserByNumber'])->where('number', '[0-9]+');
    Route::post('log/delete-log',[LogController::class, 'DeleteLog']);
});
Route::middleware(['auth:admin-api'])->group(function () {
    Route::get('log/sales-log/show',[SalesLogController::class, 'show']);
    Route::post('log/sales-log/add',[SalesLogController::class, 'add']);
});
