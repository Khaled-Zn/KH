<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\MenuController;
use Modules\Menu\Http\Controllers\MenuItemController;

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
Route::get('menu/show/{id?}',[MenuController::class,'show'])->where('id', '[0-9]+');
Route::middleware(['auth:admin-api'])->group(function () {
    Route::post('menu/menu-item/create-menu-item',[MenuItemController::class, 'create']);
    Route::put('menu/menu-item/update-menu-item',[MenuItemController::class, 'update']);
    Route::delete('menu/menu-item/delete-menu-item/{menuItem_id}',[MenuItemController::class, 'destroy']);
});
