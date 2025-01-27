<?php

use App\Http\Controllers\ContatosController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\MensagemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::controller(EstanciaController::class)->prefix('/estancias')->group(function () {
    Route::get('/', 'index')->name('estancias.index');
    Route::get('/create', 'show')->name('estancias.create');
    Route::get('/edit/{id}', 'show')->name('estancias.edit');
    Route::post('/edit/{id?}', 'editCreate')->name('estancias.editCreate');
    Route::delete('/delete/{id}', 'delete')->name('estancias.delete');
    Route::get('/vincular', 'vincular')->name('estancias.vincular');
    Route::get('/desvincular', 'vincular')->name('estancias.desvincular');
    Route::get('/qrcode/ver/{id}', 'showQrCode')->name('estancias.qrcode.ver');
});

Route::controller(MensagemController::class)->prefix('/mensagem')->group(function () {
    Route::get('/', 'index')->name('mensagem.index');
    Route::post('/enviar', 'enviarMensagem')->name('mensagem.enviar');
});

Route::controller(ContatosController::class)->prefix('/contatos')->group(function () {
    Route::get('/', 'index')->name('contatos.index');
});
