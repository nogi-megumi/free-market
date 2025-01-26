<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StripeController;

Route::post('/register', [
    RegisterController::class,
    'store'
]);
Route::post('/login', [
    LoginController::class,
    'store'
]);
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
Route::post('/', [ItemController::class, 'search']);

Route::middleware('verify')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::put('/mypage/profile', [ProfileController::class, 'update']);
    Route::post('/comment/{item}', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/item/{item}/like', [ItemController::class, 'like'])->name('item.like');
    Route::get('/sell', [ExhibitionController::class, 'create']);
    Route::post('/sell', [ExhibitionController::class, 'store']);
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::get('/checkout/{item}', [StripeController::class, 'checkout'])->name('checkout.session');
    Route::get('success', function () {
        return view('stripe.succsess');
    })->name('success');
    Route::get('cancel', function () {
        return view('stripe.cancel');
    })->name('cancel');
});
