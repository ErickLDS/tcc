<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\CanResetPassword;

class CreateCkUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ck_usuarios', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 20);
            $table->string('email', 80)->unique();
            $table->string('password', 256);
            $table->string('remember_token', 100)->nullable();
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
        Schema::dropIfExists('ck_usuarios');
    }
}
