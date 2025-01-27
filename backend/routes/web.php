<?php

use App\Http\Controllers\ContatosController;
use App\Http\Controllers\InstanciaController;
use App\Http\Controllers\MensagemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::controller(InstanciaController::class)->prefix('/instancias')->group(function () {
    Route::get('/', 'index')->name('instancias.index');
    Route::get('/create', 'show')->name('instancias.create');
    Route::get('/edit/{id}', 'show')->name('instancias.edit');
    Route::post('/edit/{id?}', 'editCreate')->name('instancias.editCreate');
    Route::delete('/delete/{id}', 'delete')->name('instancias.delete');
    Route::get('/vincular', 'vincular')->name('instancias.vincular');
    Route::get('/desvincular', 'vincular')->name('instancias.desvincular');
    Route::get('/qrcode/ver/{id}', 'showQrCode')->name('instancias.qrcode.ver');
});

Route::controller(MensagemController::class)->prefix('/mensagem')->group(function () {
    Route::get('/', 'index')->name('mensagem.index');
    Route::post('/enviar', 'enviarMensagem')->name('mensagem.enviar');
});

Route::controller(ContatosController::class)->prefix('/contatos')->group(function () {
    Route::get('/', 'index')->name('contatos.index');
    Route::get('/edit', 'index')->name('contatos.edit');
    Route::get('/destroy', 'index')->name('contatos.destroy');
});
