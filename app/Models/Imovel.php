<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imovel extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'status',
        'preco',
        'area',
        'quartos',
        'banheiros',
        'vagas_garagem',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'caracteristicas',
        'fotos',
        'videos',
        'destaque',
        'area_util',
        'terreno',
        'area_constr',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'caracteristicas' => 'array',
        'fotos' => 'array',
        'videos' => 'array',
        'destaque' => 'boolean',
    ];

    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getEnderecoCompletoAttribute()
    {
        return "{$this->endereco}, {$this->bairro}, {$this->cidade} - {$this->estado}, CEP: {$this->cep}";
    }

    public function scopeDisponiveis($query)
    {
        return $query->where('status', 'disponivel');
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function getVideoIdsAttribute()
    {
        if (!$this->videos) {
            return [];
        }

        return collect($this->videos)->map(function ($videoUrl) {
            return $this->extractYouTubeId($videoUrl);
        })->filter()->toArray();
    }

    public function extractYouTubeId($url)
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
