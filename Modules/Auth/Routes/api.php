<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthUserController;
use Modules\Auth\Http\Controllers\AuthAdminController;
use Modules\Auth\Http\Controllers\EmailVerificationController;

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
Route::post('/user/register', [AuthUserController::class, 'signUp'])->middleware('guest');
Route::post('/user/login', [AuthUserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/email/verify', [EmailVerificationController::class, 'VerifyEmail']);
    Route::post('/user/logout', [AuthUserController::class, 'logout']);
    Route::get('/user/get-me', [AuthUserController::class, 'get_me']);
});

Route::post('/admin/login', [AuthAdminController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/admin/logout', [AuthUserController::class, 'logout']);
});
