<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


Route::post('/register', [RegisterController::class,'store'
]);
Route::post('/login', [
    LoginController::class,
    'store'
]);

// Route::middleware('auth')->group(function(){
//     Route::get('/',[Controller::class])
// });

