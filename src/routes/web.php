<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ExhibitionController;

Route::post('/register', [
    RegisterController::class,
    'store'
]);
Route::post('/login', [
    LoginController::class,
    'store'
]);
Route::get('/', [ItemController::class, 'index']);
// Route::get('/item/{id}', [ItemController::class, '']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::put('/mypage/profile', [ProfileController::class, 'update']);

    Route::get('/sell', [ExhibitionController::class, 'create']);
    Route::post('/sell', [ExhibitionController::class, 'store']);
    // Route::get('/purchase/{item}', [ParchaseController::class, '']);
    // Route::get('/purchase/address/{item}', [ParchaseController::class, '']);

});
