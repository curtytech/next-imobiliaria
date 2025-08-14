<?php

namespace Database\Seeders;

use App\Models\StatusImovel;
use Illuminate\Database\Seeder;

class StatusImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Disponível',
            'Vendido',
            'Alugado',
        ];

        foreach ($tipos as $tipo) {
            StatusImovel::factory()->create(['nome' => $tipo]);
        }
    }
}
