<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NonogramController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::prefix('nonogram')->group(function() {
    Route::middleware('auth:sanctum')->post('create', [NonogramController::class, 'create']);
    Route::get('/list', [NonogramController::class, 'list']);
    Route::get('/{id}', [NonogramController::class, 'show']);
});
