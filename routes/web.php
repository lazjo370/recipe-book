<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::apiResource('recipes', App\Http\Controllers\RecipeController::class);
});
