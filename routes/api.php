<?php

use App\Http\Controllers\Attribute\AttributeController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('/attributes', [AttributeController::class, 'store']); // Create/Update attributes
//    Route::post('/projects/{project}/attributes', [ProjectController::class, 'setAttributes']); // Set attribute values
//    Route::get('/projects', [ProjectController::class, 'index']); // Fetch projects with dynamic attributes
//    Route::get('/projects/filter', [ProjectController::class, 'filter']); // Filter projects by attributes
});
