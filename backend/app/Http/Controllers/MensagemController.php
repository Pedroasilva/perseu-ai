<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index()
    {
        $estancias = Estancia::all();
        return view('mensagem.index', compact('estancias'));
    }

}
