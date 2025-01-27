<?php

namespace App\Http\Controllers;

use App\Models\Contatos;
use App\Services\WhatsappApiService;
use Illuminate\Http\Request;

class ContatosController extends Controller
{
    private WhatsappApiService $whatsAppApiService;

    public function __construct(WhatsappApiService $whatsAppApiService)
    {
        $this->whatsAppApiService = $whatsAppApiService;
    }

    public function index()
    {
        $contatos = Contatos::with('instancia')->get();
        return view('contatos.index', compact('contatos'));
    }
}
