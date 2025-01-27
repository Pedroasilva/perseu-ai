<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';

    protected $fillable = [
        'instancia_id',
        'numero_envio',
        'numero_recebimento',
        'corpo_mensagem',
        'enviado'
    ];

    protected $casts = [
        'enviado' => 'boolean'
    ];

    public function instancia()
    {
        return $this->belongsTo(Instancia::class);
    }

    public function mensagem()
    {
        return $this->hasMany(Mensagem::class);
    }
}
