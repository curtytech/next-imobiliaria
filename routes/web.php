<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;
use Livewire\Volt\Volt;


// Route::get('/', Volt::route('/', 'welcome'));
Volt::route('/', 'welcome');

// Route::get('/search', PropertySearchResults::class)->name('properties.search');
Volt::route('/search', 'search');
