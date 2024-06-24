<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ChatController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('signin', 'signIn');
    Route::post('login', 'Login');
    Route::get('getuser', 'getUser')->middleware('auth:sanctum');
});
Route::prefix('chat')->controller(ChatController::class)->group(function () {
    Route::post('createroom', 'createRooms')->middleware('auth:sanctum');
    Route::post('chat', 'chatMessage')->middleware('auth:sanctum');
});
