<?php

use App\Http\Controllers\AuthController;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

Route::get('/', HomePage::class)->name('home');
