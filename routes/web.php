<?php

use App\Livewire\LoginForm;
use App\Livewire\RegisterForm;
use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\UserSeriesList;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', Dashboard::class)->name('dashboard');

// Guest-only routes
Route::middleware('guest')->group(function () {
    Route::get('login', LoginForm::class)->name('login');
    Route::get('register', RegisterForm::class)->name('register');
});

// Authenticated-only routes
Route::middleware('auth')->group(function () {
    Route::get('profile/{id?}', Profile::class)->name('profile');
    Route::get('series-list/{id?}', UserSeriesList::class)->name('series-list');
});
