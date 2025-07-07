<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Imovel;

class ImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imoveis = [
            [
                'titulo' => 'Casa Moderna em Condomínio Fechado',
                'descricao' => 'Linda casa moderna com acabamento de alto padrão, localizada em condomínio fechado com segurança 24h. Possui 3 quartos, 2 banheiros, sala de estar, sala de jantar, cozinha planejada e área de lazer completa.',
                'tipo' => 'casa',
                'status' => 'disponivel',
                'preco' => 850000.00,
                'area' => 180,
                'quartos' => 3,
                'banheiros' => 2,
                'vagas_garagem' => 2,
                'endereco' => 'Rua das Palmeiras, 123',
                'bairro' => 'Jardim Europa',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234567',
                'caracteristicas' => [
                    'Piscina' => 'Sim',
                    'Churrasqueira' => 'Sim',
                    'Playground' => 'Sim',
                    'Academia' => 'Sim',
                ],
                'videos' => [
                    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'https://youtu.be/9bZkp7qJf00',
                ],
                'destaque' => true,
            ],
            [
                'titulo' => 'Apartamento 2 Quartos - Centro',
                'descricao' => 'Apartamento bem localizado no centro da cidade, próximo a comércio, escolas e transporte público. Ideal para investimento ou moradia.',
                'tipo' => 'apartamento',
                'status' => 'disponivel',
                'preco' => 320000.00,
                'area' => 65,
                'quartos' => 2,
                'banheiros' => 1,
                'vagas_garagem' => 1,
                'endereco' => 'Av. Paulista, 456',
                'bairro' => 'Bela Vista',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01310100',
                'caracteristicas' => [
                    'Portaria 24h' => 'Sim',
                    'Elevador' => 'Sim',
                    'Varanda' => 'Sim',
                ],
                'videos' => [
                    'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                ],
                'destaque' => false,
            ],
            [
                'titulo' => 'Terreno Residencial - Zona Sul',
                'descricao' => 'Terreno residencial com 500m², localizado em bairro tranquilo e em desenvolvimento. Ideal para construção de casa própria.',
                'tipo' => 'terreno',
                'status' => 'disponivel',
                'preco' => 180000.00,
                'area' => 500,
                'quartos' => null,
                'banheiros' => null,
                'vagas_garagem' => null,
                'endereco' => 'Rua das Flores, 789',
                'bairro' => 'Vila Nova',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '04567890',
                'caracteristicas' => [
                    'Área Plana' => 'Sim',
                    'Esgoto' => 'Sim',
                    'Água' => 'Sim',
                    'Luz' => 'Sim',
                ],
                'destaque' => false,
            ],
            [
                'titulo' => 'Sala Comercial - Shopping Center',
                'descricao' => 'Sala comercial localizada em shopping center de alto padrão, com grande fluxo de pessoas. Ideal para lojas, consultórios ou escritórios.',
                'tipo' => 'comercial',
                'status' => 'disponivel',
                'preco' => 450000.00,
                'area' => 80,
                'quartos' => null,
                'banheiros' => 1,
                'vagas_garagem' => 2,
                'endereco' => 'Shopping Plaza, 321',
                'bairro' => 'Centro Empresarial',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234567',
                'caracteristicas' => [
                    'Ar Condicionado' => 'Sim',
                    'Segurança 24h' => 'Sim',
                    'Estacionamento' => 'Sim',
                    'Elevador' => 'Sim',
                ],
                'destaque' => true,
            ],
        ];

        foreach ($imoveis as $imovel) {
            Imovel::create($imovel);
        }
    }
}
