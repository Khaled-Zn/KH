<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CompleteInfo\Http\Controllers\CompleteInfoController;
use Modules\CompleteInfo\Http\Controllers\InfoController;

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/user/complete-info-step-one', [CompleteInfoController::class, 'CompleteInfoStepOne']);
    Route::post('/user/complete-info-step-two', [CompleteInfoController::class, 'CompleteInfoStepTwo']);
    Route::get('/user/complete-info-stage', [CompleteInfoController::class, 'CompleteInfoStage']);
});
Route::get('/residences',[InfoController::class, 'Residences']);
Route::get('/specialities',[InfoController::class, 'Specialities']);
Route::get('/talents',[InfoController::class, 'Talents']);
Route::get('/educations',[InfoController::class, 'Educations']);
