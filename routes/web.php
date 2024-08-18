<?php

use App\Livewire\HomePage;
use App\Livewire\PinsPage;
use App\Livewire\RailsPage;
use App\Livewire\SettingPage;
use Illuminate\Support\Facades\Route;

//未認証のリダイレクト先
Route::get('/', HomePage::class)->name('login');

Route::get('/', HomePage::class)->name('home');
Route::get('/pins', PinsPage::class)->name('pins');
Route::get('/rails', RailsPage::class)->name('rails');

Route::get('/setting', SettingPage::class)->name('setting')->middleware('auth');
