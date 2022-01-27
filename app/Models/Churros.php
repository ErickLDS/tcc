<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Churros extends Model
{
    protected $table = 'ck_churros';
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
