<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\PricingCalculator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pricing');
})->name('home');


require __DIR__.'/auth.php';
