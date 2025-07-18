<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoImovel extends Model
{
    protected $table = 'tipos_imoveis';
    protected $fillable = ['nome'];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'tipo_id');
    }
} 