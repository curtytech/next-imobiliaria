<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusImovel;

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
