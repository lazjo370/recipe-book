<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::apiResource('recipes', App\Http\Controllers\RecipeController::class);
});

Route::get('{any}', function (){
    return view('welcome');
})->where('any', '.*');


