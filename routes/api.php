<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->middleware('auth:sanctum')
    ->prefix('posts')
    ->name('posts')
    ->group(function () {
        Route::get('home', 'home')->name('home');
        Route::get('pins', 'pins')->name('pins');

        Route::post('create', 'create')->name('create');
    });
