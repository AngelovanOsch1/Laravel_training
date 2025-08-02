<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeriesController;
use App\Http\Middleware\EnsureTokenIsValid;

Route::middleware(EnsureTokenIsValid::class)->group(function () {
    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
    Route::put('/series/{series}', [SeriesController::class, 'update'])->name('series.update');
    Route::delete('/series/{series}', [SeriesController::class, 'destroy'])->name('series.destroy');
});
