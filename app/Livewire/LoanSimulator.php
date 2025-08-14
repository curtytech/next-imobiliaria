<?php

namespace App\Livewire;

use App\Models\Imovel;
use Livewire\Component;

class LoanSimulator extends Component
{
    public function getAvailableProperties($maxPrice)
    {
        return Imovel::where('preco', '<=', $maxPrice)
            ->where('status', 'disponivel')
            ->count();
    }

    public function render()
    {
        return view('livewire.loan-simulator');
    }
}
