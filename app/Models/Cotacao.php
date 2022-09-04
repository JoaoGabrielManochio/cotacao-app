<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    protected $table = 'cotacoes';

    protected $fillable = [
        'moeda_origem',
        'moeda_destino',
        'valor_conversao',
        'forma_pagamento',
        'valor_moeda_destino',
        'valor_comprado_moeda_destino',
        'taxa_pagamento',
        'taxa_conversao',
        'valor_convertido_pos_taxa'
    ];

     /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'moeda_origem' => 'string',
        'moeda_destino' => 'string',
        'valor_conversao' => 'float',
        'valor_moeda_destino' => 'float',
        'forma_pagamento' => 'string',
        'valor_comprado_moeda_destino' => 'float',
        'taxa_pagamento' => 'float',
        'taxa_conversao' => 'float',
        'valor_convertido_pos_taxa' => 'float',
    ];
}
