<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $fillable = [
        'numero',
        'contato_id'
    ];

    public function contato()
    {
        return $this->belongsTo(Contato::class, 'contato_id', 'id');
    }
}
