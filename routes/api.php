<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('authorization', function (Request $request) {
    return
        response()
        ->json(
            $request->user(),
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    // return $request->user();
})->middleware('auth:sanctum');

Route::controller(PostController::class)
    ->middleware('auth:sanctum')
    ->prefix('posts')
    ->name('posts')
    ->group(function () {
        Route::get('home', 'home')->name('home');
        Route::get('pins', 'pins')->name('pins');

        Route::post('create', 'create')->name('create');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

Route::controller(PostController::class)
    ->middleware('auth:sanctum')
    ->prefix('pins')
    ->name('pins.')
    ->group(function () {
        Route::patch('pin/{id}', 'pin')->name('pin');
        Route::patch('unpin/{id}', 'unpin')->name('unpin');
    });
