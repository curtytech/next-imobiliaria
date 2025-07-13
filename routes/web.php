<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;

use App\Http\Controllers\HomeController;

Route::get('/', HomeController::class);

Route::get('/search', PropertySearchResults::class)->name('properties.search');
