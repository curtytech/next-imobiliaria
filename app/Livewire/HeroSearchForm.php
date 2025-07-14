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
        // Redirect to the search page with query parameters
        return redirect()->route('search', [
            'location' => $this->location,
            'propertyType' => $this->propertyKind,
        ]);
    }

    public function render()
    {
        return view('livewire.hero-search-form');
    }
}
