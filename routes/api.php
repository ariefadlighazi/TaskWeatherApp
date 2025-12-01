<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskApiController as ApiTaskController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::apiResource('tasks', ApiTaskController::class);
});