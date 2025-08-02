<?php

namespace App\Livewire;

use App\Models\Imovel;
use Livewire\Component;

class ImovelCard extends Component
{
    public Imovel $imovel;

    public function mount(Imovel $imovel)
    {
        $this->imovel = $imovel;
    }

    public function render()
    {
        return view('livewire.imovel-card');
    }
}
