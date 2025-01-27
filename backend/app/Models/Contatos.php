<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $table = 'contatos';
    protected $fillable = ['instancia_id', 'numero', 'nome'];

    public function instancia()
    {
        return $this->belongsTo(Instancia::class);
    }

}
