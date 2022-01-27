<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'ck_pedidos';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id', 'id_usuario', 'rua', 'bairro', 'cidade', 'telefone', 'num', 'observacoes'];

    public function status() {
        return $this->hasOne(Status::class, 'id', 'id_status');
    }

    public function churros() {
        return $this->hasMany(Churros::class, 'id_pedido', 'id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function pagamento() {
        return $this->hasMany(FormaPagamento::class, 'id', 'id_forma_pagamento');
    }
}
