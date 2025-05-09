<?php

use App\Livewire\LoginForm;
use App\Livewire\RegisterForm;
use App\Livewire\Dashboard;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', Dashboard::class)->name('dashboard');

// Auth
Route::get('login', LoginForm::class)->name('login');
Route::get('register', RegisterForm::class)->name('register');

Route::get('profile', Profile::class)->name('profile');
