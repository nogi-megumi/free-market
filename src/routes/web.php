<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;


Route::post('/register', [
    RegisterController::class,
    'store'
]);
Route::post('/login', [
    LoginController::class,
    'store'
]);
Route::get('/', [ItemController::class, 'index']);

Route::middleware('auth')->group(function () {
    // Route::get('/', [ItemController::class, 'index']);
    Route::get('/mypage/edit', [ProfileController::class, 'index']);
});
