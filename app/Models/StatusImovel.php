<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusImovel extends Model
{
    use HasFactory;
    
    protected $fillable = ['nome'];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'status_id');
    }
}
