<?php

namespace Database\Seeders;

use App\Models\TipoImovel;
use Illuminate\Database\Seeder;

class TipoImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Casa',
            'Apartamento',
            'Apartamento Duplex',
            'Chalé',
            'Kitnet',
            'Sobrado',
            'Comercial',
            'Loja',
            'Galpão',
            'Pousada',
            'Prédio',
            'Sala',
            'Terreno',
            'Sítio',
            'Lote',
        ];

        foreach ($tipos as $tipo) {
            TipoImovel::factory()->create(['nome' => $tipo]);
        }
    }
}
