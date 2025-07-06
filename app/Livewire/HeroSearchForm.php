<?php

namespace App\Livewire;

use Livewire\Component;

class HeroSearchForm extends Component
{
    public string $propertyType = 'venda';
    public string $propertyKind = '';
    public string $location = '';

    public function setType($type)
    {
        $this->propertyType = $type;
    }

    public function search()
    {
        // Redirect to the results page with query parameters
        return redirect()->route('properties.search', [
            'tipo' => $this->propertyType,
            'categoria' => $this->propertyKind,
            'localizacao' => $this->location,
        ]);
    }

    public function render()
    {
        return view('livewire.hero-search-form');
    }
}
