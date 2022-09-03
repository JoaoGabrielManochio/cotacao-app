<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'nome',
        'idade'
    ];

    public function telefones()
    {
        return $this->hasMany(Telefone::class);
    }
}
