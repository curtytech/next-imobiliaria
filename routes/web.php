<?php

use Illuminate\Support\Facades\Route;
use App\Models\Imovel;
use Livewire\Volt\Volt;

Volt::route('/', 'welcome')->name('welcome');

Volt::route('/search', 'search')->name('search');

Volt::route('/imovel/{id}', 'imovel-show')->name('imovel.show');

Route::post('/loan-simulator/properties-count', function () {
    $maxPrice = floatval(request()->input('maxPrice'));
    $count = Imovel::where('preco', '<=', $maxPrice)->count();

    return response()->json(['count' => $count]);
})->name('loan-simulator.properties-count');
