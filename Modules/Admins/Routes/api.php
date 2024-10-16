<?php

use Illuminate\Support\Facades\Route;
use Modules\Admins\Http\Controllers\AdminController;

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

Route::group(['middleware' => 'auth:admin-api','as'=> 'admins.','prefix' => 'admin'],
        function () {     
            Route::controller(AdminController::class)->group(function () {

                Route::middleware(['role_or_permission:show admins,admin-api'])->group(function () {
                    Route::get('show/{id}','show')
                    ->where('id', '[0-9]+');

                    Route::get('show','index');
                });

                Route::post('create','store')
                ->middleware(['role_or_permission:create admins,admin-api'])
                ->name('create');

                Route::delete('delete/{id}','destroy')
                ->middleware(['role_or_permission:delete admins,admin-api'])
                ->where('id', '[0-9]+');

                Route::put('update','update')
                ->middleware(['role_or_permission:update admins,admin-api'])
                ->name('update');

                Route::get('/me','getMe');
            });
        });

