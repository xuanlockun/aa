<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Top10;
use App\Livewire\ScoreSearch;
use App\Livewire\ScoreReport;


Route::view('/a', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/', ScoreSearch::class);

Route::get('/report', ScoreReport::class);
Route::get('/top10', Top10::class)->name('top10');
