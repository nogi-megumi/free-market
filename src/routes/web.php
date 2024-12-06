<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('item_detail');
});
