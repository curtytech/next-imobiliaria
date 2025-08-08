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
        'situacao',
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
        'user_id',
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
        return $this->belongsTo(User::class, 'user_id');
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
        if (!empty($this->fotos) && isset($this->fotos[0])) {
            $foto = $this->fotos[0];
            // Se a foto não começar com http, assumir que é um caminho local
            if (!str_starts_with($foto, 'http')) {
                return asset('storage/' . $foto);
            }
            return $foto;
        }
        return 'https://via.placeholder.com/400x250.png?text=Sem+Imagem';
    }

    public function getFotosProcessadasAttribute()
    {
        if (!$this->fotos) {
            return [];
        }

        return collect($this->fotos)->map(function ($foto) {
            // Se a foto não começar com http, assumir que é um caminho local
            if (!str_starts_with($foto, 'http')) {
                return asset('storage/' . $foto);
            }
            return $foto;
        })->toArray();
    }

    public function getLocalizacaoAttribute()
    {
        return "{$this->bairro}, {$this->cidade}";
    }

    public function scopeDisponiveis($query)
    {
        return $query->whereHas('statusImovel', function ($q) {
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
        // Lidar com ambos os formatos: string simples ou array com chave 'url'
        if (is_array($url)) {
            $url = $url['url'] ?? '';
        }
        
        // Garantir que $url é uma string
        if (!is_string($url) || empty($url)) {
            return null;
        }

        $patterns = [
            // Padrão para youtube.com/watch?v=ID (com ou sem parâmetros adicionais)
            '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)/',
            // Padrão para youtu.be/ID (com ou sem parâmetros adicionais)
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            // Padrão para youtube.com/embed/ID
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
