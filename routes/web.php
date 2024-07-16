<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\TopController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

Route::get('/', TopController::class)->name('top');

Route::controller(CardController::class)
    ->middleware('auth')
    ->prefix('card')
    ->name('card.')
    ->group(function () {
        Route::post('store', 'store')->name('store');
    });
