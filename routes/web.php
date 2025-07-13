<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;
use Livewire\Volt\Volt;


// Route::get('/', Volt::route('/', 'welcome'));
Volt::route('/', 'welcome')->name('welcome');

// Route::get('/search', PropertySearchResults::class)->name('properties.search');
Volt::route('/search', 'search')->name('search');

// Property detail route
Volt::route('/imovel/{id}', 'imovel-show')->name('imovel.show');
