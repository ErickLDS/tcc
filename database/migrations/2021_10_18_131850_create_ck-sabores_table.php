<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCkSaboresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ck_sabores', function (Blueprint $table) {
            $table->id('id');
            $table->string('nome', 25);
            $table->decimal('adicional', 5, 2)->nullable();

            $table->unsignedBigInteger('id_tipos_sabores');
            $table->foreign('id_tipos_sabores')->references('id')->on('ck_tipos_sabores')->onDelete('cascade');

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
        Schema::dropIfExists('ck_sabores');
    }
}
