<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Statistics\Http\Controllers\StatisticsController;
use Modules\Statistics\Service\StatisticsService;

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

Route::get('admin/statistics',[StatisticsController::class,'show']);