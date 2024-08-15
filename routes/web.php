<?php

use App\Livewire\HomePage;
use App\Livewire\PinsPage;
use App\Livewire\RailsPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/pins', PinsPage::class)->name('pins');
Route::get('/rails', RailsPage::class)->name('rails');
