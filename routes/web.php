<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

Route::get('/', TopController::class)->name('top');

Route::controller(CardController::class)
    ->prefix('card')
    ->name('card.')
    ->group(function () {
        Route::post('store', 'store')->name('store');
    });
