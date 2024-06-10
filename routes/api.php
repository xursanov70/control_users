<?php

use App\Http\Controllers\ControlWorkController;
use App\Http\Controllers\GetResults;
use App\Http\Controllers\GetResultsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('get/users', [RegisterController::class, 'getUsers']);
    Route::get('search/users', [RegisterController::class, 'searchUsers']);

    Route::post('start/work', [ControlWorkController::class, 'startWork']);
    Route::post('end/work', [ControlWorkController::class, 'endWork']);

    Route::get('get/results', [GetResultsController::class, 'getResults']);
    Route::get('test', [GetResultsController::class, 'test']);
});
