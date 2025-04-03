<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pricing');
})->name('home');
