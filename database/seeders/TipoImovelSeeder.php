<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoImovel;

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
            TipoImovel::firstOrCreate(['nome' => $tipo]);
        }
    }
}
