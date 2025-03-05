<?php

use App\Http\Controllers\Attribute\AttributeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Projects\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group([
    'as' => 'passport.',
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'api'], function () {
        Route::group(['prefix' => 'attributes'], function () {
            Route::post('', [AttributeController::class, 'create']);
            Route::put('{id}', [AttributeController::class, 'update'])->where(['id' => '[0-9]+']);
        });

        Route::group(['prefix' => 'projects'], function () {
            Route::get('', [ProjectController::class, 'index']);
            Route::get('filter', [ProjectController::class, 'filter']);
            Route::post('attributes', [ProjectController::class, 'create']);
            Route::put('attributes/{id}', [ProjectController::class, 'update'])->where(['id' => '[0-9]+']);;
        });
    });
});


