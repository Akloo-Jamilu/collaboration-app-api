<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::patch('/users', [UserController::class, 'update']);
