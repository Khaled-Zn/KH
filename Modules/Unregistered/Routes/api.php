<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Unregistered\Http\Controllers\UnregisteredController;

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
        Route::post('/unregistered/complete-info', [UnregisteredController::class, 'CompleteInfo']);
    });
