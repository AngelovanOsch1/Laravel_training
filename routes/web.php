<?php

use App\Livewire\Profile;
use App\Livewire\LoginForm;
use App\Livewire\RegisterForm;
use App\Livewire\UserSeriesList;
use Illuminate\Support\Facades\Route;

// web.php
Route::get('/', LoginForm::class)->name('login');

Route::middleware('guest')->group(function () {
    Route::get('register', RegisterForm::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('profile/{id?}', Profile::class)->name('profile');
    Route::get('series-list/{id}', UserSeriesList::class)->name('series-list');
});
