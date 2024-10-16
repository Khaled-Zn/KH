<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\WorkSpace\Http\Controllers\WorkSpaceController;

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
Route::get('workspace/show/{id}',[WorkSpaceController::class,'show'])
->where('id', '[0-9]+');
Route::get('workspace/index',[WorkSpaceController::class,'index']);
Route::group(['middleware' => 'auth:admin-api','as'=> 'work_spaces.','prefix' => 'admin/workspace'],
        function () {     
            Route::controller(WorkSpaceController::class)->group(function () {

                Route::get('edit','edit');
                Route::post('image/upload',[WorkSpaceController::class,'upload']);
                Route::delete('image/delete/{id}',[WorkSpaceController::class,'delete'])
                ->where('id', '[0-9]+');
                Route::put('update','update')
                ->name('update');
            });
        });
