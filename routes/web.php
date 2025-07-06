<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', PropertySearchResults::class)->name('properties.search');
