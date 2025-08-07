<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoImovel extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_imoveis';
    protected $fillable = ['nome'];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'tipo_id');
    }
}