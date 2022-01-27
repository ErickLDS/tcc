<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sabores extends Model
{
    protected $table = 'ck_sabores';

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    use HasFactory;

    // Retorna o tipo de sabor relacionado
    public function tipoSabores() {
        return $this->hasOne(TipoSabores::class, 'id', 'id_tipos_sabores');
    }
}
