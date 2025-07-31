<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis';

    protected $fillable = [
        'titulo',
        'descricao',
        'tipo_id',
        'status_id',
        'preco',
        'preco_iptu',
        'preco_condominio',
        'area',
        'quartos',
        'banheiros',
        'vagas_garagem',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'pais',
        'cep',
        'localizacao_maps',
        'caracteristicas',
        'fotos',
        'videos',
        'destaque',
        'area_util',
        'terreno',
        'area_constr',
        'corretor_id',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'preco_iptu' => 'decimal:2',
        'preco_condominio' => 'decimal:2',
        'caracteristicas' => 'array',
        'fotos' => 'array',
        'videos' => 'array',
        'destaque' => 'boolean',
    ];

    public function tipoImovel()
    {
        return $this->belongsTo(TipoImovel::class, 'tipo_id');
    }

    public function statusImovel()
    {
        return $this->belongsTo(StatusImovel::class, 'status_id');
    }

    public function corretor()
    {
        return $this->belongsTo(User::class, 'corretor_id');
    }

    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getEnderecoCompletoAttribute()
    {
        return "{$this->endereco}, {$this->bairro}, {$this->cidade} - {$this->estado}, CEP: {$this->cep}";
    }

    public function getImagemPrincipalAttribute()
    {
        return $this->fotos[0] ?? 'https://via.placeholder.com/400x250.png?text=Sem+Imagem';
    }

    public function getLocalizacaoAttribute()
    {
        return "{$this->bairro}, {$this->cidade}";
    }

    public function scopeDisponiveis($query)
    {
        return $query->whereHas('statusImovel', function($q) {
            $q->where('nome', 'Disponível');
        });
    }

    public function scopeDestaque($query)
    {
        return $query->where('destaque', true);
    }

    public function scopePorTipo($query, $tipoId)
    {
        return $query->where('tipo_id', $tipoId);
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
