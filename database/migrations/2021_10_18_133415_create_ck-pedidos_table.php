<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ck_pedidos', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('valor_final', 5, 2);
            $table->string('telefone', 8);
            $table->string('rua', 50);
            $table->string('bairro', 50);
            $table->string('cidade', 50);
            $table->integer('num');
            $table->longText('observacoes')->nullable();

            $table->decimal('troco', 5, 2)->nullable();

            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('ck_usuarios')->onDelete('cascade');

            $table->unsignedBigInteger('id_forma_pagamento');
            $table->foreign('id_forma_pagamento')->references('id')->on('ck_forma_pagamento');

            $table->unsignedBigInteger('id_status');
            $table->foreign('id_status')->references('id')->on('ck_status');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ck_pedidos');
    }
}
