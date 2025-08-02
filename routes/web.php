<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PropertySearchResults;
use App\Livewire\LoanSimulator;
use App\Models\Imovel;
use Livewire\Volt\Volt;

// Route::get('/', Volt::route('/', 'welcome'));
Volt::route('/', 'welcome')->name('welcome');

// Route::get('/search', PropertySearchResults::class)->name('properties.search');
Volt::route('/search', 'search')->name('search');

// Property detail route
Volt::route('/imovel/{id}', 'imovel-show')->name('imovel.show');

// Loan simulator properties count endpoint
Route::post('/loan-simulator/properties-count', function () {
    $maxPrice = floatval(request()->input('maxPrice'));
    $count = Imovel::where('preco', '<=', $maxPrice)->count();

    return response()->json(['count' => $count]);
});
