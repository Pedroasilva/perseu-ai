<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemPostRequest;
use App\Models\Estancia;
use App\Models\Mensagem;
use App\Models\Contatos;
use App\Services\WhatsappApiService;
use Illuminate\Http\RedirectResponse;

class MensagemController extends Controller
{
    private WhatsappApiService $whatsAppApiService;

    public function __construct(WhatsappApiService $whatsAppApiService)
    {
        $this->whatsAppApiService = $whatsAppApiService;
    }

    public function index()
    {
        $estancias = Estancia::all();
        return view('mensagem.index', compact('estancias'));
    }

    public function enviarMensagem(MensagemPostRequest $request): RedirectResponse
    {
        $estancia = Estancia::findOrFail($request->estancia_id);
        $destinatario = $request->destinatario;
        $corpo = $request->mensagem;

        $message = $this->whatsAppApiService->sendMessage($estancia->telefone, $destinatario, $corpo);

        if (!$message['success']) {
            return redirect()->route('mensagem.index')->with('error', 'Erro ao enviar mensagem');
        }

        $this->saveMensagem($estancia, $destinatario, $corpo);
        $this->saveContato($estancia, $destinatario);

        return redirect()->route('mensagem.index')->with('success', 'Mensagem enviada com sucesso');
    }

    private function saveMensagem(Estancia $estancia, string $destinatario, string $corpo): void
    {
        $mensagem = new Mensagem();
        $mensagem->estancia_id = $estancia->id;
        $mensagem->numero_envio = $estancia->telefone;
        $mensagem->numero_recebimento = $destinatario;
        $mensagem->corpo_mensagem = $corpo;
        $mensagem->enviado = true;
        $mensagem->save();
    }

    private function saveContato(Estancia $estancia, string $destinatario): void
    {
        $contato = new Contatos();
        $contato->estancia_id = $estancia->id;
        $contato->numero = $destinatario;
        $contato->nome = $destinatario;
        $contato->save();
    }
}
