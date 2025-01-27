<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instancia_id');
            $table->string('numero_envio');
            $table->string('numero_recebimento');
            $table->text('corpo_mensagem');
            $table->boolean('enviado');
            $table->timestamps();

            $table->foreign('instancia_id')->references('id')->on('instancia')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};
