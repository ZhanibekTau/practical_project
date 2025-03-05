<?php

use App\Http\Controllers\Attribute\AttributeController;
use App\Http\Controllers\Attribute\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::group(['prefix' => 'attributes'], function () {
        Route::post('', [AttributeController::class, 'create']);
        Route::put('{id}', [AttributeController::class, 'update'])->where(['id' => '[0-9]+']);
    });

    Route::group(['prefix' => 'projects'], function () {
        Route::post('attributes', [ProjectController::class, 'create']);
        Route::put('attributes/{id}', [ProjectController::class, 'update'])->where(['id' => '[0-9]+']);;
    });

//    Route::get('/projects', [ProjectController::class, 'index']); // Fetch projects with dynamic attributes
//    Route::get('/projects/filter', [ProjectController::class, 'filter']); // Filter projects by attributes
});
