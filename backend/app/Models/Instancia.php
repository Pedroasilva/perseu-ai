<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instancia extends Model
{
    use SoftDeletes;

    protected $table = 'instancia';
    protected $fillable = ['nome', 'descricao', 'telefone'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
