<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkChurrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ck_churros', function (Blueprint $table) {
            $table->id('id');
            $table->string('nome', 40);
            $table->integer('quantidade');
            $table->json('codigo');

            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('ck_pedidos')->onDelete('cascade');
            
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ck_churros');
    }
}
