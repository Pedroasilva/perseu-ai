<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $table = 'contatos';
    protected $fillable = ['estancia_id', 'numero', 'nome'];

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

}
