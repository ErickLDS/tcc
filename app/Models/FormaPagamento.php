<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'ck_forma_pagamento';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
