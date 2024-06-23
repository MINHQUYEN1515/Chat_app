<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('signin', 'signIn');
    Route::post('login', 'Login');
    Route::get('getuser', 'getUser')->middleware('auth:sanctum');
});
