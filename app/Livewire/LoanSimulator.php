<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Imovel;

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
