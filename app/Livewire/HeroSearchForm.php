<?php

namespace App\Livewire;

use App\Models\TipoImovel;
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
        // Map propertyType to situacao values
        $situacao = '';
        if ($this->propertyType === 'venda') {
            $situacao = 'vende-se';
        } elseif ($this->propertyType === 'aluguel') {
            $situacao = 'aluga-se';
        }

        // Redirect to the search page with query parameters
        return redirect()->route('search', [
            'location' => $this->location,
            'propertyType' => $this->propertyKind,
            'situacao' => $situacao,
        ]);
    }

    public function render()
    {
        return view('livewire.hero-search-form', [
            'tipoImovel' => TipoImovel::all(),
        ]);
    }
}
