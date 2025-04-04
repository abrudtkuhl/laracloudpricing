<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;

Route::get('/', [PricingController::class, 'index'])->name('home');
Route::post('/api/pricing/generate', [PricingController::class, 'generateConfiguration'])->name('pricing.generate');
