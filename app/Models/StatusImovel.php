<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusImovel extends Model
{
    protected $fillable = ['nome'];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'status_id');
    }
}
