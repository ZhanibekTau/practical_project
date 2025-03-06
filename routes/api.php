<?php

use App\Http\Controllers\Attribute\AttributeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Timesheets\TimesheetController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

Route::group([
    'as' => 'passport.',
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::middleware('auth:api')->group(function () {
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
                Route::put('attributes/{id}', [ProjectController::class, 'update'])->where(['id' => '[0-9]+']);
                Route::post('add-user', [ProjectController::class, 'addUserToProject']);
                Route::post('delete-user', [ProjectController::class, 'deleteUserFromProject']);
            });

            Route::group(['prefix' => 'tasks'], function () {
                Route::get('', [TimesheetController::class, 'index']);
                Route::get('show/{id}', [TimesheetController::class, 'show'])->where(['id' => '[0-9]+']);
                Route::post('', [TimesheetController::class, 'create']);
                Route::put('{id}', [TimesheetController::class, 'update'])->where(['id' => '[0-9]+']);
                Route::delete('{id}', [TimesheetController::class, 'delete'])->where(['id' => '[0-9]+']);
            });
        });
    });
});


