<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposSabores extends Model
{
    protected $table = 'ck_tipos_sabores';

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    use HasFactory;
}
