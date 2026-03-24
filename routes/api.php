<?php

use App\Http\Controllers\HabitApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/habits', [HabitApiController::class, 'index']);
});
