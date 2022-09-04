<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('moeda_origem');
            $table->string('moeda_destino');
            $table->float('valor_conversao', 19, 2);
            $table->string('forma_pagamento');
            $table->float('valor_moeda_destino', 19, 2);
            $table->float('valor_comprado_moeda_destino', 19, 2);
            $table->float('taxa_pagamento', 19, 2);
            $table->float('taxa_conversao', 19, 2);
            $table->float('valor_convertido_pos_taxa', 19, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotacoes');
    }
}
