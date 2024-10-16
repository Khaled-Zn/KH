<?php

use Illuminate\Http\Request;
use Modules\Questionnaires\Http\Controllers\QuestionController;
use Modules\Questionnaires\Http\Controllers\QuestionnairesController;
use Illuminate\Support\Facades\Route;
use Modules\Questionnaires\Http\Controllers\UserQuestionnairesController;


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

Route::group(['middleware' => 'auth:admin-api'], function () {
    Route::post('/admin/questionnaires/create', [QuestionnairesController::class, 'create']);
    Route::get('/admin/questionnaires/getAll', [QuestionnairesController::class, 'getAll']);
    Route::delete('/admin/questionnaires/delete/{id}', [QuestionnairesController::class, 'delete']);
    Route::get('/admin/questionnaires/getByid/{id}', [QuestionnairesController::class, 'getByid']);

});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/user/questionnaires/answer', [UserQuestionnairesController::class, 'answer']);
    Route::get('/user/questionnaires/getByid/{id}', [UserQuestionnairesController::class, 'getByid']);
    Route::get('/user/questionnaires/getAll', [UserQuestionnairesController::class, 'getAll']);
});
